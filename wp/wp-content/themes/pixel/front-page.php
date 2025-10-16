<?php get_header(); ?>

<body <?php body_class(); ?>>


	<?php get_template_part('parts/gnav'); ?>


	<main class="front-page">

		<?php the_content(); ?>

		<div class="news">
			<h2>最新情報</h2>

			<div class="column">


				<div class="press">
					<h3>プレスリリース</h3>
					<ul>
						<?php
						$press_query = new WP_Query(array(
							'category_name' => 'press',
							'posts_per_page' => 4,
							'orderby' => 'date',
							'order' => 'DESC'
						));

						if ($press_query->have_posts()) :
							while ($press_query->have_posts()) : $press_query->the_post();
						?>
						<li>
							<a href="<?php the_permalink(); ?>">
								<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
								<h4><?php the_title(); ?></h4>
								<p>
									<?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?>
								</p>
							</a>
						</li>
						<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</ul>
					<a href="<?php echo home_url('/press/'); ?>" class="more">プレスリリース一覧</a>
				</div><!-- /.press -->


				<div class="update">
					<h3>更新情報</h3>
					<div class="update_bg">
						<ul>
							<?php
							$update_query = new WP_Query(array(
								'category_name' => 'update',
								'posts_per_page' => 4,
								'orderby' => 'date',
								'order' => 'DESC'
							));

							if ($update_query->have_posts()) :
								while ($update_query->have_posts()) : $update_query->the_post();
							?>
							<li>
								<a href="<?php the_permalink(); ?>">
									<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
									<h4><?php the_title(); ?></h4>
								</a>
							</li>
							<?php
								endwhile;
								wp_reset_postdata();
							endif;
							?>
						</ul>
					</div>
					<a href="<?php echo home_url('/press/'); ?>" class="more">更新情報一覧</a>
				</div><!-- /.update -->

			</div><!-- /.column -->
		</div><!-- /.news -->

	</main>
	<?php get_footer(); ?>