<?php if( ! isset($list) OR empty($list)): ?>

<p>Actualment no hi ha cap arxiu. Vols pujar el primer?</p>

<?php else: ?>

<ul class="dashboard-list clear">
	<?php foreach ($list as $item): ?>
	<li class="clear">
		<img src="/resources/uploads/thumbs/<?php echo $item->nice_url; ?>" alt="" />
		<h2><?php echo stripslashes($item->title); ?></h2>
		<ul id="item-actions" class="nolist clear">
			<li><a class="button alert" href="<?php echo $this->cms->url('remove', $item->identifier); ?>">Eliminar</a></li>
			<li><a class="button" href="<?php echo $this->cms->url('edit', $item->identifier); ?>">Edita</a></li>
		</ul>
	</li>
	<?php endforeach; ?>
</ul>

<?php endif; ?>

<ul id="actions">
	<li><a href="<?php echo $this->current['new_item']; ?>" class="button">Nova publicació</a></li>
</ul>
