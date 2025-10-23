<?php
function login_logo()
{
	echo '<style type="text/css">
	#login h1 a {
	  background: url(' . get_template_directory_uri() . '/img/logo.png) no-repeat center;
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
function enqueue_theme_scripts()
{
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

	// アプリ個別ページのみスクリーンショットスワイプ機能を読み込む
	if (is_singular('app')) {
		wp_enqueue_script(
			'screenshot',
			get_template_directory_uri() . '/js/screenshot.js',
			array(),
			'1.0.0',
			true // footerで読み込む
		);

		// 関連アプリスワイプ機能を読み込む
		wp_enqueue_script(
			'relate-app',
			get_template_directory_uri() . '/js/relate-app.js',
			array(),
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

	// ol li間にpがある場合のナンバリング維持
	wp_enqueue_script(
		'ol-li-p',
		get_template_directory_uri() . '/js/ol_li_p.js',
		array(),
		'1.0.0',
		true // footerで読み込む
	);
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

// 投稿とアプリのデフォルトスラッグを保存日時（yyyymmddhhii）にする
function set_post_slug_to_datetime($data, $postarr)
{
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
			if (
				$existing_post && !empty($existing_post->post_name) &&
				!preg_match('/^\d{12}$/', $existing_post->post_name) &&
				$existing_post->post_name !== sanitize_title($existing_post->post_title)
			) {
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
function change_post_object_label()
{
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
function create_app_post_type()
{
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
		'rewrite' => array('slug' => 'apps', 'with_front' => false),
		'show_in_rest' => true
	);

	register_post_type('app', $args);
}
add_action('init', 'create_app_post_type');

//WordPressナビメニューを有効化
add_action('after_setup_theme', 'register_menu');
function register_menu()
{
	// アイキャッチ画像を有効化
	add_theme_support('post-thumbnails');

	register_nav_menus( array(
		'header_pc' => 'ヘッダー（PC）',
		'header_sp' => 'ヘッダー（スマホ）',
		'footer_1' => 'フッター左側',
		'footer_2' => 'フッター右側',
	) );
}


//Really Simple CSV Importerでの記事一括取り込みでacfの画像フィールド５個を連携させるための設定 start
add_filter('really_simple_csv_importer_save_meta', 'my_acf_multi_image_importer_save_meta', 10, 4);
// function my_acf_multi_image_importer_save_meta( $meta_value, $meta_key, $post_id, $post_data ) {
function my_acf_multi_image_importer_save_meta($meta_value, $meta_key, $post_id, $post_data = null)
{
	// 対象のACF画像フィールド名
	$acf_image_fields = array('ss_1', 'ss_2', 'ss_3', 'ss_4', 'ss_5');

	// 対象フィールドでない場合はスルー
	if (! in_array($meta_key, $acf_image_fields, true)) {
		return $meta_value;
	}

	// 画像URLが空ならスルー
	if (empty($meta_value)) {
		return $meta_value;
	}

	// URLから画像をメディアライブラリにインポート
	$image_id = my_acf_import_image_from_url($meta_value, $post_id);

	if ($image_id) {
		// ACFの画像フィールドに添付IDとして保存
		update_field($meta_key, $image_id, $post_id);
		return $image_id;
	}

	return $meta_value;
}

/**
 * URLから画像をWordPressメディアライブラリに取り込み、添付IDを返す
 */
function my_acf_import_image_from_url($image_url, $post_id = 0)
{
	if (! filter_var($image_url, FILTER_VALIDATE_URL)) {
		return false;
	}

	// すでに同じURLの添付があるか確認
	$existing = my_acf_get_attachment_id_by_url($image_url);
	if ($existing) {
		return $existing;
	}

	// WordPress標準関数をロード（必要な場合）
	if (! function_exists('media_sideload_image')) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	// 画像をサイドロード（メディアライブラリに保存）
	$media = media_sideload_image($image_url, $post_id, null, 'id');

	if (is_wp_error($media)) {
		return false;
	}

	return $media;
}

/**
 * 画像URLから添付IDを取得（重複登録を避けるため）
 */
function my_acf_get_attachment_id_by_url($url)
{
	global $wpdb;
	return $wpdb->get_var($wpdb->prepare(
		"SELECT ID FROM $wpdb->posts WHERE guid = %s AND post_type = 'attachment'",
		$url
	));
}
//Really Simple CSV Importerでの記事一括取り込みでacfの画像フィールド５個を連携させるための設定 end