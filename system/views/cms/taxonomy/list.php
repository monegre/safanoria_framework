<ul class="dashboard-list">
	<?php foreach ($list as $item): ?>
	<li class="clear <?php echo isset($item->status) ? $item->status : ''; ?>">
		<h2><?php echo stripslashes($item->title); ?></h2>
		<ul id="item-actions" class="nolist clear">
			<li><a class="button alert" href="<?php echo $this->cms->url('remove', $item->identifier); ?>">Eliminar</a></li>
			<li><a class="button" href="<?php echo $this->cms->url('edit', $item->identifier); ?>">Editar</a></li>
		</ul>
	</li>
		<?php $sublists = Section::all(array('parent'=>$item->identifier,'lang'=>$this->administrator->clean['lang'])); ?>
		<?php foreach ($sublists as $sublist): ?>
			<li class="clear">
				<h2><?php if( ! empty($sublist->parent)): ?>– <?php endif; ?><?php echo stripslashes($sublist->title); ?></h2>
				<ul id="item-actions" class="nolist clear">
					<li><a class="button alert" href="<?php echo $this->cms->url('remove', $sublist->identifier); ?>">Eliminar</a></li>
					<li><a class="button" href="<?php echo $this->cms->url('edit', $sublist->identifier); ?>">Editar</a></li>
				</ul>
			</li>
		<?php endforeach; ?>
	
	<?php endforeach; ?>
</ul>

<a href="<?php echo $this->current['new_item']; ?>" class="btn btn-primary btn-large">
	Nova publicació
</a>