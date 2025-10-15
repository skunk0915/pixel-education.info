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
						<li>
							<a href="">
								<time datetime="2024-12-15">2024.12.15</time>
								<h4>新アプリ「かんじ れんしゅう」をリリースしました</h4>
								<p>
									小学生向けの漢字学習アプリが新登場。書き順アニメーションと音声読み上げ機能を搭載し、より効果的な学習をサポートします。
								</p>
							</a>
						</li>
						<li>
							<a href="">
								<time datetime="2024-12-15">2024.12.15</time>
								<h4>新アプリ「かんじ れんしゅう」をリリースしました</h4>
								<p>
									小学生向けの漢字学習アプリが新登場。書き順アニメーションと音声読み上げ機能を搭載し、より効果的な学習をサポートします。
								</p>
							</a>
						</li>
					</ul>
					<a href="" class="more">プレスリリース一覧</a>
				</div><!-- /.press -->


				<div class="update">
					<h3>更新情報</h3>
					<div class="update_bg">
						<ul>
							<li>
								<a href="">
									<time datetime="2024-12-15">2024.12.15</time>
									<h4>「ひらがな れんしゅう」アップデート v2.1.0</h4>
								</a>
							</li>
							<li>
								<a href="">
									<time datetime="2024-12-15">2024.12.15</time>
									<h4>「ひらがな れんしゅう」アップデート v2.1.0</h4>
								</a>
							</li>
							<li>
								<a href="">
									<time datetime="2024-12-15">2024.12.15</time>
									<h4>「ひらがな れんしゅう」アップデート v2.1.0</h4>
								</a>
							</li>
						</ul>
					</div>
					<a href="" class="more">更新情報一覧</a>
				</div><!-- /.update -->

			</div><!-- /.column -->
		</div><!-- /.news -->

	</main>
	<?php get_footer(); ?>