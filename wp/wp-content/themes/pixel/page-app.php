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
								
								<div class="block_a">
									<div class="app_thumbnail">
										<img src="<?php echo $icon_url; ?>" alt="<?php the_title_attribute(); ?>" class="<?php echo !$has_icon ? 'default-icon' : ''; ?>">
									</div>
									<div class="status">
										<?php
										// 価格の表示
										$price = get_field('price');
										if ($price !== '' && $price !== null && $price !== false) :
										?>
											<div class="price">
												<?php echo ($price == 0) ? '無料' : '&yen;' . esc_html($price); ?>
											</div>
										<?php endif; ?>

										<?php
										// 対象年齢の表示
										$age_min = get_field('age_min');
										$age_max = get_field('age_max');
										$has_min = !empty($age_min);
										$has_max = !empty($age_max);
										?>
										<div class="age">
											<?php
											if (!$has_min && !$has_max) {
												// 両方値がない場合
												echo '全年齢';
											} elseif ($has_min && $has_max) {
												// 両方値がある場合
												if ($age_min == $age_max) {
													echo esc_html($age_min) . '歳';
												} else {
													echo esc_html($age_min) . '歳～' . esc_html($age_max) . '歳';
												}
											} elseif ($has_min) {
												// age_minのみ値がある場合
												echo esc_html($age_min) . '歳以上';
											} else {
												// age_maxのみ値がある場合
												echo esc_html($age_max) . '歳以下';
											}
											?>
										</div>
									</div>
								</div>
								<div class="app_txt">

									<h2 class="app_name"><?php the_title(); ?></h2>
									<div class="app_excerpt">
										<?php echo get_excerpt_with_linebreaks(get_the_ID()); ?>
									</div>
								</div><!-- /.app_txt -->
							</a>

							<div class="store">
								<?php $ios_url = get_field('ios_url'); ?>
								<a href="<?php echo !empty($ios_url) ? esc_url($ios_url) : '#'; ?>" target="_blank" class="<?php echo empty($ios_url) ? 'hidden' : ''; ?>">
									<img src="<?php echo get_theme_file_uri(); ?>/img/btn_ios.png" alt="iPhone版アプリをダウンロードする">
								</a>
								<?php $android_url = get_field('android_url'); ?>
								<a href="<?php echo !empty($android_url) ? esc_url($android_url) : '#'; ?>" target="_blank" class="<?php echo empty($android_url) ? 'hidden' : ''; ?>">
									<img src="<?php echo get_theme_file_uri(); ?>/img/btn_android.png" alt="Android版アプリをダウンロードする">
								</a>
							</div><!-- /.store -->

							<a href="<?php the_permalink() ?>" class="more">もっと見る</a>
							

						</li>
					<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<li>
						<p>現在、登録されているアプリはありません。</p>
					</li>
				<?php endif; ?>
			</ul><!-- /.app_list_wrap -->
		</div><!-- /.body_bg -->
	</main>
</body>
<?php get_footer(); ?>