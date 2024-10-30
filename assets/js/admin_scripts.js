jQuery(document).ready(function() {
	jQuery('#mwm-variable-font-i-know').on('click', function() {
		var admin_notice = jQuery(this).closest('.notice');
		jQuery.ajax({
			type: 'POST',
			url: ajax_vars.ajax,
			data: {
				action: 'mwm_variable_font_uncheck_admin_notice'
			},
			beforeSend: function() {},
			success: function(response) {},
			complete: function() {
				admin_notice.remove();
			}
		});
	});
});
