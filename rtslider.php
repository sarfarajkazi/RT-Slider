<?php
/*
Plugin Name: RTSlider
Plugin URI: #
Description: A demo on WordPress shortcode which includes a slider plugin with jQuery slick slider.
Version: 1.0.0
Author: Sarfaraj Kazi
Author URI: http://sarfarajkazi.com
License: GPL2
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
    include_once dirname(__FILE__) . '/includes/plugin_class_file.php';
}

/**
 * Main instance of RTSLIDER .
 *
 * Returns main instance of RTSLIDER  to prevent the need to use globals.
 *
 * @return RTSLIDER
 * @since 1.0.0
 */
function RT()
{
    return RTSLIDER::rtslider_instance();
}
$GLOBALS['RTSLIDER'] = RT();

function pr($data = false, $flag = false, $display = false)
{
    if (empty($display)) {
        echo "<pre class='direct_display'>";
        if ($flag == 1) {
            print_r($data);
            die;
        } else {
            print_r($data);
        }
        echo "</pre>";
    } else {
        echo "<div style='display:none' class='direct_display'><pre>";
        print_r($data);
        echo "</pre></div>";
    }
}
