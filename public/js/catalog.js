$(document).ready(function(){

    $('.btt_del').click(function(){
        $('.btt_confirm_name').css('display', 'none');
        $('.btt_confirm_group').css('display', 'none');
        $('.btt_del').css('display', 'block');
        $(this).css('display', 'none').next().css('display', 'block');
    });

    $('.txt_group').blur(function(){
        id = $(this).attr('id');
        d = $(this).val();
        type = 'group';

        updateData(type, d, id)
    });

    $('.txt_name').blur(function(){
        id = $(this).attr('id');
        d = $(this).val();
        type = 'name';

        updateData(type, d, id)
    });

    $('.txt_cost').blur(function(){
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
                console.info(e);
            }
        });
    }
});