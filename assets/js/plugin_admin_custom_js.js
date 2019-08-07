jQuery(function ($) {
    console.log(admin_veriables.ajax_url);
    var id = $("#post_ID").val();
    var rts = {
        init: function () {
            $('#upload-button').on('click', this.upload_image);
            $('#image-view .rt_delete').on('click', this.delete_image);
            $('#image-prev').on('click','.img a',this.delete_image_prev);
            $('.remove_images').on('click', this.remove_image);
            $('#delete_all_images').on('click', this.delete_all_images);
            rts.check_multiple();
            $('input[type=radio][name=items]').change(function () {
                rts.check_multiple();
            });
            var sortList = $('ul#slider_images');
            sortList.sortable({
                update: function (event, ui) {
                    $.ajax({
                        url: admin_veriables.ajax_url,
                        type: 'POST',
                        dataType: 'json',
                        data: {action: 'save_order',id:id, order: sortList.sortable('toArray').toString(), security: admin_veriables.security},
                        success: function (response) {
                            $('div#message').remove();
                            if (true === response.success) {
                                $("#sort_message").append('<div id="message" class="updated below-h2"><p>' + admin_veriables.success + '</p></div>');
                            } else {
                                $("#sort_message").append('<div id="message" class="error below-h2"><p>' + admin_veriables.error + '</p></div>');
                            }
                        },
                        error: function (error) {
                            $('div#message').remove();
                            $("#rts_frm").after('<div id="message" class="error below-h2"><p>' + admin_veriables.error + '</p></div>');
                        }
                    });
                }
            });
        },
        upload_image: function (e) {
            e.preventDefault();
            var mediaUploader;
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: admin_veriables.select_images,
                button: {
                    text: admin_veriables.add
                }, multiple: false
            });
            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').length;
                var a = mediaUploader.state().get('selection').models;
                var images = new Array();
                var html = '';
                jQuery.each(a, function (i, val) {
                    images.push(val.attributes.id);
                    html += "<div class='img' data-attr='" + val.attributes.id + "'><div class='rt_delete'><a href='javascript:void(0)'>x</a></div><img src='" + val.attributes.url + "' height='70' width='70'><input type='hidden' name='attachments[]' value='" + val.attributes.id + "'></div>";
                });
                $('#image-prev p').hide();
                $('#image-prev').append(html);
            });
            mediaUploader.open();
        },
        delete_image: function () {
            var conf = confirm(admin_veriables.confirm);
            if(conf){
                var key = $(this).parent().attr('id');
                $.ajax({
                    url: admin_veriables.ajax_url,
                    type: 'POST',
                    data: {action: 'delete_image', key: key,id:id},
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.status == true) {
                            $("#slider_images li#" + key).remove();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            }
        },
        check_multiple: function () {
            if ($('input[name=items]:checked').val() == 0) {
                $(".multiple_settings").hide();
                $("#fade").show();
            } else {
                $(".multiple_settings").show();
                $("#fade").hide();
            }
        },
        remove_image: function () {
            var ans = confirm(admin_veriables.confirm);
            if (ans) {
                $('#image-prev img').remove();
                $('#image-prev p').fadeIn();
            }
        },
        delete_all_images: function () {
            var ans = confirm(admin_veriables.confirm);
            if (ans) {
                $.ajax({
                    url: admin_veriables.ajax_url,
                    type: 'POST',
                    data: {action: 'delete_all_images',id:id},
                    success: function (response) {
                        location.reload();
                    }
                });
            }
        },
        delete_image_prev: function () {
            $(this).closest(".img").remove().fadeOut();
            if($('#image-prev .img').length == 0){
                $('#image-prev p').fadeIn();
            }
        }
    }
    rts.init();
});
