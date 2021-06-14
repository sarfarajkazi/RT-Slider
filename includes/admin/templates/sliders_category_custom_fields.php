<?php
$t_id = $tag->term_id; // Get the ID of the term you're editing
$settings=get_term_meta($tag->term_id,'terms_slider_setting',true);
if(is_wp_error($settings)){
    $settings=array();
}
$radio_val_array = array(true => "Yes", false => "No");
?>
<table class="form-table" id="tbl_general_setting">
    <tr class="section_title">
        <td colspan="2"><?php esc_html_e("General settings", 'rtslider_domain'); ?></td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Width", 'rtslider_domain'); ?>
        </th>
        <td>
            <input type="number" name="term_meta[width]" value="<?php echo!empty($settings['width']) ? esc_attr($settings['width']) : 900; ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Height", 'rtslider_domain'); ?>
        </th>
        <td>
            <input type="number" name="term_meta[height]" value="<?php echo!empty($settings['height']) ? esc_attr($settings['height']) : 250; ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Speed", 'rtslider_domain'); ?>
        </th>
        <td>
            <?php $speed = !empty($settings['speed']) ? $settings['speed'] : 600; ?>
            <input type="number" name="term_meta[speed]" value="<?php echo esc_attr($speed) ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Auto Play", 'rtslider_domain'); ?>
        </th>
        <td>
            <?php
            foreach ($radio_val_array as $key => $value) {
                $selected = !empty($settings) && $settings['autoplay'] == $key ? "checked" : "";
                echo sprintf("<input type='radio' name='term_meta[autoplay]' value='%s' %s> %s ", $key, $selected, $value);
            }
            ?>
        </td>
    </tr>
</table>
<table class="form-table" id="tbl_nav_settings">
    <tr class="section_title">
        <td colspan="2"><?php esc_html_e("Navigation and pagination settings", 'rtslider_domain'); ?></td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Bullets", 'rtslider_domain'); ?>
        </th>
        <td>
            <?php
            foreach ($radio_val_array as $key => $value) {
                $selected = !empty($settings) && $settings['bullets'] == $key ? "checked" : "";
                echo sprintf("<input type='radio' name='term_meta[bullets]' value='%s' %s> %s ", $key, $selected, $value);
            }
            ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Arrows", 'rtslider_domain'); ?>
        </th>
        <td>
            <?php
            foreach ($radio_val_array as $key => $value) {
                $selected = !empty($settings) && $settings['arrows'] == $key ? "checked" : "";
                echo sprintf("<input type='radio'  name='term_meta[arrows]' value='%s' %s> %s ", $key, $selected, $value);
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>
            <?php esc_html_e("Bullet Color", 'rtslider_domain'); ?>
        </th>
        <td>
            <input type="text" name="term_meta[bullet_color]" class="colors" value="<?php echo esc_attr(!empty($settings['bullet_color']) ? $settings['bullet_color'] : "#000") ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Arrow Color", 'rtslider_domain'); ?>
        </th>
        <td>
            <input type="text" name="term_meta[arrow_color]" class="colors" value="<?php echo esc_attr(!empty($settings['arrow_color']) ? $settings['arrow_color'] : "#000") ?>">
        </td>
    </tr>
</table>

<table class="form-table" id="tbl_category_settings">
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="shortcode"><?php _e('Slider shortcode', 'rtslider_domain'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[shortcode]" id="term_meta[shortcode]" size="50"
                   style="width:100%;"
                   value="<?php echo $tag->slug ? "[rt_slider slider='" . $tag->slug . "']" : ""; ?>" readonly><br/>
            <span class="description"><?php _e('Use this shortcode to insert it on anywhere', 'rtslider_domain'); ?></span>
        </td>
    </tr>
</table>
<?php
wp_nonce_field('rtslider_cat_save', 'rtslider_cat_edit');
?>