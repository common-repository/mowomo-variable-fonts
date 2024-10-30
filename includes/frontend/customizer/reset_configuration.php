<?php

// Security
if (!defined('ABSPATH')) exit;

if (!function_exists('mwm_variable_fonts_reset_configuration')) {
    function mwm_variable_fonts_reset_configuration() {

        // Preparing info
        $info = $_POST['info'];
        $atts = array();
        foreach($info as $k => $v) {
            $atts[$k] = sanitize_text_field($v);
        }

        $base = floatval($atts['base']);
        $modular_scale = floatval($atts['modular_scale']);

        // Breakpoints
        $breakpoints = array(
            array( __('Mobile', 'mwm_variable_font'), 0, 480 ), 
            array( __('Tablet', 'mwm_variable_font'), 481, 768 ), 
            array( __('Desktop', 'mwm_variable_font'), 769, 99999 )
        );

        // Add fonts
        $fonts = array(
            'Inter var experimental' => 'Inter var',
            'Montserrat' => 'Montserrat',
            'Sudo Variable' => 'Sudo Variable',
            'Graduate' => 'Graduate',
            'Recursive' => 'Recursive',
            'Science Gothic' => 'Science Gothic',
            'Estedad' => 'Estedad'
        );
        asort($fonts);
        $fonts = array('Select a font' => __('Select a font', 'mwm_variable_font')) + $fonts;

        // Add element_keys
        $elements = array( 
            'p'     => 3,
            'h1'    => 10,
            'h2'    => 9,
            'h3'    => 8,
            'h4'    => 7,
            'h5'    => 6,
            'h6'    => 5,
            'ul'    => 3,
            'ol'    => 3,
            'code'  => 3
        );

        $ratios = array( pow( $modular_scale, 0 ), pow( $modular_scale, 2 ), pow( $modular_scale, 3 ) );

        // Loop for each breakpoint
        foreach($breakpoints as $breakpoint_key => $breakpoint) {

            // Get panel id
            $panel_id = 'mwm_variable_font_panel-'.$breakpoint[1].'_'.$breakpoint[2].'_panel';

            // Loop for each element
            foreach( $elements as $element_key => $element_value ) {

                // Get section id
                $section_id = $panel_id.'-'.$element_key;

                // Loop for each font
                foreach( $fonts as $font_key => $font_value ) {

                    $prop_id = $section_id.'-'.mwm_sanitize_string($font_key).'-';
                    $variations = array();
                    $font_size = number_format( floatval( $base * $ratios[ $breakpoint_key ] * pow( $modular_scale, $element_value ) ), 3 );
                    switch($element_key) {
                        case 'p':
                        case 'ul':
                        case 'ol':
                        case 'code' : 
                            $line_height = 1.5; 
                        break;

                        case 'h1':
                        case 'h2':
                        case 'h3':
                        case 'h4':
                        case 'h5':
                        case 'h6': 
                            $line_height = 1.2; 
                        break;
                    }
                    
                    switch( $font_key ) {
                        case 'Inter var experimental':
                            set_theme_mod( $prop_id.'weight', 400 );
                            set_theme_mod( $prop_id.'slant', 0 );
                            set_theme_mod( $prop_id.'font_size', $font_size );
                            set_theme_mod( $prop_id.'line_height', $line_height );
                            set_theme_mod( $prop_id.'letter_spacing', 0 );
                        break;
    
                        case 'Montserrat':
                            set_theme_mod( $prop_id.'weight', 400 );
                            set_theme_mod( $prop_id.'font_size', $font_size );
                            set_theme_mod( $prop_id.'line_height', $line_height );
                            set_theme_mod( $prop_id.'letter_spacing', 0 );
                        break;
    
                        case 'Sudo Variable':
                            set_theme_mod( $prop_id.'weight', 400 );
                            set_theme_mod( $prop_id.'slant', false );
                            set_theme_mod( $prop_id.'font_size', $font_size );
                            set_theme_mod( $prop_id.'line_height', $line_height );
                            set_theme_mod( $prop_id.'letter_spacing', 0 );
                        break;
    
                        case 'Graduate':
                            set_theme_mod( $prop_id.'xopq', 40 );
                            set_theme_mod( $prop_id.'xtra', 400 );
                            set_theme_mod( $prop_id.'optical_size', 16 );
                            set_theme_mod( $prop_id.'grade', 0 );
                            set_theme_mod( $prop_id.'ytrans', 750 );
                            set_theme_mod( $prop_id.'contrast', 0 );
                            set_theme_mod( $prop_id.'yopaque', 100 );
                            set_theme_mod( $prop_id.'serif', 0 );
                            set_theme_mod( $prop_id.'ytas', 0 );
                            set_theme_mod( $prop_id.'ytlc', 650 );
                            set_theme_mod( $prop_id.'ytde', 0 );
                            set_theme_mod( $prop_id.'largo_serif', 0 );
                            set_theme_mod( $prop_id.'font_size', $font_size );
                            set_theme_mod( $prop_id.'line_height', $line_height );
                            set_theme_mod( $prop_id.'letter_spacing', 0 );
                        break;
    
                        case 'Recursive':
                            set_theme_mod( $prop_id.'monoespace', 400 );
                            set_theme_mod( $prop_id.'casual', 400 );
                            set_theme_mod( $prop_id.'weight', 400 );
                            set_theme_mod( $prop_id.'slant', 400 );
                            set_theme_mod( $prop_id.'font_size', $font_size );
                            set_theme_mod( $prop_id.'line_height', $line_height );
                            set_theme_mod( $prop_id.'letter_spacing', 0 );
                        break;
    
                        case 'Science Gothic':
                            set_theme_mod( $prop_id.'weight', 400 );
                            set_theme_mod( $prop_id.'width', 100 );
                            set_theme_mod( $prop_id.'y_opaque', 18 );
                            set_theme_mod( $prop_id.'slant', 0 );
                            set_theme_mod( $prop_id.'font_size', $font_size );
                            set_theme_mod( $prop_id.'line_height', $line_height );
                            set_theme_mod( $prop_id.'letter_spacing', 0 );
                        break;
    
                        case 'Estedad':
                            set_theme_mod( $prop_id.'weight', 400 );
                            set_theme_mod( $prop_id.'width', 100 );
                            set_theme_mod( $prop_id.'font_size', $font_size );
                            set_theme_mod( $prop_id.'line_height', $line_height );
                            set_theme_mod( $prop_id.'letter_spacing', 0 );
                        break;
                    }
                }
            }
        }

        echo json_encode(array($base, $modular_scale));
        wp_die();
    }

    add_action( 'wp_ajax_mwm_variable_fonts_reset_configuration' , 'mwm_variable_fonts_reset_configuration' );
    add_action( 'wp_ajax_nopriv_mwm_variable_fonts_reset_configuration' , 'mwm_variable_fonts_reset_configuration' );
}