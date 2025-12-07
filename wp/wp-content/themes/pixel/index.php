<?php get_header(); ?>

<body <?php body_class(); ?>>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv">
		<?php if (is_single()) : ?>
			<time class="date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
		<?php endif; ?>

		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<main>
		<div class="body_bg">
			<?php the_content(); ?>

			<?php if (is_single()) : ?>
				<div class="page_nav">
					<?php
					$prev_post = get_previous_post(true);
					$next_post = get_next_post(true);
					?>
					<?php if ($prev_post) : ?>
						<div class="prev">
							<a href="<?php echo get_permalink($prev_post->ID); ?>">
								<time datetime="<?php echo get_the_date('c', $prev_post->ID); ?>"><?php echo get_the_date('Y.m.d', $prev_post->ID); ?></time>
								<span><?php echo get_the_title($prev_post->ID); ?></span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($next_post) : ?>
						<div class="next">
							<a href="<?php echo get_permalink($next_post->ID); ?>">
								<time datetime="<?php echo get_the_date('c', $next_post->ID); ?>"><?php echo get_the_date('Y.m.d', $next_post->ID); ?></time>
								<span><?php echo get_the_title($next_post->ID); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>