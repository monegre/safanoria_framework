// Create new input file fields
$(document).ready(function() {
	$(function()
	{
		var counter = 1;
		var max_field_num = 5;
		var parent = "#img_fieldset";
		var new_field = '<div><input type="file" name="related_img[]" value="" /></div>';
		var button_id = "#add_images";
		var button = '<p id="add_images" class="button"> + </p>';
		
		$(parent).append(button);
			
		$(button_id).click(function()
		{
			if (counter < max_field_num) 
			{
				$(this).before(new_field);
				counter ++;
			}
			if (counter == max_field_num) 
			{
				$(button_id).hide();
			}
		});
	});
});