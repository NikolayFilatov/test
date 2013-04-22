$(document).ready(function(){
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

});