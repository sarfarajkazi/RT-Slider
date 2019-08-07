<table class="form-table" id="tbl_general_setting">
    <tr class="section_title">
        <td colspan="2"><?php esc_html_e("General settings", PLUGIN_DOMAIN); ?></td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Width", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <input type="number" name="width" value="<?php echo !empty($settings['width']) ? esc_attr($settings['width']) : 900; ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Height", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <input type="number" name="height" value="<?php echo !empty($settings['height']) ? esc_attr($settings['height']) : 250; ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Speed", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <?php $speed = !empty($settings['speed']) ? $settings['speed'] : 600; ?>
            <input type="number" name="speed" value="<?php echo esc_attr($speed) ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Auto Play", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <?php
            foreach ($radio_val_array as $key => $value) {
                $default_checked='';
                $selected = !empty($settings) && $settings['autoplay'] == $key ? "checked" : "";
                if($value=='Yes' && $selected==''){
                    $default_checked='checked';
                }
                echo sprintf("<input type='radio' ".$default_checked." name='term_meta[autoplay]' value='%s' %s> %s ", $key, $selected, $value);
            }
            ?>
        </td>
    </tr>
</table>
<table class="form-table" id="tbl_nav_settings">
    <tr class="section_title">
        <td colspan="2"><?php esc_html_e("Navigation and pagination settings", PLUGIN_DOMAIN); ?></td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Bullets", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <?php
            foreach ($radio_val_array as $key => $value) {
                $default_checked='';
                if($value=='Yes' && $selected==''){
                    $default_checked='checked';
                }
                $selected = !empty($settings) && $settings['bullets'] == $key ? "checked" : "";
                echo sprintf("<input type='radio' ".$default_checked." name='term_meta[bullets]' value='%s' %s> %s ", $key, $selected, $value);
            }
            ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Arrows", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <?php
            foreach ($radio_val_array as $key => $value) {
                $default_checked='';
                if($value=='Yes' && $selected==''){
                    $default_checked='checked';
                }
                $selected = !empty($settings) && $settings['arrows'] == $key ? "checked" : "";
                echo sprintf("<input type='radio' ".$default_checked." name='term_meta[arrows]' value='%s' %s> %s ", $key, $selected, $value);
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>
            <?php esc_html_e("Bullet Color", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <input type="text" name="term_meta[bullet_color]" class="colors" value="<?php echo esc_attr(!empty($settings['bullet_color']) ? $settings['bullet_color'] : "#000") ?>">
        </td>
    </tr>
    <tr>
        <th>
            <?php esc_html_e("Arrow Color", PLUGIN_DOMAIN); ?>
        </th>
        <td>
            <input type="text" name="term_meta[arrow_color]" class="colors" value="<?php echo esc_attr(!empty($settings['arrow_color']) ? $settings['arrow_color'] : "#000") ?>">
        </td>
    </tr>
</table>

<table class="form-table" id="tbl_category_settings">
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="shortcode"><?php _e('Slider shortcode', PLUGIN_DOMAIN); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[shortcode]" id="term_meta[shortcode]" size="50"
                   style="width:100%;"
                   value="<?php echo $tag->slug ? "[rt_slider slider='" . $tag->slug . "']" : ""; ?>" readonly><br/>
            <span class="description"><?php _e('Use this shortcode to insert it on anywhere', PLUGIN_DOMAIN); ?></span>
        </td>
    </tr>
</table>
