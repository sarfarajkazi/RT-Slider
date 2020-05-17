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
            if (get_post_type() == 'rtslider') {
                wp_enqueue_script("jquery-ui-sortable");
            }
            $jsVersion = filemtime(RTSLIDER_PLUGIN_PATH . 'assets/js/rtslider-admin-js.js');
            wp_enqueue_script('rtslider-admin-js', RTSLIDER_PLUGIN_URL . 'assets/js/rtslider-admin-js.js', array('jquery'), $jsVersion, true);
            $localize_veriable = array('ajax_url' => RTSLIDER_ADMIN_AJAX_URL, 'site_url' => RTSLIDER_SITE_URL, 'select_images' => __("Select Images", 'rtslider_domain'), 'add' => __('Add', 'rtslider_domain'),
                'success' => __('Image order has been changed', 'rtslider_domain'),
                'error' => __('There was an error while saving sort order', 'rtslider_domain'),
                'confirm' => __("Are you sure ?", 'rtslider_domain'));
            wp_localize_script('rtslider-admin-js', 'admin_veriables', $localize_veriable);
        }

    }

    endif;
return new rtslider_admin_assets();
