<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Handle Front Scripts and StyleSheets
 * @class rtslider_admin_assets
 * @since 1.0.0
 */
if (!class_exists('rtslider_admin_assets', false)) :

    class rtslider_admin_assets {

        /**
         * Hook in tabs.
         */
        public function __construct() {
            add_action('admin_enqueue_scripts', array($this, 'rtslider_admin_styles'));
            add_action('admin_enqueue_scripts', array($this, 'rtslider_admin_scripts'));
            add_action('init', array($this, 'rtslider_register_block'));
        }

        /**
         * Enqueue styles.
         */
        public function rtslider_admin_styles() {
            $cssVersion = filemtime(RTSLIDER_PLUGIN_PATH . 'assets/css/rtslider-admin-css.css');
            wp_enqueue_style('rtslider-admin-css', RTSLIDER_PLUGIN_URL . 'assets/css/rtslider-admin-css.css', array(), $cssVersion);
        }

        /**
         * Enqueue scripts.
         */
        public function rtslider_admin_scripts() {
            $jsVersion = filemtime(RTSLIDER_PLUGIN_PATH . 'assets/js/rtslider-admin-js.js');
            wp_enqueue_script('rtslider-admin-js', RTSLIDER_PLUGIN_URL . 'assets/js/rtslider-admin-js.js', array('jquery','jquery-ui-sortable','wp-blocks','wp-i18n'), $jsVersion, true);
            $localize_veriable = array('ajax_url' => RTSLIDER_ADMIN_AJAX_URL, 'site_url' => RTSLIDER_SITE_URL, 'select_images' => __("Select Images", 'rtslider_domain'), 'add' => __('Add', 'rtslider_domain'),
                'success' => __('Image order has been changed', 'rtslider_domain'),
                'error' => __('There was an error while saving sort order', 'rtslider_domain'),
                'confirm' => __("Are you sure ?", 'rtslider_domain'),
	            'default_taxonomy'=>(int) get_option( 'default_rtslider_category')
	            );
            wp_localize_script('rtslider-admin-js', 'admin_veriables', $localize_veriable);


        }
        public function rtslider_register_block(){
        	register_block_type('rtslider-blocks/rtslider',array(
        		'editor_script'=>'rtslider-admin-js',
	        ));
        }

    }

    endif;
return new rtslider_admin_assets();
