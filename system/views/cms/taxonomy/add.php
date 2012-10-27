	<div class="row-fluid">
		<div class="span10">
			<form action="<?php echo $this->current['next_action']; ?>" method="post" name="publicar_article">
			
			<?php foreach($langs as $lang): ?>
				<fieldset class="lang-fieldset">
					<legend><?php echo $lang->name; ?></legend>
					
					<div class="<?php echo $this->cms->error_class('title_'.$lang->code.''); ?>">
						<label for="title_<?php echo $lang->code; ?>"><?php echo $this->cms->message('title'); ?></label>
							<div class="form_error"><?php echo $this->cms->error_for('title'); ?> <?php echo $this->cms->error_for('nice_url'); ?></div>
							<input type="text" name="title_<?php echo $lang->code; ?>" id="title_<?php echo$lang->code; ?>" value="<?php echo $this->cms->input_for('title_'.$lang->code.''); ?>"/>
					</div>
					
					<div class="<?php echo $this->cms->error_class('description_'.$lang->code.''); ?>">
						<label for="description_<?php echo $lang->code; ?>"><?php echo $this->cms->message('description'); ?></label>
							<div class="form_error"><?php echo $this->cms->error_for('description'); ?></div>
							<textarea class="no_editor" name="description_<?php echo $lang->code; ?>" id="description_<?php echo$lang->code; ?>"><?php echo $this->cms->input_for('description_'.$lang->code.''); ?></textarea>
					</div>
				</fieldset>
			<?php endforeach; ?>
		</div>
		<div class="span2">
			<fieldset class="general-fieldset">
				<div class="<?php echo $this->cms->error_class('parent'); ?>">
					<label for="parent"><?php echo $this->cms->message('parent'); ?></label>
						<div class="form_error"><?php echo $this->cms->error_for('parent'); ?></div>
						<select name="parent" id="parent"> 
							<option value="0">Top level</option>
							<?php foreach($sections as $section): ?>
								<option value="<?php echo $section->identifier; ?>"><?php echo $section->title; ?></option>
							<?php endforeach; ?>
						</select>
				</div>
				
				<div class="<?php echo $this->cms->error_class('display_order'); ?>">
					<label for="display_order"><?php echo $this->cms->message('order'); ?></label>
						<div class="form_error"><?php echo $this->cms->error_for('display_order'); ?></div>
						<input type="text" name="display_order" id="display_order" value="<?php echo $this->cms->input_for('display_order','0'); ?>"/>
				</div>
			</fieldset>
		</div>
	</div>
		<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
		<input type="submit" id="submit" class="btn" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
	</form>