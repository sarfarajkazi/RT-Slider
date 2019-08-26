<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle all Shortcode Requests
 * @class rtslider_shortcode_handler
 * @since 1.0.0
 * @author Sarfaraj Kazi
 */
class rtslider_shortcode_handler
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        add_shortcode('rt_slider', array($this, 'rt_slider_callback'));
    }

    function rt_slider_callback($atts)
    {
        $html = "";
        if (!isset($atts['slider'])) {
            $html .= sprintf("<div class='shortcode_warning'><strong>%s</strong></div>", __("No slider found.", PLUGIN_DOMAIN));
            return $html;
        } else {
            $term_id=0;
            $slider = $atts['slider'];
            $post_ids1 = array();
            $category_object_meta = get_term_by('slug', $slider, RTSLIDER_CATEGORY);
            if (!is_wp_error($category_object_meta)) {
                $term_id = $category_object_meta->term_id;
            }
            if($term_id){
                $term_metas=get_option("taxonomy_term_$term_id");
            }
            $args = array(
                'post_type' => RTSLIDER_POST_TYPE,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => RTSLIDER_CATEGORY,
                        'field' => 'slug',
                        'terms' => $slider
                    )
                )
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                $slick_settings = json_encode($term_metas);
                $html .= "<div id='slick_settings' data-settings='$slick_settings'></div>";
                $html .= "<div class='slick_slider'>";
                foreach ($query->posts as $single_post) {
                    $img_src=wp_get_attachment_url( get_post_thumbnail_id( $single_post->ID ));
                    $html .= sprintf("<div class='rt_image'><img src='%s'/></div>",$img_src);
                }
                $html .= "</div>";
            }
            return $html;
        }
    }
}

return new rtslider_shortcode_handler();