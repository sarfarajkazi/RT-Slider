<?php

/*
  Plugin Name: RTSlider
  Plugin URI: http://sarfarajkazi.com
  Description: A demo on WordPress shortcode which includes a slider plugin with jQuery slick slider.
  Version: 1.0.0
  Author: Sarfaraj Kazi
  Author URI: http://sarfarajkazi.com
  License: GPL2
  Text Domain: rtslider_domain
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define RTSLIDER_PLUGIN_FILE.
if (!defined('RTSLIDER_PLUGIN_FILE')) {
    define('RTSLIDER_PLUGIN_FILE', __FILE__);
}

// Include the main RTSLIDER class.
if (!class_exists('RTSLIDER')) {
    include_once dirname(__FILE__) . '/includes/class-rtslider-main.php';
}

/**
 * Main instance of RTSLIDER .
 *
 * Returns main instance of RTSLIDER  to prevent the need to use globals.
 *
 * @return RTSLIDER
 * @since 1.0.0
 */
function RT() {
    return RTSLIDER::rtslider_instance();
}

$GLOBALS['RTSLIDER'] = RT();