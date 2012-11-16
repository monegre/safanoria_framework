<form action="<?php echo $this->cms->url['edit_user'].'/'.$item->id; ?>" method="post" name="">
	<fieldset class="general-fieldset">	
		<div class="<?php echo $this->cms->error_class('first_name'); ?>">
			<label for="first_name"><?php echo $this->cms->message('first_name'); ?></label>
				<div class="form_error"><?php echo $this->error_for('first_name'); ?></div>
				<input type="text" name="first_name" id="first_name" value="<?php echo $this->cms->input_for('first_name', $item->first_name); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('last_name'); ?>">
			<label for="last_name"><?php echo $this->cms->message('last_name'); ?></label>
				<div class="form_error"><?php echo $this->error_for('last_name'); ?></div>
				<input type="text" name="last_name" id="last_name" value="<?php echo $this->cms->input_for('last_name', $item->last_name); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('email'); ?>">
			<label for="email"><?php echo $this->cms->message('email'); ?></label>
				<div class="form_error"><?php echo $this->error_for('email'); ?></div>
				<input type="text" name="email" id="email" value="<?php echo $this->cms->input_for('email', $item->email); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('old_password'); ?>">
			<label for="old_password">Old Password</label>
				<div class="form_error"><?php echo $this->error_for('old_password'); ?></div>
				<input type="password" name="old_password" id="old_password" value=""/>
		</div>
		<div class="<?php echo $this->cms->error_class('new_password'); ?>">
			<label for="new_password">New Password</label>
				<div class="form_error"><?php echo $this->error_for('new_password'); ?></div>
				<input type="password" name="new_password" id="new_password" value=""/>
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
					<option value="<?php echo $item->lang; ?>"><?php echo $this->cms->lang->get_name($item->lang); ?></option>
					<option value="ca">Catala</option>
				</select>
		</div>
		<div class="<?php echo $this->cms->error_class('gender'); ?>">
			<label for="gender">Gender</label>
				<div class="form_error"><?php echo $this->error_for('gender'); ?></div>
				<select name="gender">
					<option value="<?php echo $item->gender; ?>"><?php echo $item->gender; ?></option>
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>
		</div>
		<div class="<?php echo $this->cms->error_class('username'); ?>">
			<label for="username"><?php echo $this->cms->message('username'); ?></label>
				<div class="form_error"><?php echo $this->error_for('username'); ?></div>
				<input type="text" name="username" id="username" value="<?php echo $this->cms->input_for('username', $item->username); ?>"/>
		</div>
		<div class="<?php echo $this->cms->error_class('level'); ?>">
			<label for="level">Level</label>
				<div class="form_error"><?php echo $this->error_for('level'); ?></div>
				<select name="level">
					<option value="<?php echo $item->level; ?>"><?php echo $item->level; ?></option>
					<?php foreach($levels as $level): ?>
					<option value="<?php echo $level->level; ?>"><?php echo $level->level_name.' ('.$level->level.')'; ?></option>
					<?php endforeach; ?>
				</select>
		</div>
	</fieldset>
	<input type="hidden" name="user_confirm_id" value="<?php echo $item->id; ?>">
	<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
	<input type="submit" id="submit" class="btn" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
</form>