<?php if( ! isset($list) OR empty($list)): ?>

<p>Actualment no hi ha cap article a la paperera. Bona senyal!</p>

<?php else: ?>

<ul class="dashboard-list">
	<?php foreach ($list as $item): ?>
	<li class="clear">
		<h2><?php echo stripslashes($item->title); ?></h2>
		<ul id="item-actions" class="nolist clear">
			<li><a class="button alert" href="<?php echo $this->cms->url('remove', $item->identifier); ?>">Eliminar</a></li>
			<li><a class="button" href="<?php echo $this->cms->url('untrash', $item->identifier); ?>">Reactivar</a></li>
		</ul>
	</li>
	<?php if(isset($this->current['remove_confirm'])): echo $this->current['remove_confirm']; endif; ?>
	<?php endforeach; ?>
</ul>

<?php endif; ?>