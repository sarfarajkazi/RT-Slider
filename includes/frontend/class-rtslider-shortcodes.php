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
class rtslider_shortcode_handler {
    /**
     * Constructor.
     */
    public function __construct() {
        add_shortcode('rt_slider', array($this, 'rt_slider_callback'));
    }
    /**
     * Display rt_slider shortcode callback
     *
     *
     * @param array $atts for slider ids
     *
     * @return string $html view of shortcode.
     */
    function rt_slider_callback($atts) {
        $html = "";
        if (!isset($atts['slider'])) {
            $html .= sprintf("<div class='shortcode_warning'><strong>%s</strong></div>", __("No slider found.", 'rtslider_domain'));
            return $html;
        } else {
            $term_id = 0;
            $slider = $atts['slider'];
            $category_object_meta = get_term_by('slug', $slider, RTSLIDER_CATEGORY);
            if (!is_wp_error($category_object_meta)) {
                $term_id = $category_object_meta->term_id;
            }
            if ($term_id) {
                $term_metas=get_term_meta($term_id,'terms_slider_setting',true);
	            if(is_wp_error($term_metas) || !is_array($term_metas)){
		            $term_metas=array();
	            }
            }
            $args = array(
                'post_type' => RTSLIDER_POST_TYPE,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => RTSLIDER_CATEGORY,
                        'field' => 'term_id',
                        'terms' => $term_id
                    )
                )
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                unset($term_metas['shortcode']);
                $slick_settings_json = json_encode($term_metas);
                $slick_settings=esc_attr($slick_settings_json);
                $html .= "<div id='slick_settings' data-settings='$slick_settings'></div>";
                $html .= "<div class='slick_slider'>";
                foreach ($query->posts as $single_post) {
                    $post_settings = get_post_meta($single_post->ID, 'post_settings', true);
                    extract($post_settings);
                    $img_src = wp_get_attachment_url(get_post_thumbnail_id($single_post->ID));
                    $html .= "<div class='rt_image'>";
                    $html .= sprintf('<img src="%s"/>', $img_src);
                    if ($show_title) {
                        $html .= sprintf("<span class='slider-text'>%s</span>", $single_post->post_title);
                    }
                    if ($show_desc) {
                        $html .= sprintf("<p class='slider-desc'>%s</p>", $single_post->post_content);
                    }
                    $html .= "</div>";
                }
                $html .= "</div>";
            }
            return $html;
        }
    }
}
return new rtslider_shortcode_handler();
