jQuery(document).ready(function($) {
    // 各h2に対して処理
    $('h2').each(function() {
        const $h2 = $(this);

        // 次のh2までのすべての要素を取得（p以外も含む）
        const $contentElements = $h2.nextUntil('h2');

        // h2と次のh2までのすべての要素をdiv.toggle_itemで包む
        $h2.add($contentElements).wrapAll('<div class="toggle_item"></div>');

        // h2以外の要素をアコーディオンコンテンツでラップ（初期状態は非表示）
        const $toggleItem = $h2.parent('.toggle_item');
        const $allContent = $toggleItem.children().not('h2');
        $allContent.wrapAll('<div class="accordion-content" style="display: none;"></div>');
    });

    // h2要素をクリック可能にするためのスタイルを追加
    $('h2').css('cursor', 'pointer');

    // h2クリック時のアコーディオン動作
    $('h2').on('click', function() {
        const $h2 = $(this);
        const $content = $h2.next('.accordion-content');

        // トグル動作
        if ($h2.hasClass('accordion-active')) {
            // 閉じる
            $content.slideUp(300);
            $h2.removeClass('accordion-active');
        } else {
            // 開く
            $content.slideDown(300);
            $h2.addClass('accordion-active');
        }
    });
});
