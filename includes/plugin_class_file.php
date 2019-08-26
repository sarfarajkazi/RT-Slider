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
final class RTSLIDER
{

    /**
     * RTSLIDER Lite version.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The single instance of the class.
     *
     * @since 2.1
     */
    protected static $_instance = null;

    /**
     * Session instance.
     *
     * @var RTSLIDER_Session|RTSLIDER_Session_Handler
     */
    public $session = null;

    /**
     * Query instance.
     *
     * @var RTSLIDER_Query
     */
    public $query = null;

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
    public static function rtslider_instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * rtslider Constructor.
     */
    public function __construct()
    {
        $this->rtslider_define_constants();
        add_action('init',array($this,'rt_post_type'));
        $this->rtslider_includes();
    }

    /**
     * Define Constants
     */
    function rtslider_define_constants()
    {
        global $wpdb;
        $upload_dir = wp_upload_dir();
        $random_number = random_int(111111, 999999999);

        /*
         * plugin constants
         */
        $this->rtslider_define("RTSLIDER_PLUGIN_URL", trailingslashit(plugin_dir_url(__DIR__)));

        $this->rtslider_define("RTSLIDER_PLUGIN_PATH", trailingslashit(plugin_dir_path(__DIR__)));

        $this->rtslider_define("RTSLIDER_ADMIN_TEMPLATES", trailingslashit(RTSLIDER_PLUGIN_PATH.'includes/admin/templates/'));

        $this->rtslider_define('RTSLIDER_VERSION', $this->version);
        $this->rtslider_define('RTSLIDER_DATE_FORMAT', get_option('date_format', true));
        $this->rtslider_define('RTSLIDER_TIME_FORMAT', get_option('time_format', true));
        $this->rtslider_define('RTSLIDER_DB_DATE_FORMAT', "Y-m-d H:i:s");
        /*
         * urls and site info
         */
        $this->rtslider_define("RTSLIDER_ADMIN_URL", admin_url());
        $this->rtslider_define("RTSLIDER_ADMIN_AJAX_URL", admin_url('admin-ajax.php'));
        $this->rtslider_define("RTSLIDER_SITE_URL", trailingslashit(site_url()));
        $this->rtslider_define("RTSLIDER_SITE_NAME", get_bloginfo('name'));
        $this->rtslider_define("RTSLIDER_RTSLIDER_NAME", get_option('blogname'));
        $this->rtslider_define("RTSLIDER_SITE_DESC", get_bloginfo('description'));
        $this->rtslider_define("RTSLIDER_ADMIN_EMAIL", get_bloginfo('admin_email'));
        $this->rtslider_define('RTSLIDER_ENABLE', 1);
        $this->rtslider_define('RTSLIDER_DISABLE', 0);
        $this->rtslider_define('RTSLIDER_RANDOM_NUMBER', $random_number);
        $this->rtslider_define('RTSLIDER_POST_TYPE', 'rtslider');
        $this->rtslider_define('RTSLIDER_CATEGORY', 'slider_category');
        $this->rtslider_define('PLUGIN_DOMAIN', 'rtslider_domain');
    }

    /**
     * Define constant if not already set.
     *
     * @param string $name Constant name.
     * @param string|bool $value Constant value.
     */
    private function rtslider_define($name, $value)
    {
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
    private function rtslider_is_request($type)
    {
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
    function rtslider_includes()
    {
        if ($this->rtslider_is_request('admin')) {
            include_once RTSLIDER_PLUGIN_PATH . 'includes/admin/plugin_admin.php';
        }
        if ($this->rtslider_is_request('frontend')) {
            include_once RTSLIDER_PLUGIN_PATH . 'includes/frontend/plugin_frontend.php';
        }
    }


    function rt_custom_post_type(){

    }
    function rt_post_type(){
        register_post_type('rtslider',
            array(
                'labels' => array(
                    'name' => __('RT Slider', PLUGIN_DOMAIN),
                    'menu_name' => __('RT Slider', PLUGIN_DOMAIN),
                    'all_items' => __('Slides', PLUGIN_DOMAIN),
                    'add_new' => __('Add New Slide', PLUGIN_DOMAIN),
                    'singular_name' => __('Slide', PLUGIN_DOMAIN),
                    'add_item' => __('New Slide', PLUGIN_DOMAIN),
                    'add_new_item' => __('Add New Slide', PLUGIN_DOMAIN),
                    'edit_item' => __('Edit Slide', PLUGIN_DOMAIN)
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
            'name' => __('Sliders', PLUGIN_DOMAIN),
            'singular_name' => __('Slider', PLUGIN_DOMAIN),
            'search_items' => __('Search Sliders', PLUGIN_DOMAIN),
            'all_items' => __('All Sliders', PLUGIN_DOMAIN),
            'parent_item' => __('Parent Slider', PLUGIN_DOMAIN),
            'parent_item_colon' => __('Parent Slider:', PLUGIN_DOMAIN),
            'edit_item' => __('Edit Slider', PLUGIN_DOMAIN),
            'update_item' => __('Update Slider', PLUGIN_DOMAIN),
            'add_new_item' => __('Add New Slider', PLUGIN_DOMAIN),
            'new_item_name' => __('New Slider Name', PLUGIN_DOMAIN),
            'menu_name' => __('Sliders', PLUGIN_DOMAIN),
        );

        register_taxonomy('slider_category', array('rtslider'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'public' => true,
            'show_admin_column' => true,
        ));
    }

}
