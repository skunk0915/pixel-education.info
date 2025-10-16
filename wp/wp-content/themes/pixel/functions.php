<?php
function login_logo() {
  echo '<style type="text/css">
    #login h1 a {
      background: url('.get_template_directory_uri().'/img/logo.png) no-repeat center;
      background-size: contain;
      width: 135px;
      height: 61px;
    }
  </style>';
}
add_action('login_head', 'login_logo');


//ページスラッグをページ固有のクラス名にする
function my_body_class($classes)
{
    if (is_page()) {
        $page = get_post();
        $classes[] = $page->post_name;
    }
    return $classes;
}
add_filter('body_class', 'my_body_class');

// スクリプトの読み込み
function enqueue_theme_scripts() {
    // ページフェード処理
    wp_enqueue_script(
        'page-fade',
        get_template_directory_uri() . '/js/page_fade.js',
        array(),
        '1.0.0',
        false // headで読み込む（ページロード前に実行するため）
    );

    // termsページのみアコーディオン機能を読み込む
    if (is_page('terms')) {
        // jQuery（WordPressに同梱されているものを使用）
        wp_enqueue_script('jquery');

        // アコーディオン機能（jQueryに依存）
        wp_enqueue_script(
            'terms-action',
            get_template_directory_uri() . '/js/terms_action.js',
            array('jquery'),
            '1.0.0',
            true // footerで読み込む
        );
    }

    // メニュー機能
    wp_enqueue_script(
        'menu',
        get_template_directory_uri() . '/js/menu.js',
        array(),
        '1.0.0',
        true // footerで読み込む
    );
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

// 投稿のデフォルトスラッグを保存日時（yyyymmddhhii）にする
function set_post_slug_to_datetime($data, $postarr) {
    // 投稿タイプが'post'であることを確認
    if ($data['post_type'] !== 'post') {
        return $data;
    }

    // 新規投稿または既存投稿でスラッグが空の場合のみ処理
    // post_nameが空の場合（自動下書き含む）、または明示的にスラッグが設定されていない場合
    if (empty($data['post_name']) || $data['post_name'] === sanitize_title($data['post_title'])) {
        // 既にカスタムスラッグが設定されているかチェック
        if (!empty($postarr['ID'])) {
            $existing_post = get_post($postarr['ID']);
            // 既存投稿でカスタムスラッグが設定されている場合はスキップ
            if ($existing_post && !empty($existing_post->post_name) &&
                !preg_match('/^\d{12}$/', $existing_post->post_name) &&
                $existing_post->post_name !== sanitize_title($existing_post->post_title)) {
                return $data;
            }
        }

        // 現在の日時を取得（東京タイムゾーン）
        $current_datetime = current_time('YmdHi');
        $data['post_name'] = $current_datetime;
    }

    return $data;
}
add_filter('wp_insert_post_data', 'set_post_slug_to_datetime', 10, 2);

