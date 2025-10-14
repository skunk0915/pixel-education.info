	<footer>
		<div class="inner">


			<div class="company_info">
				<div class="catch">
					まなびを、もっと自由に。
				</div>
				<a href="" class="logo">
					<img src="<?php echo get_theme_file_uri(); ?>/img/logo.png" alt="​株式会社 Pixel">
				</a>
				<address>
					〒220-0072<br>
					神奈川県横浜市西区浅間町<br>
					1丁目4番3号 ウィザードビル402<br>
				</address>
			</div><!-- /.company_info -->
			<nav>
				<ul>
					<li>
						<a href="<?php echo home_url(); ?>/company/">企業紹介</a>
					</li>
					<li>
						<a href="<?php echo home_url(); ?>/app/">アプリ紹介</a>
					</li>
					<li>
						<a href="<?php echo home_url(); ?>/press/">プレスリリース</a>
					</li>
					<li>
						<a href="<?php echo home_url(); ?>/recruit/">採用</a>
					</li>
					<li>
						<a href="<?php echo home_url(); ?>/contact/">お問い合わせ</a>
					</li>

				</ul>
			</nav>
			<nav>
				<ul>
					<li><a href="<?php echo home_url(); ?>/cancel/">購入停止のご案内</a></li>
					<li><a href="<?php echo home_url(); ?>/terms/">利用規約</a></li>
					<li><a href="<?php echo home_url(); ?>/privacy/">プライバシーポリシー</a></li>
				</ul>
			</nav>
		</div><!-- /.inner -->
	</footer>

<?php wp_footer(); ?>
</body>

</html>
<?php global $template;
	$template_name = basename($template, '.php');
	echo "<!--";var_dump('templatename',$template_name);echo "-->";
?>
