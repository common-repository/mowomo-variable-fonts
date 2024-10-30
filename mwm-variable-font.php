<?php
/*
 * Plugin Name: mowomo Variable Fonts
 * Description: An elegant solution for a better typography with beautiful variable fonts
 * Version:     1.1.0
 * Author:      victorsaenztm, pedromcj95, acirujano, mowomo
 * Author URI:  https://www.mowomo.com
 * License:     GNU GPL 3
 * Text Domain: mwm_variable_font
*/

// Constants
if (!defined('ABSPATH')) exit;
if (!defined('mwm_variable_font_VERSION')) define('mwm_variable_font_VERSION', '1.1.0' );
if (!defined('mwm_variable_font_NAME')) define('mwm_variable_font_NAME', 'mowomo Variable Font' );
if (!defined('mwm_variable_font_SLUG')) define('mwm_variable_font_SLUG', 'mwm_variable_font' );
if (!defined('mwm_variable_font_FILE')) define('mwm_variable_font_FILE', __FILE__ );
if (!defined('mwm_variable_font_URL')) define('mwm_variable_font_URL', plugins_url('/', mwm_variable_font_FILE) );
if (!defined('mwm_variable_font_JS')) define('mwm_variable_font_JS', mwm_variable_font_URL.'assets/js/' );
if (!defined('mwm_variable_font_CSS')) define('mwm_variable_font_CSS', mwm_variable_font_URL.'assets/css/' );
if (!defined('mwm_variable_font_IMG')) define('mwm_variable_font_IMG', mwm_variable_font_URL.'assets/images/' );
if (!defined('mwm_variable_font_DIR')) define('mwm_variable_font_DIR', plugin_dir_path(mwm_variable_font_FILE) );
if (!defined('mwm_variable_font_INC')) define('mwm_variable_font_INC', mwm_variable_font_DIR.'includes/' );
if (!defined('mwm_variable_font_TPL')) define('mwm_variable_font_TPL', mwm_variable_font_DIR.'templates/' );

// Included files
include_once mwm_variable_font_INC.'functions.php';

// Enqueue assets
if (!function_exists('mwm_variable_font_enqueue_scripts')) {
    function mwm_variable_font_enqueue_scripts() {
        wp_register_script(mwm_variable_font_SLUG.'_scripts', mwm_variable_font_JS.'scripts.js', array('jquery'), mwm_variable_font_VERSION );
        wp_register_style(mwm_variable_font_SLUG.'_styles', mwm_variable_font_CSS.'styles.css', array(), mwm_variable_font_VERSION );
        wp_register_style(mwm_variable_font_SLUG.'_inter', 'https://rsms.me/inter/inter.css', array(), mwm_variable_font_VERSION );
        wp_enqueue_script(mwm_variable_font_SLUG.'_scripts');
        wp_enqueue_style(mwm_variable_font_SLUG.'_styles');
        wp_enqueue_style(mwm_variable_font_SLUG.'_inter');
    }
    add_action('wp_enqueue_scripts', 'mwm_variable_font_enqueue_scripts', 999);
}

// Enqueue assets for customizer
if (!function_exists('mwm_variable_font_enqueue_customizer_scripts')) {
    function mwm_variable_font_enqueue_customizer_scripts() {
        wp_register_script(mwm_variable_font_SLUG.'-scripts-customizer', mwm_variable_font_JS.'customizer-scripts.js', array('jquery'), mwm_variable_font_VERSION );
        wp_localize_script( mwm_variable_font_SLUG.'-scripts-customizer', 'ajax_vars', array(
            'ajax'  =>  admin_url( "admin-ajax.php" ),
            'loading_message' => __( 'Loading...', 'mwm_variable_font' ),
            'confirm_message' => __( 'This option will overwrite all the font-size and line-height settings, the changes will be saved and this action cannot be undone. Are you sure you want to continue?', 'mwm_variable_font' ),
            'confirm_message_font_size' => __( 'This option will overwrite all the target\'s font-family settings, the changes will be saved and this action cannot be undone. Are you sure you want to continue?', 'mwm_variable_font' )
        ));
        wp_enqueue_script(mwm_variable_font_SLUG.'-scripts-customizer');
    }
    add_action('customize_controls_enqueue_scripts', 'mwm_variable_font_enqueue_customizer_scripts', 999);
}

// Enqueue admin assets
if (!function_exists('mwm_variable_font_enqueue_admin_scripts')) {
    function mwm_variable_font_enqueue_admin_scripts() {
        wp_register_script(mwm_variable_font_SLUG.'_admin_scripts', mwm_variable_font_JS.'admin_scripts.js', array('jquery'), mwm_variable_font_VERSION );
        wp_localize_script( mwm_variable_font_SLUG.'_admin_scripts', 'ajax_vars', array(
            'ajax'  =>  admin_url( "admin-ajax.php" )
        ));
        wp_register_style(mwm_variable_font_SLUG.'_admin_styles', mwm_variable_font_CSS.'admin_styles.css', array(), mwm_variable_font_VERSION );
        wp_enqueue_script(mwm_variable_font_SLUG.'_admin_scripts');
        wp_enqueue_style(mwm_variable_font_SLUG.'_admin_styles');
    }
    add_action('admin_enqueue_scripts', 'mwm_variable_font_enqueue_admin_scripts', 999);
}

// Adding textdomain
if (!function_exists('mwm_variable_font_load_textdomain')) {
    function mwm_variable_font_load_textdomain() {
        load_plugin_textdomain( mwm_variable_font_SLUG, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
    add_action( 'plugins_loaded', 'mwm_variable_font_load_textdomain' );
}

// Deactivation function
function mwm_variable_font_plugin_deactivation() {
    update_option( 'mwm_variable_font_admin_notice_default', 0 );
}
register_deactivation_hook( __FILE__, 'mwm_variable_font_plugin_deactivation' );