// ページフェード処理
(function() {
    'use strict';

    // ページ読み込み完了時に白画面をフェードアウト
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });
})();
