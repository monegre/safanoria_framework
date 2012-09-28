<form action="<?php echo $this->current['next_action']; ?>" method="post" name="post_edit" enctype="multipart/form-data">

<!-- Camps per idioma -->
<?php foreach($list as $item): ?>
	<fieldset class="lang-fieldset">
		<legend><?php echo $this->lang->get_name($item->lang); ?></legend>
		
		<label for="title_<?php echo $item->lang; ?>"><?php echo $this->cms->message('title'); ?></label>
			<input type="text" name="title_<?php echo $item->lang; ?>" id="title_<?php echo $item->lang; ?>" value="<?php echo $this->cms->input_for('title_'.$item->lang.'', $item->title); ?>"/>
			<?php echo $this->cms->error_for('title_'.$item->lang.''); ?>
			
		<label for="content_<?php echo $item->lang; ?>"><?php echo $this->cms->message('content'); ?></label>
			<textarea name="content_<?php echo $item->lang; ?>" id="content_<?php echo $item->lang; ?>">
				<?php echo $this->cms->input_for('content_'.$item->lang.'', $item->content); ?>
			</textarea>
			<?php echo $this->cms->error_for('content_'.$item->lang.''); ?>
			
		<label for="description_<?php echo $item->lang; ?>"><?php echo $this->cms->message('excerpt'); ?></label>
			<input type="text" name="description_<?php echo $item->lang; ?>" id="description_<?php echo $item->lang; ?>" value="<?php echo $this->cms->input_for('description_'.$item->lang.'', $item->description); ?>" />
			<?php echo $this->cms->error_for('description_'.$item->lang.''); ?>
	</fieldset>
<?php endforeach; ?>

<!-- Camps generals -->
<?php foreach($list as $item): if ($item === reset($list)): ?>	
	<fieldset class="general-fieldset">
		<legend><?php echo $this->cms->message('field_admin'); ?></legend>
		<label for="section"><?php echo $this->cms->message('post_section'); ?></label>
		<select name="section" id="section"> 
			<option value="<?php echo $item->section; ?>"><?php echo $item->section; ?></option>
			<?php foreach($sections as $section): ?>
				<option value="<?php echo $section->id; ?>"><?php echo $section->title; ?></option>
			<?php endforeach; ?>
		</select>
				
		<label for="categories"><?php echo $this->cms->message('categories'); ?></label>
		<?php $a = explode(',', $item->categories); $count = count($a); ?>			
		<?php if($this->have($cats)): ?>
			<?php foreach($cats as $cat): ?>
				<input type="checkbox" name="categories[]" value="<?php echo $cat->identifier; ?>" 
				<?php for ($i = 0; $i < $count; $i++) {if($a[$i] == $cat->identifier) echo "checked";} ?>/> <?php echo $cat->title; ?>
			<?php endforeach; ?>
		<?php else: ?>
			<input type="text" name="categories[]" value="<?php echo $this->cms->input_for('categories', 'Uncategorized'); ?>" />
		<?php endif; ?>
		
		<label for="author"><?php echo $this->cms->message('author'); ?></label>
			<input type="text" name="author" id="author" value="<?php echo $this->cms->input_for('author', $item->author); ?>" />
		
		<label for="status"><?php echo $this->cms->message('status'); ?></label>
		<select name="status" id="status">
			<option value="<?php echo $item->status; ?>"><?php echo $item->status; ?></option>
			<?php foreach($this->cms->post_status as $status): ?>
				<option value="<?php echo $status; ?>"><?php echo $this->message($status); ?></option>
			<?php endforeach; ?>
		</select>	
	</fieldset>
	
	<fieldset class="general-fieldset">	
		<legend>SEO</legend>	
		<label for="tags"><?php echo $this->cms->message('tags'); ?> <b><?php echo $this->cms->message('comma_separated'); ?></b></label>
			<input type="text" name="tags" id="tags" maxlength="150" value="<?php echo $this->cms->input_for('tags', $item->tags); ?>" />
		
		<div class="<?php echo $this->cms->error_class('nice_url'); ?>">
			<label for="nice_url"><?php echo $this->cms->message('nice_url'); ?></label>
				<input type="text" name="nice_url" id="nice_url" value="<?php echo $this->cms->input_for('nice_url', $item->nice_url); ?>"/>
			<?php echo $this->cms->error_for('nice_url'); ?>
		</div>
	</fieldset>
	
	<fieldset class="general-fieldset" id="img_fieldset">
		<legend>Imatges del projecte:</legend>
			<?php if($medias > 0): ?>
			<ul class="nolist">
			<?php foreach($medias as $media): ?>
				<li>
					<img src="/public/resources/uploads/thumbs/<?php echo $media->nice_url; ?>" alt="" />
					<p><?php echo $media->nice_url; ?></p>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			
			<div><input type="file" name="related_img[]" id="related_img" value="" /></div>
			<p id="add_images" class="button"><?php echo $this->cms->message('more_images'); ?></p>
	</fieldset>
	
<?php endif; endforeach; ?>
		
	<div>
		<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
		<input type="submit" id="submit" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
	</div>
	
</form>