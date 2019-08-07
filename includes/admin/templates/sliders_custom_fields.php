<div class="wrap">
    <form method="post" id="rts_frm">
        <div id="sort_message"></div>
        <div id="image-view">
            <?php
            if ($slider_images) {
                asort($slider_images);
                ?>
                <?php
                echo '<ul id="slider_images">';
                foreach ($slider_images as $key => $value) {
                    echo sprintf("<li id='%s'><div class='rt_delete'><a href='javascript:void(0);'>x</a></div><img class='image-preview' src='%s'></li>", $key, wp_get_attachment_url($key));
                }
                echo '</ul>';
                ?>
                <?php
            }
            ?>
        </div>
        <table class="form-table" id="tbl_images">

            <tr>
                <th><?php esc_html_e("Choose Slider Images", "rts"); ?></th>
                <td><button id="upload-button" type="button" class="button">
                        <i class="dashicons dashicons-format-gallery"></i><?php esc_html_e(" Choose Images", 'rts') ?>
                    </button>
                    <button type="button" class="button button-secondary remove_images">
                        <i class="dashicons dashicons-trash"></i> <?php esc_html_e(" Remove Images", 'rts') ?>
                    </button>
                    <input id="image-url" type="hidden" name="urls" />
                    <input type='hidden' name='attachments' id='attachments' value=''>
                    <div id="image-prev">
                        <p><?php esc_html_e("No Slider Images", "rts"); ?></p>
                    </div>
                </td>
            </tr>
        </table>
        <?php
        if($slider_images){
            ?>
            <a id="delete_all_images" class="button button-primary"> <?php echo esc_attr("Delete All Images", "rts") ?> </a>
        <?php
        }
        ?>

    </form>
</div>