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

        xhttp = $.ajax({
            type: "POST",
            url: "/api/addItemToOrder",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
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

        xhttp = $.ajax({
            type: "POST",
            url: "/api/removeItemFromOrder",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });
});