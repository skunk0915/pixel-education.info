	<footer>
		<div class="inner">


			<div class="company_info">
				<div class="catch">
					まなびを、もっと自由に。
				</div>

				<a href="<?php echo home_url() ?>" class="logo">
					<img src="<?php echo get_theme_file_uri(); ?>/img/logo.png" alt="​株式会社 Pixel">
				</a>
				<address>
					〒220-0072<br>
					神奈川県横浜市西区浅間町<br>
					1丁目4番3号 ウィザードビル402<br>
				</address>
			</div><!-- /.company_info -->


			<nav>
				<?php
				wp_nav_menu(array(
					'theme_location' => 'footer_1',
				));
				?>

			</nav>

			<nav>
				<?php
				wp_nav_menu(array(
					'theme_location' => 'footer_2',
				));
				?>

			</nav>

		</div><!-- /.inner -->
	</footer>

	<?php wp_footer(); ?>
	</body>

	</html>
	<?php global $template;
	$template_name = basename($template, '.php');
	echo "<!--";
	var_dump('templatename', $template_name);
	echo "-->";
	?>