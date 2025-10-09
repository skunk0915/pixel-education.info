<?php get_header(); ?>
<body>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv">
		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<main>
		<?php the_content(); ?>
	</main>
</body>
<?php get_footer(); ?>