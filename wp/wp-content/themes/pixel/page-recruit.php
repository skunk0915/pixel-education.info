<?php get_header(); ?>
<body <?php body_class(); ?>>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv">
		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<main>
		<div class="body_bg">
			<div class="the_content">
				<?php the_content() ?>
			</div>
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>