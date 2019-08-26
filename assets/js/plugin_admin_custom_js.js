jQuery(function ($) {
    var id = $("#post_ID").val();
    var rts = {
        init: function () {
            var sortList = $(".post-type-rtslides.edit-php #the-list");
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
        }
    };
    rts.init();
});
