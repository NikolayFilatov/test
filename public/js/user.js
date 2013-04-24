$(document).ready(function(){
    ColorPicker(
        document.getElementById('slide'),
        document.getElementById('picker'),
        function(hex, hsv, rgb) {
            $('.mess').html("Сохраняю...");
            $('#example').css('background-color', hex);

            console.info(hex);

            data = {'hex': hex};

            xhttp = $.ajax({
                type: "POST",
                url: "/api/updateUserBack",
                data: data,
                async: true,
                success: function(e){

                }
            });
        });

    ColorPicker(
        document.getElementById('slide-color'),
        document.getElementById('picker-color'),
        function(hex, hsv, rgb) {
            $('.mess').html("Сохраняю...");
            $('#example').css('color', hex);

            data = {'hex': hex};

            xhttp = $.ajax({
                type: "POST",
                url: "/api/updateUserColor",
                data: data,
                async: true,
                success: function(e){
                    $('.mess').html("Данные сохранены");
                }
            });
        });

    $('#example').blur(function(){
        data = {'name': $(this).val()};

        xhttp = $.ajax({
            type: "POST",
            url: "/api/updateUserName",
            data: data,
            async: true,
            success: function(e){

            }
        });
    })
});