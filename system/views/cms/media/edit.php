<form action="<?php echo $this->current['next_action']; ?>" method="post" name="image_field" enctype="multipart/form-data">
	
<!-- Camps per idioma -->	
<?php foreach($list as $item): ?>
	<fieldset class="lang-fieldset">
		<legend><?php echo $this->lang->get_name($item->lang); ?></legend>
		
		<div class="<?php echo $this->cms->error_class('title'); ?>">
			<label for="title_<?php echo $item->lang; ?>"><?php echo $this->cms->message('title'); ?></label>
				<div class="form_error"><?php echo $this->cms->error_for('title'); ?></div>
				<input type="text" name="title_<?php echo $item->lang; ?>" id="title_<?php echo $item->lang; ?>" value="<?php echo $this->cms->input_for('title_'.$item->lang.'', stripslashes($item->title) ); ?>"/>
		</div>
		
		<div class="<?php echo $this->cms->error_class('content'); ?>">
			<label for="content_<?php echo $item->lang; ?>"><?php echo $this->cms->message('content'); ?></label>
			<div class="form_error"><?php echo $this->cms->error_for('content'); ?></div>
			<textarea class="no_editor" name="content_<?php echo $item->lang; ?>" id="content_<?php echo $item->lang; ?>"><?php echo $this->cms->input_for('content_'.$item->lang.'', stripslashes($item->content) ); ?></textarea>
		</div>
		
		<div class="<?php echo $this->cms->error_class('description'); ?>">
			<label for="description_<?php echo $item->lang; ?>"><?php echo $this->cms->message('alternative_text'); ?></label>
			<div class="form_error"><?php echo $this->cms->error_for('description'); ?></div>
			<input type="text" name="description_<?php echo $item->lang; ?>" id="description_<?php echo $item->lang; ?>" value="<?php echo $this->cms->input_for('description_'.$item->lang.'', stripslashes($item->description) ); ?>">		
		</div>
	</fieldset>
<?php endforeach; ?>

<!-- Camps generals -->
<?php foreach($list as $item): if ($item === reset($list)): ?>
	<fieldset class="general-fieldset">
		<div class="<?php echo $this->cms->error_class('file_name') ; ?>">
			<label for="file_name"><?php echo $this->cms->message('file_name'); ?> <em class="instruction"><?php echo $this->cms->message('cannot_be_edited'); ?></em></label>
				<div class="form_error"><?php echo $this->cms->error_for('file_name'); ?></div>
				<input type="text" name="file_name" id="file_name" value="<?php echo $this->cms->input_for('file_name', $item->nice_url); ?>"/>
		</div>
	</fieldset>
<?php endif; endforeach; ?>
		
	<div>
		<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
		<input type="submit" id="submit" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
	</div>

</form>

		
