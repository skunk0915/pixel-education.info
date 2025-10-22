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
		<?php
		wp_nav_menu(array(
			'theme_location' => wp_is_mobile() ? 'header_sp' : 'header_pc',
		));
		?>
		</nav>

	</header>