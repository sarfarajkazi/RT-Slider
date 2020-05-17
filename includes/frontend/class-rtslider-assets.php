<?php

if (!defined('ABSPATH')) {
    exit;
}
/**
 * Handle Front Scripts and StyleSheets
 * @class rtslider_front_assets
 * @since 1.0.0
 */
if (!class_exists('rtslider_frontend_assets', false)) :

    class rtslider_frontend_assets {

        /**
         * Hook in tabs.
         */
        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'rtslider_frontend_styles'));
            add_action('wp_enqueue_scripts', array($this, 'rtslider_frontend_scripts'));
        }

        /**
         * Enqueue styles.
         */
        public function rtslider_frontend_styles() {
            $cssVersion = filemtime(RTSLIDER_PLUGIN_PATH . 'assets/css/rtslider-frontend-css.css');
            wp_enqueue_style('rtslider-frontend-css', RTSLIDER_PLUGIN_URL . 'assets/css/rtslider-frontend-css.css', array(), $cssVersion);
        }

        /**
         * Enqueue scripts.
         */
        public function rtslider_frontend_scripts() {
            wp_enqueue_style('slick-theme', RTSLIDER_PLUGIN_URL . 'assets/slick-slider/slick.css');
            wp_enqueue_style('slick', RTSLIDER_PLUGIN_URL . 'assets/slick-slider/slick-theme.css');
            wp_enqueue_script('slick-js-min', RTSLIDER_PLUGIN_URL . 'assets/slick-slider/slick.min.js', array('jquery'), false, true);
            $jsVersion = filemtime(RTSLIDER_PLUGIN_PATH . 'assets/js/rtslider-frontend-js.js');
            wp_enqueue_script('rtslider-frontend-js', RTSLIDER_PLUGIN_URL . 'assets/js/rtslider-frontend-js.js', array('jquery'), $jsVersion, true);
            wp_localize_script('rtslider-frontend-js', 'frontend_veriables', array('ajax_url' => RTSLIDER_ADMIN_AJAX_URL, 'site_url' => RTSLIDER_SITE_URL));
        }

    }

    endif;
return new rtslider_frontend_assets();
