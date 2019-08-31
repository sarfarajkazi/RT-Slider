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
    class rtslider_shortcode_handler_admin
    {

        /**
         * Constructor.
         */
        public function __construct()
        {
            add_filter("manage_slider_category_custom_column", array($this, 'manage_theme_columns'), 10, 3);
            add_filter("manage_edit-slider_category_columns", array($this, 'theme_columns'));
            add_action('slider_category_edit_form_fields', array($this, 'slides_category_taxonomy_custom_fields'), 10, 2);
            add_action('edited_slider_category', array($this, 'save_taxonomy_custom_fields'), 10, 2);
            add_action("create_slider_category", array($this, 'add_taxonomy_custom_fields'), 10, 2);
            add_action('add_meta_boxes', array($this, "add_rts_metabox"));
            add_action('save_post', array($this, "save_slider_images"));
            add_action("wp_ajax_rtslider_post_sortable_handle", array($this, 'rtslider_post_sortable_handle'));
            add_filter('parse_query', array($this, 'rtslider_privacy_list_handle'));
        }

        function manage_theme_columns($out, $column_name, $theme_id)
        {
            $theme = get_term($theme_id, 'slider_category');
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

        function theme_columns($theme_columns)
        {
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => __('Title', PLUGIN_DOMAIN),
                'shortcode' => __('Shortcode', PLUGIN_DOMAIN),
                'slug' => __('Slug', PLUGIN_DOMAIN),
                'posts' => __('Slides', PLUGIN_DOMAIN)
            );
            return $new_columns;
        }

        function slides_category_taxonomy_custom_fields($tag)
        {
            $t_id = $tag->term_id; // Get the ID of the term you're editing
            $settings = get_option("taxonomy_term_$t_id");
            $radio_val_array = array(true => "Yes", false => "No");

            include_once RTSLIDER_ADMIN_TEMPLATES . 'sliders_category_custom_fields.php';
        }

        function save_taxonomy_custom_fields($term_id)
        {
            if (isset($_POST['term_meta'])) {
                $t_id = $term_id;
                $term_meta = get_option("taxonomy_term_$t_id");
                $cat_keys = array_keys($_POST['term_meta']);
                foreach ($cat_keys as $key) {
                    if (isset($_POST['term_meta'][$key])) {
                        $term_meta[$key] = $_POST['term_meta'][$key];
                    }
                }

                update_option("taxonomy_term_$t_id", $term_meta);
            }
        }

        function add_taxonomy_custom_fields($term_id, $tt_id)
        {

            $category_object_meta = get_term_by('id', $term_id, RTSLIDER_CATEGORY);
            if (!is_wp_error($category_object_meta)) {
                $term_slug = $category_object_meta->slug;
            }
            $default_val = array('width' => 900, 'height' => 250, 'speed' => 600, 'autoplay' => 'true', 'bullets' => 'true', 'arrows' => 'true', 'bullet_color' => '#000', 'arrow_color' => '#000', 'shortcode' => "[rt_slider slider='$term_slug']");
            update_option("taxonomy_term_$term_id", $default_val);

        }

        function add_rts_metabox()
        {
            add_meta_box('rts_metabox', __("RT slider settings", PLUGIN_DOMAIN), array($this, "display_rts_metabox"), array('rtslider'), 'normal', 'high');
        }

        function display_rts_metabox()
        {
            global $post;
            $settings = get_post_meta($post->ID, 'post_settings', true);
            $radio_val_array = array('1' => "Yes", '0' => "No");

            include_once RTSLIDER_ADMIN_TEMPLATES . 'sliders_custom_fields.php';
        }

        function save_slider_images($post_id)
        {
            $post_type = get_post_type($post_id);
            if ("rtslider" != $post_type) {
                return;
            }
            if (isset($_POST['post_meta'])) {
                $post_keys = array_keys($_POST['post_meta']);
                foreach ($post_keys as $key) {
                    if (isset($_POST['post_meta'][$key])) {
                        $post_meta[$key] = $_POST['post_meta'][$key];
                    }
                }
                update_post_meta($post_id, 'post_settings', $post_meta);
            }

        }

        function rtslider_privacy_list_handle($query)
        {
            global $pagenow;
            $post_type_input = filter_input(INPUT_GET, "post_type");
            $post_type = $post_type_input ? $post_type_input : '';
            if (is_admin() && $pagenow == 'edit.php' && $post_type == 'rtslider') {
                $query->query_vars['order'] = 'ASC';
                $query->query_vars['orderby'] = 'menu_order';
            }
        }

        function rtslider_post_sortable_handle()
        {
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
