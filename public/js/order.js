$(document).ready(function(){

    $('.li_dish_deleted').css('display', 'none');

    $('.showDeleted').click(function(){
        if($(this).html() == 'Показать удаленные')
        {
            $('.li_dish_deleted').css('display', 'block');
            $(this).html('Скрыть удаленные');
        } else {
            $('.li_dish_deleted').css('display', 'none');
            $(this).html('Показать удаленные');
        }
    });

    $('.btt_add').click(function(){
        id = $(this).attr('id');
        date = $('.label').attr('id');
        data = {
            'id': id,
            'date': date
        };

        $count = $(this).parent().prev().find('.count');
        $count.html($count.html() * 1 + 1);

        $cost = $(this).parent().prev().prev().html() * 1;
        $('.total_cost').html($('.total_cost').html() * 1 + $cost);

        xhttp = $.ajax({
            type: "POST",
            url: "/api/addItemToOrder",
            data: data,
            async: true,
            success: function(e){
                //document.location.reload();
            }
        });
    });

    $('.btt_remove').click(function(){
        id = $(this).attr('id');
        date = $('.label').attr('id');
        data = {
            'id': id,
            'date': date
        };

        $count = $(this).parent().prev().find('.count');
        if ($count.html() * 1 > 0)
        {
            $cost = $(this).parent().prev().prev().html() * 1;
            $('.total_cost').html($('.total_cost').html() * 1 - $cost);

            $count.html($count.html() * 1 - 1);

            xhttp = $.ajax({
                type: "POST",
                url: "/api/removeItemFromOrder",
                data: data,
                async: true,
                success: function(e){
    //                document.location.reload();
                }
            });
        }
    });
});