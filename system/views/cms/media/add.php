<form action="<?php echo $this->cms->url['add-media']; ?>" method="post" name="image_field" enctype="multipart/form-data">
	<fieldset class="general-fieldset">
		<label for="file"><?php echo $this->cms->message('select_file'); ?></label>
		<input type="file" name="file" id="file" />
		<div class="form_error">
			<ol>
				<li><?php echo $this->upload->error_for('type'); ?></li>
				<li><?php echo $this->upload->error_for('size'); ?></li>
				<li><?php echo $this->upload->error_for('file'); ?></li>
			</ol>
		</div>
	</fieldset>
	
<?php foreach($langs as $lang): ?>
	<fieldset class="lang-fieldset">
		<legend><?php echo $lang->name; ?></legend>
		
		<div class="<?php echo $this->cms->error_class('title'); ?>">
			<label for="title_<?php echo $lang->code; ?>"><?php echo $this->cms->message('title'); ?></label>
				<div class="form_error"><?php echo $this->cms->error_for('title'); ?></div>
				<input type="text" name="title_<?php echo $lang->code; ?>" id="title_<?php echo $lang->code; ?>" value="<?php echo $this->cms->input_for('title_'.$lang->code.''); ?>"/>
		</div>
		
		<div class="<?php echo $this->cms->error_class('content'); ?>">
			<label for="content_<?php echo $lang->code; ?>"><?php echo $this->cms->message('content'); ?></label>
			<div class="form_error"><?php echo $this->cms->error_for('content'); ?></div>
			<textarea class="no_editor" name="content_<?php echo $lang->code; ?>" id="content_<?php echo $lang->code; ?>">
				<?php echo $this->cms->input_for('content_'.$lang->code.''); ?>
			</textarea>
		</div>
		
		<div class="<?php echo $this->cms->error_class('description'); ?>">
			<label for="description_<?php echo $lang->code; ?>"><?php echo $this->cms->message('alternative_text'); ?></label>
			<div class="form_error"><?php echo $this->cms->error_for('description'); ?></div>
				<input type="text" name="description_<?php echo $lang->code; ?>" id="description_<?php echo $lang->code; ?>" value="<?php echo $this->cms->input_for('description_'.$lang->code.''); ?>">		
		</div>
		
		
	</fieldset>
<?php endforeach; ?>
		
	<div>
		<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
		<input type="submit" id="submit" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
	</div>

</form>

		
