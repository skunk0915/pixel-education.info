<?php

?>
<?php get_header(); ?>

<body <?php body_class(); ?>>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv mv_app">
		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<style>
		.mv_app::before {
			background-image: url('<?php echo esc_url(get_field('app_icon')); ?>');
		}
	</style>
	<main>
		<div class="body_bg">

			<div class="app_summary">
				<img src="<?php echo esc_url(get_field('app_icon')); ?>" alt="" class="app_icon">
				<div class="info">
					<div class="app_name">
						<?php the_title(); ?>
					</div>
					<div class="status">


						<?php
						// 価格の表示
						$price = get_field('price');
						if ($price !== '' && $price !== null && $price !== false) :
						?>
							<div class="price">
								<?php echo ($price == 0) ? '無料' : esc_html($price); ?>
							</div>
						<?php endif; ?>

						<?php
						// 対象年齢の表示
						$age_min = get_field('age_min');
						$age_max = get_field('age_max');
						$has_min = !empty($age_min);
						$has_max = !empty($age_max);
						?>
						<div class="age">
							対象：<?php
								if (!$has_min && !$has_max) {
									// 両方値がない場合
									echo '全年齢';
								} elseif ($has_min && $has_max) {
									// 両方値がある場合
									if ($age_min == $age_max) {
										echo esc_html($age_min) . '歳';
									} else {
										echo esc_html($age_min) . '歳～' . esc_html($age_max) . '歳';
									}
								} elseif ($has_min) {
									// age_minのみ値がある場合
									echo esc_html($age_min) . '歳以上';
								} else {
									// age_maxのみ値がある場合
									echo esc_html($age_max) . '歳以下';
								}
								?>
						</div>
					</div><!-- /.status -->
					<div class="store">
						<a href="<?php echo get_field('ios_url') ?>" class="ios" target="_blank">
							<img src="<?php echo get_theme_file_uri(); ?>/img/btn_ios.png" alt="iPhone版アプリをダウンロードする">
						</a>
						<a href="<?php echo get_field('android_url') ?>" class="android" target="_blank">
							<img src="<?php echo get_theme_file_uri(); ?>/img/btn_android.png" alt="Android版アプリをダウンロードする">
						</a>
					</div>

				</div><!-- /.info -->
			</div><!-- /.app_summary -->

			<div class="body">
				<?php the_content(); ?>
			</div>


		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>
