<?php if( ! isset($list) OR empty($list)): ?>

<p>Actualment no hi ha cap contingut d'aquesta classe. Vols crear el primer?</p>

<?php else: ?>

<ul class="dashboard-list">
	<?php foreach ($list as $item): if( ! isset($item->status) OR $item->status !== 'trash'): ?>
	<li class="clear <?php echo isset($item->status) ? $item->status : ''; ?>">
		<h2><?php echo $item->title; ?></h2>
		<ul id="item-actions" class="nolist clear">
			<li><a class="button alert" href="<?php echo $this->cms->url('remove', $item->identifier); ?>">Eliminar</a></li>
			<?php if(isset($item->status)): ?>
			<li><a class="button" href="<?php echo $this->cms->url('trash', $item->identifier); ?>">Paperera</a></li>
			<?php endif; ?>
			<li><a class="button" href="<?php echo $this->cms->url('edit', $item->identifier); ?>">Editar</a></li>
		</ul>
	</li>
	<?php if(isset($this->current['remove_confirm'])): echo $this->current['remove_confirm']; endif; ?>
	<?php endif; endforeach; ?>
</ul>

<?php endif; ?>

<ul id="actions">
	<li><a href="<?php echo $this->current['new_item']; ?>" class="button">Nova publicació</a></li>
</ul>
