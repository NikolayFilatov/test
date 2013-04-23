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

    $('.create_menu_catalog').click(function(){
        id = $(this).attr('id');
        data = {'id': id};

        xhttp = $.ajax({
            type: "POST",
            url: "/api/createMenuCatalog",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });

    $('.exclude').click(function(){
        id = $(this).attr('id');
        data = {
            'id': id
        }

        xhttp = $.ajax({
            type: "POST",
            url: "/api/excludeMenu",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });

    $('.include').click(function(){
        id = $(this).attr('id');
        data = {
            'id': id
        }

        xhttp = $.ajax({
            type: "POST",
            url: "/api/includeMenu",
            data: data,
            async: true,
            success: function(e){
                document.location.reload();
            }
        });
    });
});