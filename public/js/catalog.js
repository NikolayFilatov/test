$(document).ready(function(){
    $('#l_catalog').addClass('button11');

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

    $('.btt_del').click(function(){
        $('.btt_confirm_name').css('display', 'none');
        $('.btt_confirm_group').css('display', 'none');
        $('.btt_del').css('display', 'block');
        $(this).css('display', 'none').next().css('display', 'block');
    });

    $('.btt_confirm_name').click(function(){
        id = $(this).attr('id');
        data = {'id': id};

        xhttp = $.ajax({
            type: "POST",
            url: "/api/removeDish",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });

    $('.btt_confirm_group').click(function(){
        id = $(this).attr('id');
        data = {'id': id};

        xhttp = $.ajax({
            type: "POST",
            url: "/api/removeDishGroup",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });

    $('.btt_ret').click(function(){
        id = $(this).attr('id');
        data = {'id': id};

        xhttp = $.ajax({
            type: "POST",
            url: "/api/restoreDish",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });

    $('.btt_add_group').click(function(){
        name = $(this).prev().val();
        data = {'name': name};

        xhttp = $.ajax({
            type: "POST",
            url: "/api/addDishGroup",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });

    $('.btt_add_dish').click(function(){
        id = $(this).attr('id');
        data = {'id': id};

        xhttp = $.ajax({
            type: "POST",
            url: "/api/addDish",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });


    $('.txt_group').change(function(){
        id = $(this).attr('id');
        d = $(this).val();
        type = 'group';

        updateData(type, d, id)
    });

    $('.txt_name').change(function(){
        id = $(this).attr('id');
        d = $(this).val();
        type = 'name';

        updateData(type, d, id)
    });

    $('.txt_cost').change(function(){
        id = $(this).attr('id');
        d = $(this).val();
        type = 'cost';

        updateData(type, d, id)
    });

    function updateData(type, d, id)
    {
        data = {'id': id,
                'data': d,
                'type': type
            };

        xhttp = $.ajax({
            type: "POST",
            url: "/api/updateCatalog",
            data: data,
            async: true,
            success: function(e){

            }
        });
    }
});