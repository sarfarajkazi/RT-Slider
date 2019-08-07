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
            add_action('init', array($this, 'create_slider_post_type'));
            add_filter("manage_slides_category_custom_column", array($this, 'manage_theme_columns'), 10, 3);
            add_filter("manage_edit-slides_category_columns", array($this, 'theme_columns'));
            add_action('slides_category_edit_form_fields', array($this, 'slides_category_taxonomy_custom_fields'), 10, 2);
            add_action( 'edited_slides_category', array($this, 'save_taxonomy_custom_fields'), 10, 2 );
            add_action('add_meta_boxes', array($this, "add_rts_metabox"));
            add_action('save_post', array($this, "save_slider_images"));
        }

        function create_slider_post_type()
        {

            register_post_type('rtslides',
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
                    'rewrite' => array('slug' => 'rtslides'),
                    'menu_position' => 4,
                    'show_ui' => true,
                    'has_archive' => false,
                    'hierarchical' => false,
                    'supports' => array('title', 'page-attributes', 'editor','thumbnail'),
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

            register_taxonomy('slides_category', array('rtslides'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'show_admin_column' => true,
                'rewrite' => array('slug' => 'slides-category'),
            ));

        }

        function manage_theme_columns($out, $column_name, $theme_id)
        {
            $theme = get_term($theme_id, 'slides_category');
            switch ($column_name) {
                case 'shortcode':
                    $data = maybe_unserialize($theme->description);
                    $out .= "[rt_slider slider='" . $theme->slug . "' auto_start='true' height='' show_navigation_arrows='yes']";
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
                'posts' => __('Sliders', PLUGIN_DOMAIN)
            );
            return $new_columns;
        }

        function slides_category_taxonomy_custom_fields($tag)
        {
            $t_id = $tag->term_id; // Get the ID of the term you're editing
            $settings = get_option("taxonomy_term_$t_id");
            $radio_val_array=array('1'=>"Yes",'0'=>"No");
            include_once RTSLIDER_ADMIN_TEMPLATES.'sliders_category_custom_fields.php';
        }

        function save_taxonomy_custom_fields( $term_id ) {
            if ( isset( $_POST['term_meta'] ) ) {
                $t_id = $term_id;
                $term_meta = get_option( "taxonomy_term_$t_id" );
                $cat_keys = array_keys( $_POST['term_meta'] );
                foreach ( $cat_keys as $key ){
                    if ( isset( $_POST['term_meta'][$key] ) ){
                        $term_meta[$key] = $_POST['term_meta'][$key];
                    }
                }
                update_option( "taxonomy_term_$t_id", $term_meta );
            }
        }

        function add_rts_metabox(){
            add_meta_box('rts_metabox', __("RT slider settings", PLUGIN_DOMAIN), array($this, "display_rts_metabox"), array('rtslides'), 'normal', 'high');
        }
        function display_rts_metabox(){
            global $post;
            $settings = get_post_meta($post->ID,'post_settings',true);
            $radio_val_array=array('1'=>"Yes",'0'=>"No");
            include_once RTSLIDER_ADMIN_TEMPLATES.'sliders_custom_fields.php';
        }

        function save_slider_images($post_id){
            $post_type = get_post_type($post_id);
            if ("rtslides" != $post_type) {
                return;
            }
            if ( isset( $_POST['post_meta'] ) ) {
                $post_keys = array_keys( $_POST['post_meta'] );
                foreach ( $post_keys as $key ){
                    if ( isset( $_POST['post_meta'][$key] ) ){
                        $post_meta[$key] = $_POST['post_meta'][$key];
                    }
                }
                update_post_meta($post_id,'post_settings',$post_meta);
            }

        }
    }
endif;
return new rtslider_shortcode_handler_admin();
