<?php

// Security
if (!defined('ABSPATH')) exit;

if (!function_exists('mwm_variable_fonts_global_change_font_family')) {
    function mwm_variable_fonts_global_change_font_family() {

        // Preparing info
        $info = $_POST['info'];
        $atts = array();
        foreach($info as $k => $v) {
            $atts[$k] = sanitize_text_field($v);
        }

        $font_family = $atts['font_family'];
        $targets = $atts['targets'];

        // Breakpoints
        $breakpoints = array(
            array( __('Mobile', 'mwm_variable_font'), 0, 480 ), 
            array( __('Tablet', 'mwm_variable_font'), 481, 768 ), 
            array( __('Desktop', 'mwm_variable_font'), 769, 99999 )
        );

        // Add element_keys
        switch ( $targets ) {
            case 'Every tag': $elements = array( 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'code' ); break;
            case 'All tags except titles': $elements = array( 'p', 'ul', 'ol', 'code' ); break;
            case 'Only titles': $elements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ); break;
            default:
        }

        // Loop for each breakpoint
        foreach($breakpoints as $breakpoint_key => $breakpoint) {

            // Get panel id
            $panel_id = 'mwm_variable_font_panel-'.$breakpoint[1].'_'.$breakpoint[2].'_panel';

            // Loop for each element
            foreach( $elements as $element ) {

                // Get section id
                $section_id = $panel_id.'-'.$element;

                set_theme_mod( $section_id.'-selected_font', $font_family ); 
            }
        }

        wp_die();
    }

    add_action( 'wp_ajax_mwm_variable_fonts_global_change_font_family' , 'mwm_variable_fonts_global_change_font_family' );
    add_action( 'wp_ajax_nopriv_mwm_variable_fonts_global_change_font_family' , 'mwm_variable_fonts_global_change_font_family' );
}