document.addEventListener('DOMContentLoaded', function() {
  const header = document.querySelector('header');
  const nav = header.querySelector('nav');

  // ハンバーガーボタンを作成
  const hamburger = document.createElement('button');
  hamburger.className = 'hamburger';
  hamburger.setAttribute('aria-label', 'メニューを開く');
  hamburger.innerHTML = '<span></span><span></span><span></span>';

  // ロゴの後、navの前に挿入
  header.insertBefore(hamburger, nav);

  // メニューにクラスを追加
  nav.classList.add('nav-menu');

  // ハンバーガーメニューの開閉
  hamburger.addEventListener('click', function() {
    const isOpen = nav.classList.toggle('is-open');
    hamburger.classList.toggle('is-active');
    document.body.classList.toggle('menu-open');

    // aria-label更新
    hamburger.setAttribute('aria-label', isOpen ? 'メニューを閉じる' : 'メニューを開く');
  });

  // メニュー外をクリックしたら閉じる
  document.addEventListener('click', function(e) {
    if (!header.contains(e.target) && nav.classList.contains('is-open')) {
      nav.classList.remove('is-open');
      hamburger.classList.remove('is-active');
      document.body.classList.remove('menu-open');
      hamburger.setAttribute('aria-label', 'メニューを開く');
    }
  });
});
