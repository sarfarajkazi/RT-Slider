<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle all Admin Requests
 *
 * @class rtslider_admin
 * @since 1.0.0
 * @author Sarfaraj Kazi
 */
class rtslider_admin
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->rtslider_admin_includes();
    }

    /**
     * include admin assests file
     */
    public function rtslider_admin_includes()
    {
        include_once RTSLIDER_PLUGIN_PATH . 'includes/admin/plugin_admin_assets.php';
        include_once RTSLIDER_PLUGIN_PATH . 'includes/admin/plugin_admin_action_handler.php';
    }
}

return new rtslider_admin();