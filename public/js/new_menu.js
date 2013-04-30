$(document).ready(function(){
    $('#l_menu_new').addClass('button11');

    ko.applyBindings(MenuModel);

    refreshMenu(getAjaxMenu());
    refreshList(getAjaxList('', ''));

    $('.check').click(function()
    {
        goFind()
    });

    $('.txt_find').blur(function(){
        goFind()
    });

    $('.bttAddAll').click(function(){
        if(MenuModel.listDishes().length < 40)
        {
            arr_id = MenuModel.listDishes();
            date = $('.curDate').attr('id');
            addGroupItemToMenuAjax(arr_id, date);
        } else {
            alert ('Уточните выборку, слишком много элементов');
        }
    });

    $('.bttRemoveAll').click(function(){
        $(this).css('display', 'none').next().css('display', 'block');
    });

    $('.bttConfirmRemoveAll').click(function(){
        date = $('.curDate').attr('id');
        removeAllItemFromMenu(date);
    });

    function goFind()
    {
        str = '';
        $('.check').each(function(){
            if($(this).attr('checked') == 'checked')
                str = str + $(this).attr('id')

        });

        like = $('.txt_find').val();
        refreshList(getAjaxList(str, like));
    }

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

function addGroupItemToMenuAjax(arr_id, date)
{
    $('.div_wait').css('display', 'block');
    data = {
        'arr_id': arr_id,
        'date': date
    };

    xhttp = $.ajax({
        type: "GET",
        url: "/api/addGroupItemToMenu",
        data: data,
        async: true,
        success: function(data){
            refreshMenu(data);
            $('.div_wait').fadeOut('fast');
        }
    });
}

function removeAllItemFromMenu(date)
{
    $('.div_wait').css('display', 'block');
    data = {
        'date': date
    };

    xhttp = $.ajax({
        type: "GET",
        url: "/api/removeAllItemFromMenu",
        data: data,
        async: true,
        success: function(data){
            refreshMenu(data);
            $('.div_wait').fadeOut('fast');
            $('.bttConfirmRemoveAll').css('display', 'none');
            $('.bttRemoveAll').fadeIn();
        }
    });
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

function getAjaxList(groups, like)
{
    data = {
        'groups': groups,
        'like': like
    }

    xhttp = $.ajax({
        type: "GET",
        url: "/api/getAjaxList",
        data: data,
        async: false
    });

    data = xhttp.responseText;

    data = eval('(' + data + ')');

    return data;
}