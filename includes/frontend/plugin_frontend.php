<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle all Front Requests
 *
 * @class rtslider_frontend
 * @since 1.0.0
 * @author Sarfaraj Kazi
 */
if (!class_exists('rtslider_frontend', false)) :
    class rtslider_frontend
    {
        /**
         * Constructor.
         */
        public function __construct()
        {
            include_once RTSLIDER_PLUGIN_PATH . 'includes/frontend/plugin_front_action_handler.php';
            include_once RTSLIDER_PLUGIN_PATH . 'includes/frontend/plugin_front_assets.php';
        }

    }
endif;
return new rtslider_frontend();
