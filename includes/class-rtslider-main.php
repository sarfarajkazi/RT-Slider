<?php

/**
 * RTSLIDER setup
 *
 * @package RTSLIDER
 * @since    1.0.0
 */
defined('ABSPATH') || exit;

/**
 * Main RTSLIDER Lite Class.
 *
 * @class RTSLIDER
 * @author Sarfaraj Kazi
 */
final class RTSLIDER {

    /**
     * The single instance of the class.
     *
     * @since 2.1
     */
    protected static $_instance = null;

    /**
     * Main RTSLIDER Instance.
     *
     * Ensures only one instance of RTSLIDER is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see rtslider_getInstance()
     * @return RTSLIDER - Main instance.
     */
    public static function rtslider_instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * rtslider Constructor.
     */
    public function __construct() {
        $this->rtslider_define_constants();
        add_action('init', array($this, 'rt_post_type'));
        $this->rtslider_includes();
    }

    /**
     * Define Constants
     */
    function rtslider_define_constants() {
        /*
         * plugin constants
         */
        $this->rtslider_define("RTSLIDER_PLUGIN_URL", trailingslashit(plugin_dir_url(__DIR__)));
        $this->rtslider_define("RTSLIDER_PLUGIN_PATH", trailingslashit(plugin_dir_path(__DIR__)));
        $this->rtslider_define("RTSLIDER_ADMIN_TEMPLATES", trailingslashit(RTSLIDER_PLUGIN_PATH . 'includes/admin/templates/'));
        /*
         * urls and site info
         */
        $this->rtslider_define("RTSLIDER_ADMIN_AJAX_URL", admin_url('admin-ajax.php'));
        $this->rtslider_define("RTSLIDER_SITE_URL", trailingslashit(site_url()));
        $this->rtslider_define('RTSLIDER_POST_TYPE', 'rtslider');
        $this->rtslider_define('RTSLIDER_CATEGORY', 'rtslider_category');
    }

    /**
     * Define constant if not already set.
     *
     * @param string $name Constant name.
     * @param string|bool $value Constant value.
     */
    private function rtslider_define($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin or frontend.
     * @return bool
     */
    private function rtslider_is_request($type) {
        switch ($type) {
            case 'admin':
                return (is_admin() || defined('DOING_AJAX'));
            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX'));
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    function rtslider_includes() {
        if ($this->rtslider_is_request('admin')) {
            include_once RTSLIDER_PLUGIN_PATH . 'includes/admin/class-rtslider-admin-assets.php';
            include_once RTSLIDER_PLUGIN_PATH . 'includes/admin/class-rtslider-admin-shortcodes.php';
        }
        if ($this->rtslider_is_request('frontend')) {
            include_once RTSLIDER_PLUGIN_PATH . 'includes/frontend/class-rtslider-shortcodes.php';
            include_once RTSLIDER_PLUGIN_PATH . 'includes/frontend/class-rtslider-assets.php';
        }
    }

    function rt_post_type() {
        register_post_type('rtslider', array(
            'labels' => array(
                'name' => __('RT Slider', 'rtslider_domain'),
                'menu_name' => __('RT Slider', 'rtslider_domain'),
                'all_items' => __('Slides', 'rtslider_domain'),
                'add_new' => __('Add New Slide', 'rtslider_domain'),
                'singular_name' => __('Slide', 'rtslider_domain'),
                'add_item' => __('New Slide', 'rtslider_domain'),
                'add_new_item' => __('Add New Slide', 'rtslider_domain'),
                'edit_item' => __('Edit Slide', 'rtslider_domain')
            ),
            'public' => false,
            'show_in_menu' => true,
            'menu_position' => 4,
            'show_ui' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'supports' => array('title', 'page-attributes', 'editor', 'thumbnail'),
                )
        );

        $labels = array(
            'name' => __('Sliders', 'rtslider_domain'),
            'singular_name' => __('Slider', 'rtslider_domain'),
            'search_items' => __('Search Sliders', 'rtslider_domain'),
            'all_items' => __('All Sliders', 'rtslider_domain'),
            'parent_item' => __('Parent Slider', 'rtslider_domain'),
            'parent_item_colon' => __('Parent Slider:', 'rtslider_domain'),
            'edit_item' => __('Edit Slider', 'rtslider_domain'),
            'update_item' => __('Update Slider', 'rtslider_domain'),
            'add_new_item' => __('Add New Slider', 'rtslider_domain'),
            'new_item_name' => __('New Slider Name', 'rtslider_domain'),
            'menu_name' => __('Sliders', 'rtslider_domain'),
        );

        register_taxonomy('rtslider_category', array('rtslider'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'public' => true,
            'show_admin_column' => true,
        ));
    }

}
