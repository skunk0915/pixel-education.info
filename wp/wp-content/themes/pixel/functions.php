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

// 投稿とアプリのデフォルトスラッグを保存日時（yyyymmddhhii）にする
function set_post_slug_to_datetime($data, $postarr) {
    // 投稿タイプが'post'または'app'であることを確認
    if (!in_array($data['post_type'], array('post', 'app'))) {
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

// 投稿の名称を「ニュース」に変更
function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'ニュース';
    $labels->singular_name = 'ニュース';
    $labels->add_new = '新規追加';
    $labels->add_new_item = '新しいニュースを追加';
    $labels->edit_item = 'ニュースを編集';
    $labels->new_item = '新しいニュース';
    $labels->view_item = 'ニュースを表示';
    $labels->search_items = 'ニュースを検索';
    $labels->not_found = 'ニュースが見つかりませんでした';
    $labels->not_found_in_trash = 'ゴミ箱にニュースはありません';
    $labels->all_items = 'すべてのニュース';
    $labels->menu_name = 'ニュース';
    $labels->name_admin_bar = 'ニュース';
}
add_action('init', 'change_post_object_label');

// カスタム投稿タイプ「アプリ」を追加
function create_app_post_type() {
    $labels = array(
        'name' => 'アプリ',
        'singular_name' => 'アプリ',
        'add_new' => '新規追加',
        'add_new_item' => '新しいアプリを追加',
        'edit_item' => 'アプリを編集',
        'new_item' => '新しいアプリ',
        'view_item' => 'アプリを表示',
        'search_items' => 'アプリを検索',
        'not_found' => 'アプリが見つかりませんでした',
        'not_found_in_trash' => 'ゴミ箱にアプリはありません',
        'all_items' => 'すべてのアプリ',
        'menu_name' => 'アプリ',
        'name_admin_bar' => 'アプリ'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-smartphone',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'app', 'with_front' => false),
        'show_in_rest' => true
    );

    register_post_type('app', $args);
}
add_action('init', 'create_app_post_type');

