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

    class rtslider_admin_assets
    {
        /**
         * Hook in tabs.
         */
        public function __construct()
        {
            add_action('admin_enqueue_scripts', array($this, 'rtslider_admin_styles'));
            add_action('admin_enqueue_scripts', array($this, 'rtslider_admin_scripts'));
        }

        /**
         * Enqueue styles.
         */
        public function rtslider_admin_styles()
        {
            $cssVersion = filemtime(RTSLIDER_PLUGIN_PATH . 'assets/css/plugin_admin_custom_css.css');
            wp_enqueue_style('rtslider_custom-style', RTSLIDER_PLUGIN_URL . 'assets/css/plugin_admin_custom_css.css', array(), $cssVersion);
        }

        /**
         * Enqueue scripts.
         */
        public function rtslider_admin_scripts()
        {
            if( get_post_type()=='rtslider'){
                wp_enqueue_script("jquery-ui-sortable");
            }
            $jsVersion = filemtime(RTSLIDER_PLUGIN_PATH . 'assets/js/plugin_admin_custom_js.js');
            wp_enqueue_script('rtslider_custom-js-file', RTSLIDER_PLUGIN_URL . 'assets/js/plugin_admin_custom_js.js', array('jquery'), $jsVersion, true);
            $localize_veriable = array('ajax_url' => RTSLIDER_ADMIN_AJAX_URL, 'site_url' => RTSLIDER_SITE_URL, 'select_images' => __("Select Images", PLUGIN_DOMAIN), 'add' => __('Add', PLUGIN_DOMAIN),
                'success' => __('Image order has been changed', PLUGIN_DOMAIN),
                'error' => __('There was an error while saving sort order', PLUGIN_DOMAIN),
                'confirm' => __("Are you sure ?", PLUGIN_DOMAIN));
            wp_localize_script('rtslider_custom-js-file', 'admin_veriables', $localize_veriable);
        }
    }

endif;
return new rtslider_admin_assets();
