<?php

// Security
if (!defined('ABSPATH')) exit;

if (!function_exists('mwm_variable_font_customize_register')) {
    /**
     * Function to register customizer elements
     *
     * @param [WP_Customize_Manager] $wp_customize
     * @return void
     */
    function mwm_variable_font_customize_register( $wp_customize ) {
        // Use custom controls
        include_once mwm_variable_font_INC.'libs/mwm-custom-controls/custom-controls.php';
        $wp_customize->register_panel_type( 'mwm_custom_panel' );
        $wp_customize->register_section_type( 'mwm_custom_section' );

        // First panel
        $mwm_variable_font_panel = new mwm_custom_panel( $wp_customize, 'mwm_variable_font_panel', array(
            'title' => __('mowomo Variable Fonts', 'mwm_variable_font'),
            'priority' => 150,
        ));
        $wp_customize->add_panel( $mwm_variable_font_panel );

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

        // Add elements
        $elements = array( 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'code' );

        // Create tree of panels and sections
        mwm_variable_font_customizer_config_generator( $wp_customize );
        mwm_variable_font_customizer_multi_config_generator( $wp_customize, $fonts );

        foreach($breakpoints as $breakpoint) {
            $mwm_variable_font_panel_breakpoint = new mwm_custom_panel( $wp_customize, 'mwm_variable_font_panel-'.$breakpoint[1].'_'.$breakpoint[2].'_panel', array(
                'title' => $breakpoint[0],
                'panel' => 'mwm_variable_font_panel',
            ));
            $wp_customize->add_panel( $mwm_variable_font_panel_breakpoint );

            mwm_variable_font_customizer_generator($wp_customize, $breakpoint, $fonts, $elements);
        }
    }
    add_action( 'customize_register', 'mwm_variable_font_customize_register' );

    if ( !function_exists( 'mwm_variable_font_customizer_config_generator' ) ) {
        function mwm_variable_font_customizer_config_generator( $wp_customize ){
            // Creating section
            $general_section_id = 'mwm_variable_font_panel-general_section';
            $mwm_variable_font_panel_general_section = new mwm_custom_section( $wp_customize, $general_section_id, array(
                'title' => __( 'Modular scale', 'mwm_variable_font' ),
                'panel' => 'mwm_variable_font_panel',
            ));
            $wp_customize->add_section( $mwm_variable_font_panel_general_section );

            mwm_add_separator_control( $wp_customize, $general_section_id, $general_section_id.'-separator_1', __('Modular scale', 'mwm_variable_font'), '', false );

            // Select base
            $wp_customize->add_setting( $general_section_id.'-base', array(
                'default' => 1
            ));
            $wp_customize->add_control( new mwm_slider_control( 
                $wp_customize, 
                $general_section_id.'-base', 
                array(
                    'label'	            => __( 'Base', 'mwm_variable_font' ),
                    'section'           => $general_section_id,
                    'settings'          => $general_section_id.'-base',
                    'min'               => 1,
                    'max'               => 3,
                    'step'              => 0.01,
                ) 
            ));

            // Select ratio
            $ratios = array(
                '1.067' => __( '15:16 - minor second (1.067)', 'mwm_variable_font' ),
                '1.125' => __( '8:9 - major second (1.125)', 'mwm_variable_font' ),
                '1.2' => __( '5:6 - minor third (1.2)', 'mwm_variable_font' ),
                '1.25' => __( '4:5 - major third (1.25)', 'mwm_variable_font' ),
                '1.333' => __( '5:6 - perfect fourth (1.333)', 'mwm_variable_font' ),
            );
            $wp_customize->add_setting( $general_section_id.'-ratio', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'default' => '1.125',
            ));
            $wp_customize->add_control( $general_section_id.'-ratio', array(
                'label' => __( 'Choose a modular scale', 'mwm_variable_font' ),
                'section' => $general_section_id,
                'type' => 'select',
                'choices' => $ratios
            ));

            $wp_customize->add_setting( $general_section_id.'-button', array(
                'type' => 'theme_mod',
            ));
            $wp_customize->add_control( new mwm_button_control(
                $wp_customize,
                $general_section_id.'-button',
                array(
                    'type' => 'button',
                    'section' => $general_section_id,
                    'label' => __( 'Apply modular scale', 'mwm_variable_font' ),
                    'id' => 'mwm-control-reset-defaults',
            )));
        }
    }

    if ( !function_exists( 'mwm_variable_font_customizer_multi_config_generator' ) ) {
        function mwm_variable_font_customizer_multi_config_generator( $wp_customize, $fonts ){
            // Creating section
            $general_section_id = 'mwm_variable_font_panel-multi-general_section';
            $mwm_variable_font_panel_general_section = new mwm_custom_section( $wp_customize, $general_section_id, array(
                'title' => __( 'General modifications', 'mwm_variable_font' ),
                'panel' => 'mwm_variable_font_panel',
            ));
            $wp_customize->add_section( $mwm_variable_font_panel_general_section );

            mwm_add_separator_control( $wp_customize, $general_section_id, $general_section_id.'-separator_1', __('Global font family modification', 'mwm_variable_font'), '', false );

            // Selected font family
            $wp_customize->add_setting( $general_section_id.'-selected_font', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'default' => 'Inter var experimental',
            ));
            $wp_customize->add_control( $general_section_id.'-selected_font', array(
                'label' => __( 'Choose a font', 'mwm_variable_font' ),
                'section' => $general_section_id,
                'type' => 'select',
                'choices' => $fonts
            ));
            
            $wp_customize->add_setting( $general_section_id.'-selected_target', array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'default' => 'Every tag',
            ));
            $wp_customize->add_control( $general_section_id.'-selected_target', array(
                'label' => __( 'Choose targets', 'mwm_variable_font' ),
                'section' => $general_section_id,
                'type' => 'select',
                'choices' => array(
                    'Every tag' => __( 'Every tag', 'mwm_variable_font' ),
                    'All tags except titles' => __( 'All tags except titles', 'mwm_variable_font' ),
                    'Only titles' => __( 'Only titles', 'mwm_variable_font' ),
                )
            ));

            $wp_customize->add_setting( $general_section_id.'-button', array(
                'type' => 'theme_mod',
            ));
            $wp_customize->add_control( new mwm_button_control(
                $wp_customize,
                $general_section_id.'-button',
                array(
                    'type' => 'button',
                    'section' => $general_section_id,
                    'label' => __( 'Apply global change of font family', 'mwm_variable_font' ),
                    'id' => 'mwm-control-change-font-family',
                    'help' => __( 'It is recommended to reload the page when changes have been made after pressing the button', 'mwm_variable_font' )
            )));
        }
    }

    if (!function_exists( 'mwm_variable_font_customizer_generator' )) {
        function mwm_variable_font_customizer_generator( $wp_customize, $breakpoint, $fonts, $elements ) {
            // Panel id
            $panel_id = 'mwm_variable_font_panel-'.$breakpoint[1].'_'.$breakpoint[2].'_panel';

            // Loop for each element
            foreach($elements as $element) {
                // Section id
                $section_id = $panel_id.'-'.$element;

                // Add section
                $mwm_variable_font_panel_breakpoint_section = new mwm_custom_section( $wp_customize, $section_id, array(
                    'title' => '<'.$element.'>',
                    'panel' => $panel_id,
                ));
                $wp_customize->add_section( $mwm_variable_font_panel_breakpoint_section );

                // Separator
                mwm_add_separator_control( $wp_customize, $section_id, $section_id.'-separator_1', __('Font family', 'mwm_variable_font'), '', false );

                // Selected font family
                $wp_customize->add_setting( $section_id.'-selected_font', array(
                    'type' => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'default' => 'Select a font',
                ));
                $wp_customize->add_control( $section_id.'-selected_font', array(
                    'label' => __( 'Choose a font', 'mwm_variable_font' ),
                    'section' => $section_id,
                    'type' => 'select',
                    'choices' => $fonts
                ));

                // Separator
                mwm_add_separator_control( $wp_customize, $section_id, $section_id.'-separator_2', '', '', true );

                foreach($fonts as $font => $font_value) {
                    switch($font) {
                        case 'Inter var experimental':
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_3', __('Registered axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'weight', 'weight', 100, 900, 10, 400);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'slant', 'slant', -10, 0, 0.1, 0);
                            mwm_add_checkbox_control($wp_customize, $section_id, $font, 'italic', 'italic', false);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_4', '', '', true );

                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_5', __('Properties', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'font_size', 'font-size', 0, 5, 0.1, 1.2);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'line_height', 'line-height', -1, 5, 0.1, 1.5);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'letter_spacing', 'letter-spacing', -0.15, 0.15, 0.01, 0);
                        break;

                        case 'Montserrat':
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_3', __('Registered axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'weight', 'weight', 200, 900, 10, 400);
                            mwm_add_checkbox_control($wp_customize, $section_id, $font, 'italic', 'italic', false);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_4', '', '', true );

                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_5', __('Properties', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'font_size', 'font-size', 0, 5, 0.1, 1.2);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'line_height', 'line-height', -1, 5, 0.1, 1.5);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'letter_spacing', 'letter-spacing', -0.15, 0.15, 0.01, 0);
                        break;

                        case 'Sudo Variable':
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_3', __('Registered axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'weight', 'weight', 200, 700, 10, 400);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'slant', 'slant', 0, 1, 0.01, 0);
                            mwm_add_checkbox_control($wp_customize, $section_id, $font, 'italic', 'italic', false);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_4', '', '', true );

                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_5', __('Properties', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'font_size', 'font-size', 0, 5, 0.1, 1.2);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'line_height', 'line-height', -1, 5, 0.1, 1.5);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'letter_spacing', 'letter-spacing', -0.15, 0.15, 0.01, 0);
                        break;

                        case 'Graduate':
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_3', __('Custom axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'xopq', 'Xopq', 40, 200, 1, 40);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'xtra', 'Xtra', 100, 800, 10, 400);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'optical_size', 'Optical Size', 8, 16, 0.1, 16);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'grade', 'Grade', 0, 20, 0.1, 0);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'ytrans', 'Ytrans', 750, 850, 1, 750);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'contrast', 'Contrast', 0, 100, 1, 0);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'yopaque', 'Yopaque', 100, 800, 10, 100);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'serif', 'Serif', 0, 30, 1, 0);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'ytas', 'Ytas', 0, 50, 1, 0);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'ytlc', 'Ytlc', 650, 750, 1, 650);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'ytde', 'Ytde', 0, 50, 1, 0);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'largo_serif', 'Largo Serif', -20, 0, 0.1, 0);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_4', '', '', true );

                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_5', __('Properties', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'font_size', 'font-size', 0, 5, 0.1, 1.2);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'line_height', 'line-height', -1, 5, 0.1, 1.5);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'letter_spacing', 'letter-spacing', -0.15, 0.15, 0.01, 0);
                        break;

                        case 'Recursive':
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_3', __('Registered axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'weight', 'weight', 300, 900, 10, 400);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'slant', 'slant', -15, 0, 0.01, 0);
                            mwm_add_checkbox_control($wp_customize, $section_id, $font, 'italic', 'italic', false);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_4', '', '', true );

                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_7', __('Custom axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'monoespace', 'monoespace', 0, 1, 0.01, 0);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'casual', 'casual', 0, 1, 0.01, 0);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_8', '', '', true );

                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_5', __('Properties', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'font_size', 'font-size', 0, 5, 0.1, 1.2);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'line_height', 'line-height', -1, 5, 0.1, 1.5);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'letter_spacing', 'letter-spacing', -0.15, 0.15, 0.01, 0);
                        break;

                        case 'Science Gothic':
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_3', __('Registered axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'weight', 'weight', 100, 900, 10, 400);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'width', 'width', 50, 200, 1, 50);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'y_opaque', 'Y opaque', 18, 122, 0.5, 18);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'slant', 'slant', -10, 0, 0.1, 0);
                            mwm_add_checkbox_control($wp_customize, $section_id, $font, 'italic', 'italic', false);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_4', '', '', true );
                            
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_5', __('Properties', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'font_size', 'font-size', 0, 5, 0.1, 1.2);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'line_height', 'line-height', 1, 5, 0.1, 1.5);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'letter_spacing', 'letter-spacing', -0.15, 0.15, 0.01, 0);
                        break;

                        case 'Estedad':
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_3', __('Registered axes', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'weight', 'weight', 100, 900, 10, 400);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'width', 'width', 50, 200, 1, 50);
                            mwm_add_checkbox_control($wp_customize, $section_id, $font, 'italic', 'italic', false);
                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_4', '', '', true );

                            mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, 'separator_5', __('Properties', 'mwm_variable_font'), '', false );
                            mwm_add_range_control($wp_customize, $section_id, $font, 'font_size', 'font-size', 0, 5, 0.1, 1.2);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'line_height', 'line-height', 1, 5, 0.1, 1.5);
                            mwm_add_range_control($wp_customize, $section_id, $font, 'letter_spacing', 'letter-spacing', -0.15, 0.15, 0.01, 0);
                        break;
                    }
                }
            }
        }
    }

    if (!function_exists('mwm_add_range_control')) {
        function mwm_add_range_control( $wp_customize, $section_id, $font, $prop, $label, $min, $max, $step, $default ) {
            $prop_id = $section_id.'-'.mwm_sanitize_string($font).'-'.$prop;
            
            $wp_customize->add_setting( $prop_id, array(
                'default' => $default
            ));
            $wp_customize->add_control( new mwm_slider_control( 
                $wp_customize, 
                $prop_id, 
                array(
                    'label'	            => $label,
                    'section'           => $section_id,
                    'settings'          => $prop_id,
                    'min'               => $min,
                    'max'               => $max,
                    'step'              => $step,
                    'active_callback'   => function ($control) {
                        return mwm_check_setting($control);
                    },
                ) 
            ));

            $setting_id = $wp_customize->get_setting($prop_id)->id;
            $GLOBALS['mwm_support_global_section_id'][$setting_id] = $section_id;
            $GLOBALS['mwm_support_global_font'][$setting_id] = $font;
        }
    }
    
    if (!function_exists('mwm_add_font_size_type_selector')) {
        function mwm_add_font_size_type_selector( $wp_customize, $section_id, $font, $prop, $label, $default ) {
            $prop_id = $section_id.'-'.mwm_sanitize_string($font).'-'.$prop;

            $wp_customize->add_setting( $prop_id, array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'default' => $default,
            ));
    
            $wp_customize->add_control( $prop_id, array(
                'label'             => $label,
                'section'           => $section_id,
                'settings'          => $section_id.'-'.mwm_sanitize_string($font).'-'.$prop,
                'type'              => 'select',
                'choices'           => array(
                    'rem'           => 'rem',
                    'em'            => 'em'
                ),
                'active_callback'   => function ($control) {
                    return mwm_check_setting($control);
                },
            ));
    
            $setting_id = $wp_customize->get_setting($prop_id)->id;
            $GLOBALS['mwm_support_global_section_id'][$setting_id] = $section_id;
            $GLOBALS['mwm_support_global_font'][$setting_id] = $font;
        }
    }

    if (!function_exists('mwm_add_checkbox_control')) {
        function mwm_add_checkbox_control( $wp_customize, $section_id, $font, $prop, $label, $default ) {
            $prop_id = $section_id.'-'.mwm_sanitize_string($font).'-'.$prop;
            $wp_customize->add_setting( $prop_id, array(
                'default'    => $default
            ));
            
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    $prop_id,
                    array(
                        'label'     => $label,
                        'section'   => $section_id,
                        'settings'  => $prop_id,
                        'type'      => 'checkbox',
                        'active_callback'   => function ($control) {
                            return mwm_check_setting($control);
                        },
                    )
                )
            );

            $setting_id = $wp_customize->get_setting($prop_id)->id;
            $GLOBALS['mwm_support_global_section_id'][$setting_id] = $section_id;
            $GLOBALS['mwm_support_global_font'][$setting_id] = $font;
        }
    }

    if (!function_exists('mwm_add_separator_control')) {
        function mwm_add_separator_control( $wp_customize, $section_id, $control_id, $label = '', $description = '', $line = false ) {
            $wp_customize->add_setting( $control_id, array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
            ));
    
            $wp_customize->add_control( new mwm_separator_control( 
                $wp_customize, 
                $control_id, 
                array(
                    'label'	        => $label,
                    'description'   => $description,
                    'line'          => $line,
                    'section'       => $section_id,
                    'settings'      => $control_id,
                ) 
            ));
        }
    }

    if (!function_exists('mwm_add_separator_subcontrol')) {
        function mwm_add_separator_subcontrol( $wp_customize, $section_id, $font, $prop, $label = '', $description = '', $line = false ) {
            $prop_id = $section_id.'-'.mwm_sanitize_string($font).'-'.$prop;

            $wp_customize->add_setting( $prop_id, array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
            ));
    
            $wp_customize->add_control( new mwm_separator_control( 
                $wp_customize, 
                $prop_id, 
                array(
                    'label'	            => $label,
                    'description'       => $description,
                    'line'              => $line,
                    'section'           => $section_id,
                    'settings'          => $prop_id,
                    'active_callback'   => function ($control) {
                        return mwm_check_setting($control);
                    },
                ) 
            ));
    
            $setting_id = $wp_customize->get_setting($prop_id)->id;
            $GLOBALS['mwm_support_global_section_id'][$setting_id] = $section_id;
            $GLOBALS['mwm_support_global_font'][$setting_id] = $font;
        }
    }
    
    if (!function_exists('mwm_check_setting')) {
        function mwm_check_setting($control) {
            global $mwm_support_global_section_id, $mwm_support_global_font;
            $section_id = $mwm_support_global_section_id[$control->id];
            $font = $mwm_support_global_font[$control->id];

            return $control->manager->get_setting($section_id.'-selected_font')->value() == $font ? true : false;
        }
    }
}