(function() {
	var viewports = ['0_480', '481_768', '769_99999'];
	jQuery(document).on('ready', function() {
		jQuery(
			'#accordion-panel-mwm_variable_font_panel-0_480_panel h3'
		).addClass('dashicons-before dashicons-smartphone');
		jQuery(
			'#accordion-panel-mwm_variable_font_panel-481_768_panel h3'
		).addClass('dashicons-before dashicons-tablet');
		jQuery(
			'#accordion-panel-mwm_variable_font_panel-769_99999_panel h3'
		).addClass('dashicons-before dashicons-desktop');
		jQuery(
			'#accordion-section-mwm_variable_font_panel-general_section h3'
		).addClass('dashicons-before dashicons-chart-line');
		jQuery(
			'#accordion-section-mwm_variable_font_panel-multi-general_section h3'
		).addClass('dashicons-before dashicons-edit');

		// Modify the viewport on select viewport panel - mobile
		jQuery('#accordion-panel-mwm_variable_font_panel-0_480_panel').on(
			'click',
			function() {
				jQuery('#customize-footer-actions .preview-mobile').click();
			}
		);

		// Modify the viewport on select viewport panel - tablet
		jQuery('#accordion-panel-mwm_variable_font_panel-481_768_panel').on(
			'click',
			function() {
				jQuery('#customize-footer-actions .preview-tablet').click();
			}
		);

		// Modify the viewport on select viewport panel - desktop
		jQuery('#accordion-panel-mwm_variable_font_panel-769_99999_panel').on(
			'click',
			function() {
				jQuery('#customize-footer-actions .preview-desktop').click();
			}
		);

		jQuery('#mwm-control-reset-defaults').on('click', function() {
			if (confirm(ajax_vars.confirm_message)) {
				var btn = jQuery(this);
				var btn_message = '';
				info = {
					base: jQuery(
						'#mwm_variable_font_panel-general_section-base'
					).val(),
					modular_scale: jQuery(
						'#_customize-input-mwm_variable_font_panel-general_section-ratio'
					).val()
				};

				jQuery.ajax({
					type: 'POST',
					url: ajax_vars.ajax,
					data: {
						action: 'mwm_variable_fonts_reset_configuration',
						info: info
					},
					beforeSend: function() {
						btn.prop('disabled', true);
						btn_message = btn.text();
						btn.text(ajax_vars.loading_message);
					},
					success: function(response) {
						console.log(response);
					},
					complete: function() {
						setTimeout(function() {
							wp.customize.previewer.refresh();
							jQuery('#save').click();
							btn.prop('disabled', false);
							btn.text(btn_message);
						}, 1000);
					}
				});
			}
		});

		jQuery('#mwm-control-change-font-family').on('click', function() {
			if (confirm(ajax_vars.confirm_message_font_size)) {
				var btn = jQuery(this);
				var btn_message = '';
				info = {
					font_family: jQuery(
						'#_customize-input-mwm_variable_font_panel-multi-general_section-selected_font'
					).val(),
					targets: jQuery(
						'#_customize-input-mwm_variable_font_panel-multi-general_section-selected_target'
					).val()
				};

				jQuery.ajax({
					type: 'POST',
					url: ajax_vars.ajax,
					data: {
						action: 'mwm_variable_fonts_global_change_font_family',
						info: info
					},
					beforeSend: function() {
						btn.prop('disabled', true);
						btn_message = btn.text();
						btn.text(ajax_vars.loading_message);
					},
					success: function(response) {},
					complete: function() {
						setTimeout(function() {
							wp.customize.previewer.refresh();
							jQuery('#save').click();
							btn.prop('disabled', false);
							btn.text(btn_message);
							window.location.reload(true);
						}, 1000);
					}
				});
			}
		});

		// jQuery('#customize-footer-actions .preview-mobile').on(
		// 	'click',
		// 	function() {
		// 		var element = jQuery(
		// 			'#customize-theme-controls .control-section-mwm_custom_section.open'
		// 		);
		// 		if (element.length > 0) {
		// 			var id = element.attr('id');
		// 			if (
		// 				!id.includes('0_480_panel') &&
		// 				(id.includes('481_768_panel') ||
		// 					id.includes('769_99999_panel'))
		// 			) {
		// 				element.removeClass('open');
		// 				id = id.split('-');
		// 				id[id.length - 2] = '0_480_panel';
		// 				id = '#' + id.join('-');
		// 				jQuery(id).addClass('open');
		// 				jQuery(id + ' .customize-section-back').trigger(
		// 					'click'
		// 				);
		// 			}
		// 		}
		// 	}
		// );
	});
})();
