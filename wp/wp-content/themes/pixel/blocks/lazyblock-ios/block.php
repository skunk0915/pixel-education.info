<?php
$url = $attributes['url'] ?? '#';
?>

<a href="<?php echo esc_url($url); ?>" class="btn_ios" target="_blank">
	<img src="<?php echo esc_url(get_template_directory_uri() . '/img/btn_ios.png'); ?>" alt="iOSアプリダウンロード">
</a>