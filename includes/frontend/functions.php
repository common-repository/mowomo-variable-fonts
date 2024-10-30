<?php

// Security
if (!defined('ABSPATH')) exit;

// Include files
include_once mwm_variable_font_INC.'frontend/customizer/customizer.php';
include_once mwm_variable_font_INC.'frontend/customizer/global_change_font_family.php';
include_once mwm_variable_font_INC.'frontend/customizer/reset_configuration.php';

// Hooks
if (!function_exists('mwm_variable_font_wp_head')) {
    function mwm_variable_font_wp_head() {

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
        $elements = array( 'p','h1','h2','h3','h4','h5','h6','ul','ol','code' );

        // CSS
        ob_start();
        ?>
            <style type="text/css">
                <?php
                // Loop for each breakpoint
                    foreach($breakpoints as $breakpoint_key => $breakpoint) {

                        // Get panel id
                        $panel_id = 'mwm_variable_font_panel-'.$breakpoint[1].'_'.$breakpoint[2].'_panel';
                        ?>
                            @media screen and (min-width: <?php echo $breakpoint[1]; ?>px) and (max-width: <?php echo $breakpoint[2]; ?>px) {
                        <?php

                        // Loop for each element
                        foreach( $elements as $element ) {

                            // Get section id
                            $section_id = $panel_id.'-'.$element;
                            
                            $selected_font = get_theme_mod( $section_id.'-selected_font', 'Select a font');
                            $prop_id = $section_id.'-'.mwm_sanitize_string($selected_font).'-';
                            $variations = array();
                            
                            switch($selected_font) {
                                case 'Inter var experimental':
                                    $variations['wght'] = get_theme_mod($prop_id.'weight', 400);
                                    $variations['slnt'] = get_theme_mod($prop_id.'slant', 0);
                                    $italic = get_theme_mod($prop_id.'italic', false) ? 'italic' : 'normal';
                                    $font_size = get_theme_mod($prop_id.'font_size', 1.2);
                                    $line_height = get_theme_mod($prop_id.'line_height', 1.5);
                                    $letter_spacing = get_theme_mod($prop_id.'letter_spacing', 0);

                                    // Print CSS
                                    ?>
                                        body <?php echo $element; ?>:not([mwm-no-css]), body <?php echo $element; ?>:not([mwm-no-css]) a {
                                            font-family: "Inter var experimental", serif !important;

                                            <?php echo mwm_get_variation_settings( $variations ); ?>

                                            <?php if ($font_size ) : ?>
                                                font-size: <?php echo $font_size; ?>rem !important;
                                            <?php endif; ?>

                                            font-style: <?php echo $italic; ?> !important;

                                            <?php if ($line_height) : ?>
                                                line-height: <?php echo $line_height; ?>em !important;
                                            <?php endif; ?>

                                            <?php if ($letter_spacing) : ?>
                                                letter-spacing: <?php echo $letter_spacing.'em'; ?> !important;
                                            <?php endif; ?>
                                        }
                                    <?php
                                break;

                                case 'Montserrat':
                                    $variations['wght'] = get_theme_mod($prop_id.'weight', 400);
                                    $italic = get_theme_mod($prop_id.'italic', false) ? 'italic' : 'normal';
                                    $font_size = get_theme_mod($prop_id.'font_size', 1.2);
                                    $line_height = get_theme_mod($prop_id.'line_height', 1.5);
                                    $letter_spacing = get_theme_mod($prop_id.'letter_spacing', 0);

                                    ?>
                                        body <?php echo $element; ?>:not([mwm-no-css]), body <?php echo $element; ?>:not([mwm-no-css]) a {
                                            font-family: "Montserrat", serif !important;

                                            <?php echo mwm_get_variation_settings( $variations ); ?>

                                            <?php if ($font_size ) : ?>
                                                font-size: <?php echo $font_size; ?>rem !important;
                                            <?php endif; ?>

                                            font-style: <?php echo $italic; ?> !important;

                                            <?php if ($line_height) : ?>
                                                line-height: <?php echo $line_height; ?>em !important;
                                            <?php endif; ?>

                                            <?php if ($letter_spacing) : ?>
                                                letter-spacing: <?php echo $letter_spacing.'em'; ?> !important;
                                            <?php endif; ?>
                                        }
                                    <?php
                                break;

                                case 'Sudo Variable':
                                    $variations['wght'] = get_theme_mod($prop_id.'weight', 400);
                                    $variations['ital'] = get_theme_mod($prop_id.'slant', false);
                                    $italic = get_theme_mod($prop_id.'italic', false) ? 'italic' : 'normal';
                                    $font_size = get_theme_mod($prop_id.'font_size', 1.2);
                                    $line_height = get_theme_mod($prop_id.'line_height', 1.5);
                                    $letter_spacing = get_theme_mod($prop_id.'letter_spacing', 0);

                                    ?>
                                        body <?php echo $element; ?>:not([mwm-no-css]), body <?php echo $element; ?>:not([mwm-no-css]) a {
                                            font-family: "Sudo Variable", serif !important;

                                            <?php echo mwm_get_variation_settings( $variations ); ?>

                                            <?php if ($font_size ) : ?>
                                                font-size: <?php echo $font_size; ?>rem !important;
                                            <?php endif; ?>

                                            font-style: <?php echo $italic; ?> !important;

                                            <?php if ($line_height) : ?>
                                                line-height: <?php echo $line_height; ?>em !important;
                                            <?php endif; ?>

                                            <?php if ($letter_spacing) : ?>
                                                letter-spacing: <?php echo $letter_spacing.'em'; ?> !important;
                                            <?php endif; ?>
                                        }
                                    <?php
                                break;

                                case 'Graduate':
                                    $variations['XOPQ'] = get_theme_mod($prop_id.'xopq', 40);
                                    $variations['XTRA'] = get_theme_mod($prop_id.'xtra', 400);
                                    $variations['OPSZ'] = get_theme_mod($prop_id.'optical_size', 16);
                                    $variations['GRAD'] = get_theme_mod($prop_id.'grade', 0);
                                    $variations['YTRA'] = get_theme_mod($prop_id.'ytrans', 750);
                                    $variations['CNTR'] = get_theme_mod($prop_id.'contrast', 0);
                                    $variations['YOPQ'] = get_theme_mod($prop_id.'yopaque', 100);
                                    $variations['SERF'] = get_theme_mod($prop_id.'serif', 0);
                                    $variations['YTAS'] = get_theme_mod($prop_id.'ytas', 0);
                                    $variations['YTLC'] = get_theme_mod($prop_id.'ytlc', 650);
                                    $variations['YTDE'] = get_theme_mod($prop_id.'ytde', 0);
                                    $variations['SELE'] = get_theme_mod($prop_id.'largo_serif', 0);
                                    $italic = get_theme_mod($prop_id.'italic', false) ? 'italic' : 'normal';
                                    $font_size = get_theme_mod($prop_id.'font_size', 1.2);
                                    $line_height = get_theme_mod($prop_id.'line_height', 1.5);
                                    $letter_spacing = get_theme_mod($prop_id.'letter_spacing', 0);

                                    ?>
                                        body <?php echo $element; ?>:not([mwm-no-css]), body <?php echo $element; ?>:not([mwm-no-css]) a {
                                            font-family: "Graduate", serif !important;

                                            <?php echo mwm_get_variation_settings( $variations ); ?>

                                            <?php if ($font_size ) : ?>
                                                font-size: <?php echo $font_size; ?>rem !important;
                                            <?php endif; ?>

                                            font-style: <?php echo $italic; ?> !important;

                                            <?php if ($line_height) : ?>
                                                line-height: <?php echo $line_height; ?>em !important;
                                            <?php endif; ?>

                                            <?php if ($letter_spacing) : ?>
                                                letter-spacing: <?php echo $letter_spacing.'em'; ?> !important;
                                            <?php endif; ?>
                                        }
                                    <?php
                                break;

                                case 'Recursive':
                                    $variations['MONO'] = get_theme_mod($prop_id.'monoespace', 400);
                                    $variations['CASL'] = get_theme_mod($prop_id.'casual', 400);
                                    $variations['wght'] = get_theme_mod($prop_id.'weight', 400);
                                    $variations['slnt'] = get_theme_mod($prop_id.'slant', 400);
                                    $italic = get_theme_mod($prop_id.'italic', false) ? 'italic' : 'normal';
                                    $font_size = get_theme_mod($prop_id.'font_size', 1.2);
                                    $line_height = get_theme_mod($prop_id.'line_height', 1.5);
                                    $letter_spacing = get_theme_mod($prop_id.'letter_spacing', 0);

                                    ?>
                                        body <?php echo $element; ?>:not([mwm-no-css]), body <?php echo $element; ?>:not([mwm-no-css]) a {
                                            font-family: "Recursive", serif !important;

                                            <?php echo mwm_get_variation_settings( $variations ); ?>

                                            <?php if ($font_size ) : ?>
                                                font-size: <?php echo $font_size; ?>rem !important;
                                            <?php endif; ?>

                                            font-style: <?php echo $italic; ?> !important;

                                            <?php if ($line_height) : ?>
                                                line-height: <?php echo $line_height; ?>em !important;
                                            <?php endif; ?>

                                            <?php if ($letter_spacing) : ?>
                                                letter-spacing: <?php echo $letter_spacing.'em'; ?> !important;
                                            <?php endif; ?>
                                        }
                                    <?php
                                break;

                                case 'Science Gothic':
                                    $variations['wght'] = get_theme_mod($prop_id.'weight', 400);
                                    $variations['wdth'] = get_theme_mod($prop_id.'width', 100);
                                    $variations['YOPQ'] = get_theme_mod($prop_id.'y_opaque', 18);
                                    $variations['slnt'] = get_theme_mod($prop_id.'slant', 0);
                                    $italic = get_theme_mod($prop_id.'italic', false) ? 'italic' : 'normal';
                                    $font_size = get_theme_mod($prop_id.'font_size', 1.2);
                                    $line_height = get_theme_mod($prop_id.'line_height', 1.5);
                                    $letter_spacing = get_theme_mod($prop_id.'letter_spacing', 0);

                                    ?>
                                        body <?php echo $element; ?>:not([mwm-no-css]), body <?php echo $element; ?>:not([mwm-no-css]) a {
                                            font-family: "Science Gothic" !important;

                                            <?php echo mwm_get_variation_settings( $variations ); ?>

                                            <?php if ($font_size ) : ?>
                                                font-size: <?php echo $font_size; ?>rem !important;
                                            <?php endif; ?>

                                            font-style: <?php echo $italic; ?> !important;

                                            <?php if ($line_height) : ?>
                                                line-height: <?php echo $line_height; ?>em !important;
                                            <?php endif; ?>

                                            <?php if ($letter_spacing) : ?>
                                                letter-spacing: <?php echo $letter_spacing.'em'; ?> !important;
                                            <?php endif; ?>
                                        }
                                    <?php
                                break;

                                case 'Estedad':
                                    $variations['wght'] = get_theme_mod($prop_id.'weight', 400);
                                    $variations['wdth'] = get_theme_mod($prop_id.'width', 100);
                                    $italic = get_theme_mod($prop_id.'italic', false) ? 'italic' : 'normal';
                                    $font_size = get_theme_mod($prop_id.'font_size', 1.2);
                                    $line_height = get_theme_mod($prop_id.'line_height', 1.5);
                                    $letter_spacing = get_theme_mod($prop_id.'letter_spacing', 0);

                                    ?>
                                        body <?php echo $element; ?>:not([mwm-no-css]), body <?php echo $element; ?>:not([mwm-no-css]) a {
                                            font-family: "Estedad" !important;

                                            <?php echo mwm_get_variation_settings( $variations ); ?>

                                            <?php if ($font_size ) : ?>
                                                font-size: <?php echo $font_size; ?>rem !important;
                                            <?php endif; ?>

                                            font-style: <?php echo $italic; ?> !important;

                                            <?php if ($line_height) : ?>
                                                line-height: <?php echo $line_height; ?>em !important;
                                            <?php endif; ?>

                                            <?php if ($letter_spacing) : ?>
                                                letter-spacing: <?php echo $letter_spacing.'em'; ?> !important;
                                            <?php endif; ?>
                                        }
                                    <?php
                                break;
                            }
                        }

                        ?>
                            }
                        <?php
                    }
                ?>
            </style>
        <?php 
        echo ob_get_clean();
    }
    add_action( 'wp_head', 'mwm_variable_font_wp_head' );
}

if (!function_exists('echop')) {
    function echop($var) {
        echo '<pre>',var_dump($var),'</pre>';
    }
}

if (!function_exists('mwm_get_variation_settings')) {
    function mwm_get_variation_settings( array $variations ) {
        $result = '';
        if (count($variations) > 0) {
            $result .= 'font-variation-settings: ';
            foreach ( $variations as $var => $value ) {
                if ($value) $result .= '"'.$var.'" '.$value.', ';
            }
            $result = substr($result, 0, -2);
            $result .= ' !important;';
        }
        return $result;
    }
}

if (!function_exists('mwm_sanitize_string')) {
    function mwm_sanitize_string( $string ) {
        return str_replace( '-', '_', sanitize_title( $string ) );
    }
}