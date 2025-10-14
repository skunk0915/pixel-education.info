	<header>
		<?php if (is_front_page()): ?>
			<h1 class="site_name_top">
				<a href="<?php echo home_url(); ?>">
					<img src="<?php echo get_theme_file_uri(); ?>/img/logo.png" alt="​株式会社 Pixel">
				</a>
			</h1>
		<?php else: ?>
			<div class="site_name_top">
				<a href="<?php echo home_url(); ?>">
					<img src="<?php echo get_theme_file_uri(); ?>/img/logo.png" alt="​株式会社 Pixel">
				</a>
			</div>
		<?php endif; ?>

		<nav>
			<ul>
				<li>
					<a href="<?php echo home_url(); ?>/company/">企業紹介</a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>/app/">アプリ紹介</a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>/contact/">お問い合わせ</a>
				</li>

				<li class="sp">
					<a href="<?php echo home_url(); ?>/press/">プレスリリース</a>
				</li>
				<li class="sp">
					<a href="<?php echo home_url(); ?>/recruit/">採用</a>
				</li>
				<li class="sp"><a href="<?php echo home_url(); ?>/cancel/">購入停止のご案内</a></li>
				<li class="sp"><a href="<?php echo home_url(); ?>/terms/">利用規約</a></li>
				<li class="sp"><a href="<?php echo home_url(); ?>/privacy/">プライバシーポリシー</a></li>
			</ul>
		</nav>
	</header>