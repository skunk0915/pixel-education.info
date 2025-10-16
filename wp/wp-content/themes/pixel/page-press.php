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
	'posts_per_page' => 2,
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

	<style>
		.press-tabs {
			display: flex;
			gap: 10px;
			margin-bottom: 30px;
			border-bottom: 2px solid #e0e0e0;
		}

		.press-tab {
			padding: 12px 24px;
			background: none;
			border: none;
			cursor: pointer;
			font-size: 16px;
			color: #666;
			transition: all 0.3s;
			border-bottom: 3px solid transparent;
			margin-bottom: -2px;
		}

		.press-tab:hover {
			color: #333;
		}

		.press-tab.active {
			color: #333;
			font-weight: bold;
			border-bottom-color: #333;
		}

		.press-list {
			display: flex;
			flex-direction: column;
			gap: 30px;
		}

		.press-item {
			padding: 20px;
			border: 1px solid #e0e0e0;
			border-radius: 8px;
		}

		.press-item time {
			display: block;
			color: #999;
			font-size: 14px;
			margin-bottom: 10px;
		}

		.press-item h2 {
			margin: 0 0 10px 0;
			font-size: 20px;
		}

		.press-item h2 a {
			color: #333;
			text-decoration: none;
		}

		.press-item h2 a:hover {
			text-decoration: underline;
		}

		.press-excerpt {
			color: #666;
			line-height: 1.6;
		}

		.press-pagination {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 10px;
			margin-top: 40px;
		}

		.press-pagination a,
		.press-pagination .current-page {
			padding: 8px 12px;
			text-decoration: none;
			color: #333;
			border: 1px solid #e0e0e0;
			border-radius: 4px;
		}

		.press-pagination a:hover {
			background: #f5f5f5;
		}

		.press-pagination .current-page {
			background: #333;
			color: #fff;
			border-color: #333;
		}

		.page-numbers {
			display: flex;
			gap: 5px;
		}
	</style>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const tabs = document.querySelectorAll('.press-tab');
			const baseUrl = '<?php echo $base_url; ?>';

			tabs.forEach(tab => {
				tab.addEventListener('click', function() {
					const tabName = this.getAttribute('data-tab');
					window.location.href = baseUrl + '?tab=' + tabName;
				});
			});
		});
	</script>
</body>
<?php get_footer(); ?>