<?php get_header(); ?>

<body <?php body_class(); ?>>
	
	
	<?php get_template_part('parts/gnav'); ?>

	<section class="mv_top">
		<div class="inner">

			<div class="catch"><span class="keyword">まなび</span>を、<br class="sp">もっと自由に。</div>
			<div class="lead">小さな“できた”を、未来の力に。新しい学びのカタチをデザインする。</div>
			<nav>
				<ul>
					<li><a href="<?php echo home_url(); ?>/app/" class="pt1">アプリを見る</a></li>
					<li><a href="<?php echo home_url(); ?>/company/" class="pt2">私たちについて</a></li>
				</ul>
			</nav>
		</div><!-- /.inner -->
	</section><!-- /.mv -->

	<main class="front-page">

		<section class="mission">
			<div class="title">Pixelの約束</div>
			<h2 class="catch">まなびは、もっと自由でいい。</h2>
			<div class="body">
				<p>
					私たちは、子どもたちの「できた！」という瞬間を、いちばん大切にしています。
				</p>
				<p>
うまくいかなくても、考えて、工夫して、またやってみる。
その繰り返しこそが、未来を生きる力になると信じています。
				</p>
				<p>
「Pixel」は、子どもが自分らしく学び、想像をひろげられるアプリをつくっています。
遊びながら学び、学びながら笑顔になれる。
そんな体験を、すべての子どもに届けたい。
				</p>
				<p>
まなびの可能性は、無限です。
私たちは、子どもたちの一歩一歩に寄り添い、
その未来を、そっと照らしていきます。
				</p>
			</div>
		</section><!-- /.mission -->
	</main>
<?php get_footer(); ?>