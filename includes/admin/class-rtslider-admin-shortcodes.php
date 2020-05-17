<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Slider shortcode
 * @class rtslider_shortcode_handler_admin
 * @since 1.0.0
 * @author Sarfaraj Kazi
 */
if (!class_exists('rtslider_shortcode_handler_admin')):

    class rtslider_shortcode_handler_admin {

        /**
         * Constructor.
         */
        public function __construct() {
            add_filter("manage_rtslider_category_custom_column", array($this, 'rtslider_manage_theme_columns'), 10, 3);
            add_filter("manage_edit-rtslider_category_columns", array($this, 'rtslider_theme_columns'));
            add_action('rtslider_category_edit_form_fields', array($this, 'rtslider_slides_category_taxonomy_custom_fields'), 10, 2);
            add_action('edited_rtslider_category', array($this, 'rtslider_save_taxonomy_custom_fields'), 10, 2);
            add_action("create_rtslider_category", array($this, 'rtslider_add_taxonomy_custom_fields'), 10, 2);
            add_action('add_meta_boxes', array($this, "rtslider_add_rts_metabox"));
            add_action('save_post', array($this, "rtslider_save_slider_images"));
            add_action("wp_ajax_rtslider_post_sortable_handle", array($this, 'rtslider_post_sortable_handle'));
            add_filter('parse_query', array($this, 'rtslider_privacy_list_handle'));
        }

        /**
         * Filters the custom category columns.
         *
         */
        function rtslider_manage_theme_columns($out, $column_name, $theme_id) {
            $theme = get_term($theme_id, RTSLIDER_CATEGORY);
            switch ($column_name) {
                case 'shortcode':
                    $data = maybe_unserialize($theme->description);
                    $out .= "[rt_slider slider='" . $theme->slug . "']";
                    break;
                default:
                    break;
            }
            return $out;
        }

        /**
         * Add new columns in slider category.
         *
         */
        function rtslider_theme_columns($theme_columns) {
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => __('Title', 'rtslider_domain'),
                'shortcode' => __('Shortcode', 'rtslider_domain'),
                'slug' => __('Slug', 'rtslider_domain'),
                'posts' => __('Slides', 'rtslider_domain')
            );
            return $new_columns;
        }

        /**
         * Display custom options in categories
         *
         */
        function rtslider_slides_category_taxonomy_custom_fields($tag) {
            include_once RTSLIDER_ADMIN_TEMPLATES . 'sliders_category_custom_fields.php';
        }

        /**
         * Save custom fields of taxonomy.
         *
         */
        function rtslider_save_taxonomy_custom_fields($term_id) {
            $term_meta_nonce = filter_input(INPUT_POST, "rtslider_cat_edit");
            if (wp_verify_nonce($term_meta_nonce, 'rtslider_cat_save')) {
                $t_id = $term_id;
                $term_meta = get_option("taxonomy_term_$t_id");
                $term_meta_post = filter_input(INPUT_POST, 'term_meta', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                $cat_keys = array_keys($term_meta_post);
                foreach ($cat_keys as $key) {
                    if (isset($term_meta_post[$key])) {
                        $term_meta[$key] = $term_meta_post[$key];
                    }
                }
                update_option("taxonomy_term_$t_id", $term_meta);
            }
        }

        /**
         * Save default values of slider.
         *
         *
         */
        function rtslider_add_taxonomy_custom_fields($term_id, $tt_id) {

            $category_object_meta = get_term_by('id', $term_id, RTSLIDER_CATEGORY);
            if (!is_wp_error($category_object_meta)) {
                $term_slug = $category_object_meta->slug;
            }
            $default_val = array('width' => 900, 'height' => 250, 'speed' => 600, 'autoplay' => 'true', 'bullets' => 'true', 'arrows' => 'true', 'bullet_color' => '#000', 'arrow_color' => '#000', 'shortcode' => "[rt_slider slider='$term_slug']");
            update_option("taxonomy_term_$term_id", $default_val);
        }

        function rtslider_add_rts_metabox() {
            add_meta_box('rts_metabox', __("RT slider settings", 'rtslider_domain'), array($this, "rtslider_display_rts_metabox"), array('rtslider'), 'normal', 'high');
        }

        function rtslider_display_rts_metabox() {
            include_once RTSLIDER_ADMIN_TEMPLATES . 'sliders_custom_fields.php';
        }

        /**
         * Save slides custom options.
         *
         */
        function rtslider_save_slider_images($post_id) {
            $post_type = get_post_type($post_id);
            if ("rtslider" != $post_type) {
                return;
            }
            $post_meta = array();

            $post_meta_nonce = filter_input(INPUT_POST, "rtslider_post_edit");
            if (wp_verify_nonce($post_meta_nonce, 'rtslider_post_save')) {
                $post_meta_form = filter_input(INPUT_POST, 'post_meta', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                $post_keys = array_keys($post_meta_form);
                foreach ($post_keys as $key) {
                    if (isset($post_meta_form[$key])) {
                        $post_meta[$key] = $post_meta_form[$key];
                    }
                }
                update_post_meta($post_id, 'post_settings', $post_meta);
            }
        }

        /**
         * Filter to Display slider list as per menu order.
         *
         * @param array $query Array of associated post query parameters.
         */
        function rtslider_privacy_list_handle($query) {
            global $pagenow;
            $post_type_input = filter_input(INPUT_GET, "post_type");
            $post_type = $post_type_input ? $post_type_input : '';
            if (is_admin() && $pagenow == 'edit.php' && $post_type == 'rtslider') {
                $query->query_vars['order'] = 'ASC';
                $query->query_vars['orderby'] = 'menu_order';
            }
        }

        /**
         * Handle / save post sorting orders.
         *
         */
        function rtslider_post_sortable_handle() {
            $post_ids = filter_input(INPUT_POST, 'post_ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            if (!empty($post_ids)) {
                foreach ($post_ids as $position => $post_id) {
                    if ($post_id) {
                        $postarr = array(
                            "ID" => $post_id,
                            "menu_order" => $position
                        );
                        wp_update_post($postarr);
                    }
                }
            }
            die;
        }

    }

    endif;
return new rtslider_shortcode_handler_admin();
