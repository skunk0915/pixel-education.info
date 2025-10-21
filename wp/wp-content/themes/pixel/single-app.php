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
					<div class="price"><?php echo get_field('price'); ?></div>
					<div class="age">対象：<?php echo get_field('age_min'); ?>歳～<?php echo get_field('age_max'); ?>歳</div>
					<div class="store">
						<a href="" class="ios">
							<img src="" alt="">
						</a>
						<a href="" class="android">
							<img src="" alt="">
						</a>
					</div>
				</div><!-- /.info -->
			</div><!-- /.app_summary -->

			<?php
			// ACFカスタムフィールド ss_1 から ss_5 の画像を表示
			$screenshots = array();
			for ($i = 1; $i <= 5; $i++) {
				$field_name = 'ss_' . $i;
				$image = get_field($field_name);
				if ($image) {
					$screenshots[] = $image;
				}
			}

			if (!empty($screenshots)) :
			?>
				<ul class="app-screenshots">
					<?php foreach ($screenshots as $screenshot) : ?>
						<li>
							<?php if (is_array($screenshot)) : ?>
								<img src="<?php echo esc_url($screenshot['url']); ?>" alt="<?php echo esc_attr($screenshot['alt']); ?>">
							<?php else : ?>
								<img src="<?php echo esc_url($screenshot); ?>" alt="">
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<div class="excerpt">
				<?php echo get_field('excerpt'); ?>
			</div>
			<div class="body">
				<?php the_content(); ?>
			</div>
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>