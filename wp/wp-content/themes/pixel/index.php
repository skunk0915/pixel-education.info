<?php get_header(); ?>

<body <?php body_class(); ?>>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv">

		<?php if (is_single()) : ?>
			<p class="date"><?php echo get_the_date('Y.m.d'); ?></p>
		<?php endif; ?>
		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<main>
		<div class="body_bg">
			<?php the_content(); ?>
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>