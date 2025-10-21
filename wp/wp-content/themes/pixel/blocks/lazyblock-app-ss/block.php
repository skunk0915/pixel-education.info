<ul class="app-screenshots lazyblock" style="cursor: grab;">
	<?php foreach ($attributes['app-ss'] as $image): ?>
		<li>
			<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
		</li>
	<?php endforeach; ?>
</ul>