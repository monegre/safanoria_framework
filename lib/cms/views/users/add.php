<form action="<?php echo $this->current['next_action']; ?>" method="post" name="">
	<fieldset class="general-fieldset">	
		<div class="<?php echo $this->cms->error_class('first_name'); ?>">
			<label for="first_name"><?php echo $this->cms->message('first_name'); ?></label>
				<div class="form_error"><?php echo $this->error_for('first_name'); ?></div>
				<input type="text" name="first_name" id="first_name" value="<?php echo $this->cms->input_for('first_name'); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('last_name'); ?>">
			<label for="last_name"><?php echo $this->cms->message('last_name'); ?></label>
				<div class="form_error"><?php echo $this->error_for('last_name'); ?></div>
				<input type="text" name="last_name" id="last_name" value="<?php echo $this->cms->input_for('last_name'); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('email'); ?>">
			<label for="email"><?php echo $this->cms->message('email'); ?></label>
				<div class="form_error"><?php echo $this->error_for('email'); ?></div>
				<input type="text" name="email" id="email" value="<?php echo $this->cms->input_for('email'); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('password'); ?>">
			<label for="password"><?php echo $this->cms->message('password'); ?></label>
				<div class="form_error"><?php echo $this->error_for('password'); ?></div>
				<input type="password" name="password" id="password" value=""/>
		</div>
		<div class="<?php echo $this->cms->error_class('password_confirm'); ?>">
			<label for="password_confirm"><?php echo $this->cms->message('password_confirm'); ?></label>
				<div class="form_error"><?php echo $this->error_for('password_confirm'); ?></div>
				<input type="password" name="password_confirm" id="password_confirm" value=""/>
		</div>
		<div class="<?php echo $this->cms->error_class('lang'); ?>">
			<label for="lang"><?php echo $this->cms->message('lang'); ?></label>
				<div class="form_error"><?php echo $this->error_for('lang'); ?></div>
				<select name="lang">
					<option value="ca">Catala</option>
				</select>
		</div>
		<div class="<?php echo $this->cms->error_class('gender'); ?>">
			<label for="gender">Gender</label>
				<div class="form_error"><?php echo $this->error_for('gender'); ?></div>
				<select name="gender">
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>
		</div>
		<div class="<?php echo $this->cms->error_class('username'); ?>">
			<label for="username"><?php echo $this->cms->message('username'); ?></label>
				<div class="form_error"><?php echo $this->error_for('username'); ?></div>
				<input type="text" name="username" id="username" value="<?php echo $this->cms->input_for('username'); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('level'); ?>">
			<label for="level">Level</label>
				<div class="form_error"><?php echo $this->error_for('level'); ?></div>
				<select name="level">
					<?php foreach($levels as $level): ?>
					<option value="<?php echo $level->level; ?>"><?php echo $level->level_name.' ('.$level->level.')'; ?></option>
					<?php endforeach; ?>
				</select>
		</div>
	</fieldset>
	<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
	<input type="submit" id="submit" class="btn" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
</form>