$(document).ready(function(){
    $('.fancybox').fancybox({
        padding : 10,
        openEffect  : 'normal',
        closeBtn:false,
        width : 320,
        height : 130,
        autoSize: false
        
    });
    $("#close_fancy").die('click');
    $("#close_fancy").live('click',function(){
        $.fancybox.close();
        location.reload();
    })
})
