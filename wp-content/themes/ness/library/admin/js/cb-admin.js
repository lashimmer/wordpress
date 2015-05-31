(function( $ ){
	
	"use strict";
	$('#tags_cb').suggest( ajaxurl + '?action=ajax-tag-search&tax=post_tag', { delay: 500, minchars: 2, multiple: true, multipleSep: ',' } );

})( jQuery );

jQuery(document).ready(function($){

	"use strict";
	var cbTypographyFontFamily = $('#cb_body_text_style-font-family'),
		cbTypographyUserPostContent = $('#setting_cb_user_post_font');

		if ( cbTypographyFontFamily.val() == 'other' ) {
			cbTypographyUserPostContent.slideDown('fast');
		} else { 
			cbTypographyUserPostContent.slideUp('fast');
		}

	cbTypographyFontFamily.change(function() {

		if ( $(this).val() == 'other' ) {
			cbTypographyUserPostContent.slideDown('fast');
		} else { 
			cbTypographyUserPostContent.slideUp('fast');
		}
		
	});
});