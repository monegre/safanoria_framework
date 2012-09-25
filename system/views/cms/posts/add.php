<form action="<?php echo $this->cms->url['add-post']; ?>" method="post" name="post_edit" enctype="multipart/form-data">

<?php foreach($langs as $lang): ?>
	<fieldset class="lang-fieldset">
		<legend><?php echo $lang->name; ?></legend>
		
		<label for="title_<?php echo $lang->code; ?>"><?php echo $this->cms->message('title'); ?></label>
			<div class="form_error"><?php echo $this->cms->error_for('title'); ?></div>
			<input type="text" name="title_<?php echo $lang->code; ?>" id="title_<?php echo $lang->code; ?>" value="<?php echo $this->cms->input_for('title_'.$lang->code.''); ?>"/>
			
			<?php if($this->current['edit'] === FALSE): ?>
				<?php echo $this->cms->error_for('nice_url'); ?>
			<?php endif; ?>
			
		<label for="content_<?php echo $lang->code; ?>"><?php echo $this->cms->message('content'); ?></label>
			<div class="form_error"><?php echo $this->cms->error_for('content'); ?></div>
			<textarea name="content_<?php echo $lang->code; ?>" id="content_<?php echo $lang->code; ?>">
				<?php echo $this->cms->input_for('content_'.$lang->code.''); ?>
			</textarea>
			
		<label for="description_<?php echo $lang->code; ?>"><?php echo $this->cms->message('excerpt'); ?></label>
			<input type="text" name="description_<?php echo $lang->code; ?>" id="description_<?php echo $lang->code; ?>" value="<?php echo $this->cms->input_for('description_'.$lang->code.''); ?>" />
			<?php echo $this->cms->error_for('description'); ?>
	</fieldset>
<?php endforeach; ?>
	<fieldset class="general-fieldset" id="img_fieldset">
		<legend>Imatges del projecte:</legend>
			<div><input type="file" name="related_img[]" id="related_img" value="" /></div>
			<p id="add_images" class="button"><?php echo $this->cms->message('more_images'); ?></p>
	</fieldset>

	<fieldset class="general-fieldset">
		<legend><?php echo $this->cms->message('field_admin'); ?></legend>
		<label for="section"><?php echo $this->cms->message('post_section'); ?></label>
		<select name="section" id="section"> 
			<?php foreach($sections as $section): ?>
				<option value="<?php echo $section->id; ?>"><?php echo $section->title; ?></option>
			<?php endforeach; ?>
		</select>
		
		<label for="categories"><?php echo $this->cms->message('categories'); ?></label>
		<?php if($this->have($cats)): ?>
			<?php foreach($cats as $cat): ?>
				<input type="checkbox" name="categories[]" value="<?php echo $cat->identifier; ?>" /> <?php echo $cat->title; ?>
			<?php endforeach; ?>
		<?php else: ?>
			<input type="text" name="categories[]" value="<?php echo $this->cms->input_for('categories', 'Uncategorized'); ?>" />
		<?php endif; ?>
				
		<label for="author"><?php echo $this->cms->message('author'); ?></label>
			<div class="form_error"><?php echo $this->cms->error_for('author'); ?></div>
			<input type="text" name="author" id="author" value="<?php echo $this->cms->input_for('author', $this->administrator->html['username']); ?>" />
		
		<label for="status"><?php echo $this->cms->message('status'); ?></label>
		<select name="status" id="status">
			<?php foreach($this->cms->post_status as $status): ?>
				<option value="<?php echo $status; ?>"><?php echo $this->message($status); ?></option>
			<?php endforeach; ?>
		</select>	
	</fieldset>
	
	<fieldset class="general-fieldset">	
		<legend>SEO</legend>	
		<label for="tags"><?php echo $this->cms->message('tags'); ?> <b><?php echo $this->cms->message('comma_separated'); ?></b></label>
			<input type="text" name="tags" id="tags" maxlength="150" value="" />
			<?php echo $this->cms->error_for('tags'); ?>
		
		<?php if($this->current['edit'] === TRUE): ?>
		<label for="nice_url"><?php echo $this->cms->message('nice_url'); ?></label>
			<input type="text" name="nice_url" id="nice_url" value="" />
			<?php echo $this->cms->error_for('nice_url'); ?>
		<?php endif; ?>
	</fieldset>
		
	<div>
		<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
		<input type="submit" id="submit" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
	</div>
	
</form>