
<form class="login" action="register.php" method="post">	
	<fieldset class="<?php echo form_row_class("username"); ?>">
		<label for="username">Usuari</label>
		<input type="text" name="username" id="username" value="<?php echo h($_POST['username']); ?>" />
		<?php echo error_for('username'); ?>
	</fieldset>
	<fieldset class="<?php echo form_row_class("email"); ?>">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" value="<?php echo h($_POST['email']); ?>" />
		<?php echo error_for('email'); ?>
	</fieldset>
	<fieldset class="<?php echo form_row_class("password"); ?>">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="" />
		<?php echo error_for('password'); ?>
	</fieldset>
	<fieldset class="<?php echo form_row_class("password_confirmation"); ?>">
		<label for="password_confirmation">Password confirmation</label>
		<input type="password" name="password_confirmation" id="password_confirmation" value="" />
		<?php echo error_for('password_confirmation'); ?>
	</fieldset>
	<fieldset>
		<label for="userlevel">User level</label>
		<select name="userlevel" id="userlevel">
			<option>Autor</option>
			<option>Editor</option>
			<option>Admin</option>
		</select>
	</fieldset>
	<fieldset>
		<input type="submit" name="submit" value="Submit" />
	</fieldset>
</form>