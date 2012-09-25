$(function() {
    $("#submit-nav").hide();
    $("#nav-select select").change(function() {
        window.location = $("#nav-select select option:selected").val();
    })
});

$(document).ready(function(){	
	if (!$.browser.opera) {
		$('select.nav-select').each(function(){
			var title = $(this).attr('title');
			if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
			$(this)
				.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
				.after('<div><span class="select">' + title + '</span></div>')
				.change(function(){
					val = $('option:selected',this).text();
					$(this).next().text(val);
					})
		});
	};		
});