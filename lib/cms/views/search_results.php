<p><?php echo $this->query_message; ?></p>

<ul class="search_results" id="">
	<?php foreach($list as $item): ?>
		<li>
			<h2><a href="#"><?php echo $item->title; ?></a></h2>
			<time datetime="<?php echo $item->created_at->format("Y-m-d")?>" pubdate="pubdate"><?php echo $item->created_at->format("d/m/Y")?></time>
			<p><?php echo $item->description; ?></p>
		</li>
	<?php endforeach; ?>
</ul>	