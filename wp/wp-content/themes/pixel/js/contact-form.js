/**
 * お問い合わせフォームの条件付きフィールド表示とオーバーレイ制御
 */

document.addEventListener('DOMContentLoaded', function() {
    // お問い合わせ種類のセレクトボックス
    const inquiryTypeSelect = document.querySelector('select[name="inquiry-type"]');

    // 条件付き表示フィールド（アプリ名とOS）
    const appNameField = document.querySelector('.wpcf7-form-control-wrap[data-name="app-name"]');
    const osTypeField = document.querySelector('.wpcf7-form-control-wrap[data-name="os-type"]');

    // 条件付き表示フィールドの親要素（p要素またはfieldset）を取得
    const appNameParent = appNameField ? appNameField.closest('p') : null;
    const osTypeParent = osTypeField ? osTypeField.closest('fieldset') : null;

    /**
     * フィールドの表示/非表示を切り替える
     */
    function toggleConditionalFields() {
        if (!inquiryTypeSelect || !appNameParent || !osTypeParent) {
            return;
        }

        const selectedValue = inquiryTypeSelect.value;

        if (selectedValue === 'アプリについて') {
            // 「アプリについて」が選択された場合は表示
            appNameParent.style.display = 'block';
            osTypeParent.style.display = 'block';
        } else {
            // それ以外は非表示
            appNameParent.style.display = 'none';
            osTypeParent.style.display = 'none';
        }
    }

    // 初期表示時の処理
    if (inquiryTypeSelect) {
        // 初期状態では非表示
        if (appNameParent) appNameParent.style.display = 'none';
        if (osTypeParent) osTypeParent.style.display = 'none';

        // セレクトボックスの変更を監視
        inquiryTypeSelect.addEventListener('change', toggleConditionalFields);
    }

    /**
     * 送信完了メッセージのオーバーレイ表示
     */
    document.addEventListener('wpcf7mailsent', function(event) {
        const responseOutput = event.target.querySelector('.wpcf7-response-output');

        if (responseOutput) {
            // オーバーレイ用のクラスを追加
            responseOutput.classList.add('wpcf7-response-overlay');

            // フェードイン表示
            setTimeout(function() {
                responseOutput.classList.add('show');
            }, 100);

            // 3秒後に自動的にフェードアウト（オプション）
            setTimeout(function() {
                responseOutput.classList.remove('show');
                setTimeout(function() {
                    responseOutput.classList.remove('wpcf7-response-overlay');
                }, 300);
            }, 3000);
        }
    });
});
