$(document).ready(function(){
    $( ".wgbc_handle" ).mousedown(function(){
        $(this).css('cursor','grabbing');
    })
    $( ".wgbc_handle" ).mouseup(function(){
        $(this).css('cursor','grab');
    })
    $( document ).mouseleave(function(){
        $('.wgbc_handle').css('cursor','grab');
    })
    $('[id^="slidebar"]').click(function(){
        $(this).parent().toggleClass('wgbc_noheight');
    })
    $( "#wgbc_sortable" ).sortable({
        axis: "y",
        handle: '.wgbc_handle',
        opacity: 0.5,
        stop: function() {
            var i = 1;
            $(this).children("div").each(function(idx, elt) {
                $(elt).children(".wgbc_metbox_right").children("[id^='caption_']").attr("name", 'caption_'+i );
                $(elt).children(".wgbc_metbox_right").children("[id^='caption_h_']").attr("name", 'caption_h_'+i );
                $(elt).children(".wgbc_metbox_left").children("#hidden_input_name").attr("name", 'admin_slide'+i+'_img_name');
                $(elt).children(".wgbc_metbox_left").children("#hidden_input_url").attr("name", 'admin_slide'+i+'_img_url');
                i++;
            });
        }
    });
})
