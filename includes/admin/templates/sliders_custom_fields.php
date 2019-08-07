<div class="wrap">
    <form method="post" id="rts_frm">
        <table class="form-table" id="tbl_images">
            <tr>
                <th><?php esc_html_e("Show title on slider ?", "rts"); ?></th>
                <td>
                    <?php
                    foreach ($radio_val_array as $key => $value) {
                        $default_checked='';
                        $selected = !empty($settings) && $settings['show_title'] == $key ? "checked" : "";
                        if($value=='Yes' && $selected==''){
                            $default_checked='checked';
                        }
                        echo sprintf("<input type='radio' ".$default_checked." name='post_meta[show_title]' value='%s' %s> %s ", $key, $selected, $value);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e("Show description on slider ?", "rts"); ?></th>
                <td>
                    <?php
                    foreach ($radio_val_array as $key => $value) {
                        $default_checked='';
                        $selected = !empty($settings) && $settings['show_desc'] == $key ? "checked" : "";
                        if($value=='Yes' && $selected==''){
                            $default_checked='checked';
                        }
                        echo sprintf("<input type='radio' ".$default_checked." name='post_meta[show_desc]' value='%s' %s> %s ", $key, $selected, $value);
                    }
                    ?>
                </td>
            </tr>
        </table>
    </form>
</div>