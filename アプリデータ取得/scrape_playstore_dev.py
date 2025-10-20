"""
scrape_playstore_dev.py
Usage:
  python scrape_playstore_dev.py --dev-url "https://play.google.com/store/apps/developer?id=Pixel+Co.,+Ltd" --out pixel_apps.json --download-images ./images
"""
import argparse
import asyncio
import json
import csv
import os
import re
from urllib.parse import urljoin, urlparse, parse_qs
from pathlib import Path
from playwright.async_api import async_playwright, TimeoutError as PlaywrightTimeout

# ----- 設定 -----
DEFAULT_HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
}
NAV_TIMEOUT = 20000  # ms
DELAY_BETWEEN_APPS = 0.8  # seconds
# ------------------

# ヘルパー: パッケージ名をURLから取得
def package_from_url(url: str) -> str:
    try:
        qs = parse_qs(urlparse(url).query)
        return qs.get("id", [""])[0]
    except:
        return ""

# 安全にテキストを取得（複数セレクタを試す）
def first_text_or_empty(page, selectors):
    for s in selectors:
        try:
            el = page.query_selector(s)
            if el:
                t = el.inner_text()
                if t and t.strip():
                    return t.strip()
        except Exception:
            continue
    return ""

# 画像URL一覧の正規化（data-src / src）
async def get_image_urls_from_elements(elements):
    urls = []
    for el in elements:
        try:
            src = await el.get_attribute("src")
            if not src:
                src = await el.get_attribute("data-src")
            if src and src.startswith("//"):
                src = "https:" + src
            if src:
                urls.append(src)
        except Exception:
            continue
    # dedupe preserving order
    seen = set()
    out = []
    for u in urls:
        if u not in seen:
            out.append(u)
            seen.add(u)
    return out

# メイン：アプリ詳細抽出ルーチン
async def parse_app_page(page, url):
    await page.goto(url, timeout=NAV_TIMEOUT)
    # Wait for key element that usually loads last
    try:
        await page.wait_for_selector("h1, div[jsname]", timeout=7000)
    except PlaywrightTimeout:
        pass

    # 多重フォールバックでテキストを取得
    name = await page.locator("h1 span").inner_text().catch(lambda e: "")
    if not name:
        name = first_text_or_empty(page, [
            "h1.AHFaub span", "div.Fd93Bb", "h1"
        ])

    # short description: ストア上の一言（例: subtitle）
    short_desc = first_text_or_empty(page, [
        "meta[name='description']",
        "div.hAyfc span.htlgb",  # older layout fragments
        "div[jsname='sngebd'] > c-wiz > div:nth-child(1)",  # fallback
    ])
    # long description: 本文のより長い説明（"詳細"）
    long_desc = first_text_or_empty(page, [
        "div[jsname='sngebd']",  # dynamic content container
        "div.W4P4ne div",        # other possible container
        "div.DWPxHb"             # fallback
    ])

    # What's New（更新履歴）
    whats_new = first_text_or_empty(page, [
        "div.hAyfc:has(div:has-text('What's New')) div",  # english label
        "div.hAyfc:has(div:has-text('更新情報')) div",     # jp label
        "div[jsname='wyf3jb']"
    ])

    # key-value items (サイズ・現在のバージョン・更新日・インストール数・対象API等)
    kv_text = {}
    try:
        # find rows that commonly contain labels/values
        rows = await page.query_selector_all("div.hAyfc")
        for r in rows:
            try:
                label_el = await r.query_selector("div.BgcNfc")
                val_el = await r.query_selector("span.htlgb")
                if label_el and val_el:
                    label = (await label_el.inner_text()).strip()
                    val = (await val_el.inner_text()).strip()
                    kv_text[label] = val
            except Exception:
                continue
    except Exception:
        pass

    # rating and review count
    rating = first_text_or_empty(page, [
        "div.BHMmbe", "div.TT9eCd"
    ])
    review_count = first_text_or_empty(page, [
        "span.EymY4b span", "span.ABXkrc"
    ])

    # Category (教育、ゲームなど)
    category = ""
    try:
        cat_el = await page.query_selector("a.hrTbp.R8zArc")
        if cat_el:
            category = (await cat_el.inner_text()).strip()
    except Exception:
        pass
    if not category:
        category = kv_text.get("カテゴリ", "") or kv_text.get("Category", "")

    # developer info
    developer_name = first_text_or_empty(page, [
        "a.hrTbp.R8zArc",  # often category or developer name
        "div.KoLSrc"       # fallback
    ])
    # developer email/sitelink: search for mailto or support link
    dev_email = ""
    try:
        mail_el = await page.query_selector("a[href^='mailto:']")
        if mail_el:
            dev_email = (await mail_el.get_attribute("href")).replace("mailto:", "")
        else:
            # sometimes email appears as text
            txt = first_text_or_empty(page, ["div.IQ1z0d span", "div.hAyfc:has-text('連絡先')"])
            if "@" in txt:
                dev_email = txt
    except Exception:
        pass

    # icons and screenshots
    icon_url = ""
    try:
        ic = await page.query_selector("img.T75of")
        if ic:
            icon_url = await ic.get_attribute("src") or await ic.get_attribute("data-src") or ""
            if icon_url.startswith("//"):
                icon_url = "https:" + icon_url
    except Exception:
        pass

    # screenshots: many images use img tags with role="img" and alt contains "Screenshot"
    screenshot_urls = []
    try:
        elems = await page.query_selector_all("img[alt*='Screenshot'], img[alt*='スクリーンショット'], div.Sb9h3d img, img.T75of")
        screenshot_urls = await get_image_urls_from_elements(elems)
        # remove icon if duplicated
        screenshot_urls = [u for u in screenshot_urls if u != icon_url]
    except Exception:
        pass

    # Play Store sometimes injects JSON-LD with structured data we can parse
    ld_json = ""
    try:
        script_el = await page.query_selector("script[type='application/ld+json']")
        if script_el:
            ld_json = (await script_el.inner_text()).strip()
    except Exception:
        pass

    # assemble data
    data = {
        "url": url,
        "package": package_from_url(url),
        "name": name,
        "short_desc": short_desc,
        "full_desc": long_desc,
        "whats_new": whats_new,
        "rating": rating,
        "review_count": review_count,
        "category": category,
        "developer_name": developer_name,
        "developer_email": dev_email,
        "icon": icon_url,
        "screenshots": screenshot_urls,
        "kv": kv_text,
        "ld_json": ld_json
    }
    return data

# 取得対象：デベロッパーページのアプリ一覧を展開して個別URL取得
async def collect_app_links(page, dev_url):
    print("Opening developer page...")
    await page.goto(dev_url, timeout=NAV_TIMEOUT)
    await asyncio.sleep(3)

    # Google Play のリストはスクロールで動的にロードされる
    prev_height = 0
    for i in range(20):  # 最大20回スクロール（調整可能）
        await page.mouse.wheel(0, 3000)
        await asyncio.sleep(1.5)
        height = await page.evaluate("document.body.scrollHeight")
        if height == prev_height:
            break
        prev_height = height

    # aタグのhrefを全取得
    anchors = await page.query_selector_all("a[href*='/store/apps/details?id=']")
    urls = []
    for a in anchors:
        try:
            href = (await a.get_attribute("href")) or ""
            if href.startswith("/"):
                href = "https://play.google.com" + href
            if "/store/apps/details?id=" in href and href not in urls:
                urls.append(href)
        except Exception:
            continue

    print(f"✅ Found {len(urls)} app URLs")
    return urls


# 画像ダウンロード
import aiohttp
async def download_image(session, url, dest_path):
    try:
        async with session.get(url) as resp:
            if resp.status == 200:
                content = await resp.read()
                dest_path.parent.mkdir(parents=True, exist_ok=True)
                dest_path.write_bytes(content)
                return True
    except Exception:
        pass
    return False

# main
async def main_async(args):
    async with async_playwright() as p:
        browser = await p.chromium.launch(headless=True)
        context = await browser.new_context(user_agent=DEFAULT_HEADERS["User-Agent"], locale="ja-JP")
        page = await context.new_page()
        dev_url = args.dev_url
        print("Collecting app links from developer page...")
        app_links = await collect_app_links(page, dev_url)
        print(f"Found {len(app_links)} app links (deduped).")

        results = []
        # optional image download setup
        image_download = bool(args.download_images)
        image_dir = Path(args.download_images) if image_download else None
        if image_download:
            image_dir.mkdir(parents=True, exist_ok=True)

        # start aiohttp session for images
        aio_session = None
        if image_download:
            import aiohttp
            aio_session = aiohttp.ClientSession()

        for idx, app_url in enumerate(app_links, start=1):
            print(f"[{idx}/{len(app_links)}] Fetching {app_url}")
            try:
                data = await parse_app_page(page, app_url)
                results.append(data)

                # download images if requested
                if image_download:
                    tasks = []
                    # icon
                    if data.get("icon"):
                        parsed = urlparse(data["icon"])
                        name = f"{data['package']}_icon{Path(parsed.path).suffix}"
                        dest = image_dir / name
                        await download_image(aio_session, data["icon"], dest)
                        data["icon_local"] = str(dest)
                    # screenshots
                    data["screenshots_local"] = []
                    for si, s_url in enumerate(data.get("screenshots", []), start=1):
                        parsed = urlparse(s_url)
                        ext = Path(parsed.path).suffix or ".jpg"
                        name = f"{data['package']}_ss{si}{ext}"
                        dest = image_dir / name
                        ok = await download_image(aio_session, s_url, dest)
                        if ok:
                            data["screenshots_local"].append(str(dest))
                await asyncio.sleep(DELAY_BETWEEN_APPS)
            except Exception as e:
                print("Error parsing app:", e)
                continue

        if aio_session:
            await aio_session.close()

        # save JSON
        out_path = Path(args.out)
        out_path.write_text(json.dumps(results, ensure_ascii=False, indent=2), encoding="utf-8")
        print("Saved JSON ->", out_path)

        # save CSV (flatten important fields)
        csv_path = out_path.with_suffix(".csv")
        with csv_path.open("w", newline="", encoding="utf-8") as f:
            writer = csv.writer(f)
            header = ["package", "name", "short_desc", "full_desc", "rating", "review_count",
                      "category", "developer_name", "developer_email", "icon", "screenshots", "kv_json", "url"]
            writer.writerow(header)
            for r in results:
                writer.writerow([
                    r.get("package",""),
                    r.get("name",""),
                    r.get("short_desc",""),
                    r.get("full_desc",""),
                    r.get("rating",""),
                    r.get("review_count",""),
                    r.get("category",""),
                    r.get("developer_name",""),
                    r.get("developer_email",""),
                    r.get("icon",""),
                    "|".join(r.get("screenshots",[])),
                    json.dumps(r.get("kv",{}), ensure_ascii=False),
                    r.get("url","")
                ])
        print("Saved CSV ->", csv_path)

        await browser.close()

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--dev-url", required=True, help="Developer page URL")
    parser.add_argument("--out", default="pixel_apps.json", help="Output JSON file")
    parser.add_argument("--download-images", default="", help="Directory to save images (optional)")
    args = parser.parse_args()
    asyncio.run(main_async(args))
