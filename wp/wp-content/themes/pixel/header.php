<!doctype html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>pixel</title>
	<meta name="description" content="">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri(); ?>/css/ress.min.css?v=1.0">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri(); ?>/css/pc.css?v=1.0" media="(min-width: 768px)">
	<link rel="stylesheet" href="<?php echo get_theme_file_uri(); ?>/css/sp.css?v=1.0" media="(max-width: 767px)">
	<link rel="icon" href="<?php echo get_theme_file_uri(); ?>/img/favicon/favicon.ico" sizes="any"><!-- 32×32 -->
	<link rel="icon" href="<?php echo get_theme_file_uri(); ?>/img/favicon/favicon.svg" type="image/svg+xml">
	<link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png"><!-- 180×180 -->
	<link rel="<?php echo get_theme_file_uri(); ?>/img/favicon/manifest" href="<?php echo get_theme_file_uri(); ?>/manifest.webmanifest">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@500&display=swap" rel="stylesheet">
	<style>
		/* ページ読み込み中は白画面を表示 */
		body::before {
			content: '';
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: #ffffff;
			z-index: 9999;
			transition: opacity 1s ease-out;
		}
		body.loaded::before {
			opacity: 0;
			pointer-events: none;
		}
	</style>
	<?php wp_head(); ?>
</head>