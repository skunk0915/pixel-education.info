<?php get_header(); ?>
<body <?php body_class(); ?>>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv">
		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<main>
		<div class="body_bg">
			<ul class="app_list_wrap">
				<?php
				$args = array(
					'post_type' => 'app',
					'posts_per_page' => -1,
					// 'orderby' => 'date',
					// 'order' => 'DESC'
				);
				$app_query = new WP_Query($args);

				if ($app_query->have_posts()) :
					while ($app_query->have_posts()) : $app_query->the_post();
					// アプリアイコンの取得（なければデフォルト画像を使用）
					$app_icon = get_field('app_icon');
					$has_icon = !empty($app_icon);
					$icon_url = $has_icon ? esc_url($app_icon) : esc_url(get_theme_file_uri('/img/logo_mark_pixel.png'));
				?>
					<li class="app_list_item">
						<a href="<?php the_permalink(); ?>">
							<div class="app_thumbnail">
								<img src="<?php echo $icon_url; ?>" alt="<?php the_title_attribute(); ?>" class="<?php echo !$has_icon ? 'default-icon' : ''; ?>">
							</div>
							<div class="app_txt">

								<h2 class="app_name"><?php the_title(); ?></h2>
								<div class="app_excerpt">
									<?php the_excerpt(); ?>
								</div>
							</div><!-- /.app_txt -->
						</a>
					</li>
				<?php
					endwhile;
					wp_reset_postdata();
				else :
				?>
					<li><p>現在、登録されているアプリはありません。</p></li>
				<?php endif; ?>
			</ul><!-- /.app_list_wrap -->
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>