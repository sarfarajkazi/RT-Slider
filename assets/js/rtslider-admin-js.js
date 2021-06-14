jQuery(function ($) {
    var id = $("#post_ID").val();
    var rts = {
        init: function () {
            setTimeout(this.checked_default_chkbox,100);
            var sortList = $(".post-type-rtslider #the-list");
            if(sortList.length)
            {
                sortList.sortable({
                    stop: function(event, ui) {
                        var post_ids=[];
                        var i=1;
                        jQuery('input[name^="post"]').each(function(item,index){
                            value=jQuery(this).attr('value');
                            if(jQuery.isNumeric(value))
                            {
                                post_ids[i++]=value;
                            }
                        });
                        var data_value={"action":"rtslider_post_sortable_handle","post_ids":post_ids}
                        $.ajax({
                            type: 'POST',
                            url: admin_veriables.ajax_url,
                            data:data_value,
                            success: function (data) {
                            }
                        });
                    }
                });
                $( "#the-list" ).disableSelection();
            }
        },
        checked_default_chkbox:function () {
            if(jQuery(document).find('input[name="tax_input[rtslider_category][]"]').length){
                jQuery(document).find('input[name="tax_input[rtslider_category][]"]').prop('checked',false);
                jQuery(document).find('input[name="tax_input[rtslider_category][]"][value='+admin_veriables.default_taxonomy+']').attr('checked',true);
                jQuery(document).find('input[name="tax_input[rtslider_category][]"][value='+admin_veriables.default_taxonomy+']').prop('checked',true);
            }
        }
    };
    rts.init();
});
