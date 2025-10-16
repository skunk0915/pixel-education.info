<?php get_header(); ?>
<body <?php body_class(); ?>>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv">
		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<main>
		<div class="body_bg">
			<div class="app_list_wrap">
				<?php
				$args = array(
					'post_type' => 'app',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'DESC'
				);
				$app_query = new WP_Query($args);

				if ($app_query->have_posts()) :
					while ($app_query->have_posts()) : $app_query->the_post();
				?>
					<article class="app_list_item">
						<?php if (has_post_thumbnail()) : ?>
							<div class="app_thumbnail">
								<?php the_post_thumbnail('medium'); ?>
							</div>
						<?php endif; ?>
						<h2 class="app_name"><?php the_title(); ?></h2>
						<div class="app_excerpt">
							<?php the_excerpt(); ?>
						</div>
						<a href="<?php the_permalink(); ?>" class="app_link">詳細を見る</a>
					</article>
				<?php
					endwhile;
					wp_reset_postdata();
				else :
				?>
					<p>現在、登録されているアプリはありません。</p>
				<?php endif; ?>
			</div><!-- /.app_list_wrap -->
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>