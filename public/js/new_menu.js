$(document).ready(function(){
    $('#l_menu_new').addClass('button11');

    ko.applyBindings(MenuModel);

    refreshMenu(getAjaxMenu());
    refreshList(getAjaxList());
});

var MenuModel = {
    currentMenu: ko.observableArray(),
    listDishes: ko.observableArray(),

    removeItem: function(v1, v2){
        id = v2.currentTarget.id;
        date = $('.curDate').attr('id');
        removeElement(id, date);
    },

    changeItemById: function(v1, v2){
        id = v2.currentTarget.id;
        date = $('.curDate').attr('id');
        changeItemMenuByDay(id, date);
        return true;
    },

    addItemToMenu: function(v1, v2){
        id = v2.currentTarget.id;
        date = $('.curDate').attr('id');
        addItemToMenuAjax(id, date);
    }
}

function refreshList(data)
{
    MenuModel.listDishes.removeAll();

    for (var i in data) {
        MenuModel.listDishes.push(data[i]);
    };
}

function refreshMenu(data)
{
    MenuModel.currentMenu.removeAll();

    for (var i in data['menu']) {
        MenuModel.currentMenu.push(data['menu'][i]);
    };
}

function removeElement(id, date)
{
    data = {
        'id': id,
        'date': date
    };

    xhttp = $.ajax({
        type: "GET",
        url: "/api/removeItemMenu",
        data: data,
        async: false
    });

    data = xhttp.responseText;
    data = eval('(' + data + ')');

    refreshMenu(data);
}

function changeItemMenuByDay(id, date)
{
    data = {
        'id': id,
        'date': date
    };

    xhttp = $.ajax({
        type: "GET",
        url: "/api/changeItemById",
        data: data,
        async: true
    });

//    data = xhttp.responseText;
//    data = eval('(' + data + ')');
//
//    refreshMenu(data);
}

function addItemToMenuAjax(id, date)
{
    data = {
        'id': id,
        'date': date
    };

    xhttp = $.ajax({
        type: "GET",
        url: "/api/addItemToMenu",
        data: data,
        async: false
    });

    data = xhttp.responseText;
    data = eval('(' + data + ')');

    refreshMenu(data);
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

    return data;
}

function getAjaxList()
{
    xhttp = $.ajax({
        type: "GET",
        url: "/api/getAjaxList",
        async: false
    });

    data = xhttp.responseText;
    data = eval('(' + data + ')');

    return data;
}