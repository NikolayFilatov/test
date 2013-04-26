$(document).ready(function(){
    $('#l_menu_new').addClass('button11');

    ko.applyBindings(MenuModel);

    refreshVars(getAjaxMenu());
});

var MenuModel = {
    currentMenu: ko.observableArray()
}

function refreshVars(data)
{
    MenuModel.currentMenu.removeAll();

    for (var i in data['menu']) {
        MenuModel.currentMenu.push(data['menu'][i]);
    };
}

function getAjaxMenu()
{
    date = $('.curDate').attr('id');
    data = {
        'date': date
    };

    xhttp = $.ajax({
        type: "GET",
        url: "/api/getAjaxMenu",
        data: data,
        async: false
    });

    data = xhttp.responseText;
    data = eval('(' + data + ')');

    console.info(data);

    return data;
}