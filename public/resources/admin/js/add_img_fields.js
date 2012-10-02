//create a new field then append it before the add field button
$(document).ready(function() {
	$(function()
	{
		var counter = 1;
		var parent = "#img_fieldset";
		var new_field = '<div><input type="file" name="related_img[]" value="" /></div>';
		var button_id = "#add_images";
		var button = '<p id="add_images" class="button"> + </p>';
		
		$(parent).append(button);
			
		$(button_id).click(function()
		{
			if (counter < 3) 
			{
				$(this).before(new_field);
				counter ++;
			}
			if (counter == 3) 
			{
				$(button_id).hide();
			}
		});
	});
});