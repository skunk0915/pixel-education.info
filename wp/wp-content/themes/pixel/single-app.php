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

			<img src="<?php echo esc_url(get_field('app_icon')); ?>" alt="" class="app_icon">
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
			<?php the_content(); ?>
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>