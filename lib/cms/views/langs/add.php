<form action="<?php echo $this->current['next_action']; ?>" method="post">

	<fieldset class="general-fieldset">
		<legend></legend>

		<label for="lang"><?php echo $this->cms->message('lang'); ?></label>
		<select name="lang" id="lang"> 
			<?php foreach($langs as $code => $name): ?>
				<option value="<?php echo $code; ?>"><?php echo $name; ?></option>
			<?php endforeach; ?>
		</select>
		
	</fieldset>
	
	<div>
		<input type="hidden" name="token" value="<?php echo $this->current['token']; ?>" />
		<input type="submit" id="submit" name="submit" value="<?php echo $this->cms->message('submit_post'); ?>" />
	</div>

</form>

