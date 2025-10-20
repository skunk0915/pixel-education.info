<?php
/**
 * Template Name: Press Page
 */

// 現在のタブとページを取得
$current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'press';
$paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

// カテゴリー名を設定
$category_name = ($current_tab === 'update') ? 'update' : 'press';

// クエリを実行
$press_query = new WP_Query(array(
	'category_name' => $category_name,
	'posts_per_page' => 10,
	'paged' => $paged,
	'orderby' => 'date',
	'order' => 'DESC'
));

$max_pages = $press_query->max_num_pages;

// ページネーション用のベースURLを生成
$base_url = get_permalink();
?>

<?php get_header(); ?>
<body <?php body_class(); ?>>

	<?php get_template_part('parts/gnav'); ?>
	<section class="mv">
		<h1><?php the_title(); ?></h1>
	</section><!-- /.mv -->
	<main>
		<div class="body_bg">
			<?php the_content(); ?>

			<!-- タブナビゲーション -->
			<div class="press-tabs">
				<button class="press-tab <?php echo $current_tab === 'press' ? 'active' : ''; ?>" data-tab="press">プレスリリース</button>
				<button class="press-tab <?php echo $current_tab === 'update' ? 'active' : ''; ?>" data-tab="update">更新情報</button>
			</div>

			<!-- タブコンテンツ -->
			<div class="press-content">
				<?php if ($press_query->have_posts()) : ?>
					<div class="press-list">
						<?php while ($press_query->have_posts()) : $press_query->the_post(); ?>
							<article class="press-item">
								<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php if ($current_tab === 'press') : ?>
									<div class="press-excerpt">
										<?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?>
									</div>
								<?php endif; ?>
							</article>
						<?php endwhile; ?>
					</div>

					<!-- ページネーション -->
					<?php if ($max_pages > 1) : ?>
						<div class="press-pagination">
							<?php if ($paged > 1) : ?>
								<?php
								$prev_page = $paged - 1;
								$prev_url = ($prev_page == 1) ? $base_url . '?tab=' . $current_tab : $base_url . 'page/' . $prev_page . '/?tab=' . $current_tab;
								?>
								<a href="<?php echo $prev_url; ?>" class="prev-page">前へ</a>
							<?php endif; ?>

							<span class="page-numbers">
								<?php
								for ($i = 1; $i <= $max_pages; $i++) {
									if ($i == $paged) {
										echo '<span class="current-page">' . $i . '</span>';
									} else {
										$page_url = ($i == 1) ? $base_url . '?tab=' . $current_tab : $base_url . 'page/' . $i . '/?tab=' . $current_tab;
										echo '<a href="' . $page_url . '">' . $i . '</a>';
									}
								}
								?>
							</span>

							<?php if ($paged < $max_pages) : ?>
								<?php
								$next_page = $paged + 1;
								$next_url = $base_url . 'page/' . $next_page . '/?tab=' . $current_tab;
								?>
								<a href="<?php echo $next_url; ?>" class="next-page">次へ</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				<?php else : ?>
					<p>記事が見つかりませんでした。</p>
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>
			</div>
		</div><!-- /.body_bg -->
	</main>


	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const tabs = document.querySelectorAll('.press-tab');

			tabs.forEach(tab => {
				tab.addEventListener('click', function() {
					const tabName = this.getAttribute('data-tab');
					window.location.href = '?tab=' + tabName + '&paged=1';
				});
			});
		});
	</script>
</body>
<?php get_footer(); ?>