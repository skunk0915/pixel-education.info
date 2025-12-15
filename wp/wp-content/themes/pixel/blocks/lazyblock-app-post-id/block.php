<?php
// 記事IDの配列を取得
$app_post_ids = isset($attributes['app_post_id']) ? $attributes['app_post_id'] : [];

if (!empty($app_post_ids) && is_array($app_post_ids)) :
?>
	<div class="pixel-app-list-block">
		<ul class="app_list_wrap">
			<?php
			foreach ($app_post_ids as $item) :
				// 配列構造 { ["app_post_id"]=> int(ID) } からIDを取り出す
				$app_id = is_array($item) && isset($item['app_post_id']) ? $item['app_post_id'] : $item;
				$app_id = (int)$app_id;
				$post = get_post($app_id);

				if ($post && in_array($post->post_status, ['publish', 'private'])) :
					setup_postdata($post);

					// アプリアイコンの取得（なければデフォルト画像を使用）
					$app_icon = get_field('app_icon', $app_id);
					$has_icon = !empty($app_icon);
					$icon_url = $has_icon ? esc_url($app_icon) : esc_url(get_theme_file_uri('/img/logo_mark_pixel.png'));
			?>
					<li class="app_list_item">
						<a href="<?php echo get_permalink($app_id); ?>">

							<div class="block_a">
								<div class="app_thumbnail">
									<img src="<?php echo $icon_url; ?>" alt="<?php echo get_the_title($app_id); ?>" class="<?php echo !$has_icon ? 'default-icon' : ''; ?>">
								</div>
								<div class="status">
									<?php
									// 価格の表示
									$price = get_field('price', $app_id);
									if ($price !== '' && $price !== null && $price !== false) :
									?>
										<div class="price">
											<?php echo ($price == 0) ? '無料' : '&yen;' . esc_html($price); ?>
										</div>
									<?php endif; ?>

									<?php
									// 対象年齢の表示
									$age_min = get_field('age_min', $app_id);
									$age_max = get_field('age_max', $app_id);
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

								<h2 class="app_name"><?php echo get_the_title($app_id); ?></h2>
								<div class="app_excerpt">
									<?php
									// 関数が存在するか確認してから呼び出す、なければ標準の抜粋を表示
									if (function_exists('get_excerpt_with_linebreaks')) {
										echo get_excerpt_with_linebreaks($app_id);
									} else {
										echo get_the_excerpt($app_id);
									}
									?>
								</div>
							</div><!-- /.app_txt -->
						</a>

						<div class="store">
							<?php $ios_url = get_field('ios_url', $app_id); ?>
							<a href="<?php echo !empty($ios_url) ? esc_url($ios_url) : '#'; ?>" target="_blank" class="<?php echo empty($ios_url) ? 'hidden' : ''; ?>">
								<img src="<?php echo get_theme_file_uri(); ?>/img/btn_ios.png" alt="iPhone版アプリをダウンロードする">
							</a>
							<?php $android_url = get_field('android_url', $app_id); ?>
							<a href="<?php echo !empty($android_url) ? esc_url($android_url) : '#'; ?>" target="_blank" class="<?php echo empty($android_url) ? 'hidden' : ''; ?>">
								<img src="<?php echo get_theme_file_uri(); ?>/img/btn_android.png" alt="Android版アプリをダウンロードする">
							</a>
						</div><!-- /.store -->

						<a href="<?php echo get_permalink($app_id); ?>" class="more">もっと見る</a>


					</li>
			<?php
				endif;
			endforeach;
			wp_reset_postdata();
			?>

		</ul>
	</div>
<?php endif; ?>