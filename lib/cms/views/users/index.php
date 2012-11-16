<ul class="dashboard-list">
	<?php foreach ($list as $item): ?>
	<li class="clear">
		<h2><?php echo stripslashes($item->first_name); ?></h2>
		<ul id="item-actions" class="nolist clear">
			<?php if($this->cms->admin->id != $item->id ): ?>
			<li><a class="button alert" href="<?php echo $this->cms->url['remove_user'].'/'.$item->id; ?>">Eliminar</a></li>
			<?php endif; ?>
			<li><a class="button" href="<?php echo $this->cms->url['edit_user'].'/'.$item->id; ?>">Editar</a></li>
		</ul>
	</li>
	<?php endforeach; ?>
</ul>

<ul id="actions">
	<li><a href="<?php echo $this->current['new_item']; ?>" class="button">Nou usuari</a></li>
</ul>