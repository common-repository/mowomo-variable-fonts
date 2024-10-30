<?php

// Security
if (!defined('ABSPATH')) exit;


/**
 * Adding customizer link to WordPress dashboard
 */
if ( !function_exists( 'mwm_variable_font_register_menu_page' ) ) {
    function mwm_variable_font_register_menu_page() {
        add_menu_page(
            __( 'mowomo Variable Fonts', 'mwm_variable_font' ),
            __( 'mowomo Variable Fonts', 'mwm_variable_font' ),
            'manage_options',
            'mwm-variable-font',
            'mwm_variable_font_register_menu_page_callback',
            mwm_variable_font_IMG . 'logo.png'
        );
    }
    add_action( 'admin_menu', 'mwm_variable_font_register_menu_page' );

    if ( !function_exists( 'mwm_variable_font_register_menu_page_callback' ) ) {
        function mwm_variable_font_register_menu_page_callback() {
        }
    }

    if ( !function_exists( 'mwm_variable_font_admin_page_redirect' ) ) { 
        function mwm_variable_font_admin_page_redirect() {

            if ( isset( $_GET['page'] ) && $_GET['page'] == 'mwm-variable-font' ) {
                $query['autofocus[panel]'] = 'mwm_variable_font_panel';
                $panel_link = add_query_arg( $query, admin_url( 'customize.php' ) );
                wp_redirect($panel_link);
                exit;
            }

        }  
        add_action ('wp_loaded', 'mwm_variable_font_admin_page_redirect');
    }
}


/**
 * Admin notices
 */
if ( !function_exists( 'mwm_variable_font_admin_notice_success' ) ) {
    function mwm_variable_font_admin_notice_success() {

        if ( get_option( 'mwm_variable_font_admin_notice_default', 0 ) == 1 ) return;

        $query['autofocus[panel]'] = 'mwm_variable_font_panel';
        $panel_link = add_query_arg( $query, admin_url( 'customize.php' ) );

        ob_start();
        ?>
            
            <div class="notice notice-success">
                <p><?php _e( 'The mowomo Variable Fonts plugin is installed. You don\'t know how to start using it yet? Go to the site\'s customizer through this', 'mwm_variable_font' ); ?> <a href="<?php echo $panel_link; ?>"><?php _e( 'link', 'mwm_variable_font' ); ?></a>.</p>
                <p><button id="mwm-variable-font-i-know" class="button button-primary" type="button"><?php _e( 'Understood', 'mwm_variable_font' ); ?></button></p>
            </div>
        
        <?php
        $result = ob_get_clean();

        echo $result;

    }
    add_action( 'admin_notices', 'mwm_variable_font_admin_notice_success' );
}


if ( !function_exists( 'mwm_variable_font_uncheck_admin_notice' ) ) {
    function mwm_variable_font_uncheck_admin_notice() {
        update_option( 'mwm_variable_font_admin_notice_default', 1 );
        die();
    }
    add_action( 'wp_ajax_mwm_variable_font_uncheck_admin_notice' , 'mwm_variable_font_uncheck_admin_notice' );
    add_action( 'wp_ajax_nopriv_mwm_variable_font_uncheck_admin_notice' , 'mwm_variable_font_uncheck_admin_notice' );

}
