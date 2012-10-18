<form action="<?php echo $this->current['next_action']; ?>" method="post" name="publicar_article">

<!-- Un dallonses per cada idioma -->
<?php foreach($list as $item): ?>
	<fieldset class="lang-fieldset">	
		<legend><?php echo $this->lang->get_name($item->lang); ?></legend>
		
		<div class="<?php echo $this->cms->error_class('title_'.$item->lang.''); ?>">
			<label for="title_<?php echo $item->lang; ?>">Nom</label>
				<input type="text" name="title_<?php echo $item->lang; ?>" id="title_<?php echo $item->lang; ?>" value="<?php echo $this->cms->input_for('title_'.$item->lang.'', stripslashes($item->title) ); ?>"/>
			<?php echo $this->cms->error_for('title'); ?>
		</div>
		
		<div class="<?php echo $this->cms->error_class('description_'.$item->lang.''); ?>">
			<label for="description_<?php echo $item->lang; ?>">Descripció (per SEO i tal)</label>
				<textarea class="no_editor" name="description_<?php echo $item->lang; ?>" id="description_<?php echo$item->lang; ?>"><?php echo $this->cms->input_for('description_'.$item->lang.'', stripslashes($item->description) ); ?></textarea>
			<?php echo $this->cms->error_for('description'); ?>
		</div>
	</fieldset>

<?php endforeach; ?>

<?php foreach($list as $item): if ($item === reset($list)): ?>
	<fieldset class="general-fieldset">
		<div class="<?php echo $this->cms->error_class('parent'); ?>">
			<label for="parent"><?php echo $this->cms->message('parent'); ?></label>
				<div class="form_error"><?php echo $this->cms->error_for('parent'); ?></div>
				<select name="parent" id="parent"> 
					<option value="<?php echo $item->parent; ?>"><?php echo $item->parent; ?></option>
					<?php foreach($sections as $section): ?>
						<option value="<?php echo $section->identifier; ?>"><?php echo stripslashes($section->title); ?></option>
					<?php endforeach; ?>
					<option value="0">Top level</option>
				</select>
		</div>

		<div class="<?php echo $this->cms->error_class('nice_url'); ?>">
			<label for="nice_url"><?php echo $this->cms->message('nice_url'); ?> <em class="instruction"><?php echo $this->cms->message('can_generate_error'); ?></em></label>
				<input type="text" name="nice_url" id="nice_url" value="<?php echo $this->cms->input_for('nice_url', $item->nice_url); ?>"/>
			<?php echo $this->cms->error_for('nice_url'); ?>
		</div>
		
		<div class="<?php echo $this->cms->error_class('display_order'); ?>">
			<label for="display_order"><?php echo $this->cms->message('order'); ?></label>
				<input type="text" name="display_order" id="display_order" value="<?php echo $this->cms->input_for('display_order', $item->display_order); ?>"/>
			<?php echo $this->cms->error_for('display_order'); ?>
		</div>
	</fieldset>
<?php endif; endforeach; ?>
	
	<div>
		<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
		<input type="submit" id="submit" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
	</div>

</form>

