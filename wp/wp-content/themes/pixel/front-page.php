<?php get_header(); ?>

<body <?php body_class(); ?>>


	<?php get_template_part('parts/gnav'); ?>


	<main class="front-page">

	<?php 
		the_content();
	?>

	</main>
	<?php get_footer(); ?>