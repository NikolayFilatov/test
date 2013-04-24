$(document).ready(function(){
    $('#l_orders').addClass('button11');

    $('.close_order').click(function(){
        $(this).css('display', 'none');
        $('.open_order').css('display', 'block');
        $('.li_group').addClass('li_group_close').removeClass('li_group');

        date = $(this).attr('id');
        data = {
            'date': date
        };

        xhttp = $.ajax({
            type: "POST",
            url: "/api/closeOrder",
            data: data,
            async: true,
            success: function(e){

            }
        });
    });

    $('.open_order').click(function(){
        $(this).css('display', 'none');
        $('.close_order').css('display', 'block');
        $('.li_group_close').addClass('li_group').removeClass('li_group_close');

        date = $(this).attr('id');
        data = {
            'date': date
        };

        xhttp = $.ajax({
            type: "POST",
            url: "/api/openOrder",
            data: data,
            async: true,
            success: function(e){

            }
        });
    });
});