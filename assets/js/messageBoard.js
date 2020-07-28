function countMsg() {
    return $("div [name='msg']").length;
}

function decideShowNoMsg() {
    if (countMsg() == 0) {
        var messages = $('#messages');
        messages.append("<div>[目前沒有留言]</div>");
        messages.append("<hr>");
    }
}

function get(q) {
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'get',
        data: {
            'q': q,
        },
        success: function (msg) {
            if (msg['success'] == 1) {
                $('#input-user').val(msg['formContent']['user']);
                $('#input-content').val(msg['formContent']['content']);
                $('#id').val(msg['formContent']['id']);
                $('#submit_button').attr('name', msg['formContent']['action']);
            }
            alert(msg['alertMsg']);
        }
    });
}

function remove(q) {
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'remove',
        data: {
            'q': q,
        },
        success: function (msg) {
            if (msg['success'] == 1) {
                $("div #" + q).remove();
                decideShowNoMsg();
            }
            alert(msg['alertMsg']);
        }
    });
}

function initInput() {
    $('#input-user').val("");
    $('#input-content').val("");
    $('#id').val("");
    $('#submit_button').attr('name', 'add');
}

$(document).ready(function () {
    // init
    initInput();

    // list
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'list',
        success: function (msg) {
            //alertMsg
            if (msg['alertMsg'] != "") alert(msg['alertMsg']);
            var messages = $('#messages');

            //messages
            if (msg['success'] == -1) {
                decideShowNoMsg();
            } else {
                for (i = 0; i < msg['messages'].length; i++) {
                    var divMsg = document.createElement('DIV');
                    $(divMsg).attr({
                        'name': 'msg',
                        'id': $.base64.btoa(msg['messages'][i]['id']),
                    });
                    $(divMsg).append('<div id="user"><h3><b>' + msg['messages'][i]['user'] + '</b></h3></div>');
                    $(divMsg).append('<div id="content">' + msg['messages'][i]['content'] + '</div>');
                    $(divMsg).append('<div id="time">' + msg['messages'][i]['time'] + '</div>');
                    $(divMsg).append('<button type="submit" onclick="get(\'' + $.base64.btoa(msg['messages'][i]['id']) + '\')" id="get">編輯</button>');
                    $(divMsg).append('<button type="submit" onclick="remove(\'' + $.base64.btoa(msg['messages'][i]['id']) + '\')" id="remove">刪除</button>');
                    $(divMsg).append("<hr>");
                    messages.append(divMsg);
                }
            }

            //formContent
            $('#input-user').val(msg['formContent']['user']);
            $('#input-content').text(msg['formContent']['content']);
            $('#id').val(msg['formContent']['id']);
            $('#submit_button').attr('name', msg['formContent']['action']);
        }
    });

    // clean
    $('#clean').click(function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'clean',
            success: function (msg) {
                if (msg['success'] == 1) {
                    alert(msg['alertMsg']);
                    var messages = $('#messages');
                    messages.html("");
                    decideShowNoMsg();
                }
            }
        })
    });

    $('#submit_button').click(function () {
        // add
        if ($('#submit_button').attr('name') == "add") {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'add',
                data: {
                    'input-user': $('#input-user').val(),
                    'input-content': $('#input-content').val(),
                },
                success: function (msg) {
                    alert(msg['alertMsg']);
                    var messages = $('#messages');
                    if (msg['success'] == 1) {
                        if (countMsg() == 0) {
                            messages.html("");
                        }
                        var divMsg = document.createElement('DIV');
                        $(divMsg).attr({
                            'name': 'msg',
                            'id': $.base64.btoa(msg['message_by_id'][0]['id']),
                        });
                        $(divMsg).append('<div id="user"><h3><b>' + msg['message_by_id'][0]['user'] + '</b></h3></div>');
                        $(divMsg).append('<div id="content">' + msg['message_by_id'][0]['content'] + '</div>');
                        $(divMsg).append('<div id="time">' + msg['message_by_id'][0]['time'] + '</div>');
                        $(divMsg).append('<button type="submit" onclick="get(\'' + $.base64.btoa(msg['message_by_id'][0]['id']) + '\')" id="get">編輯</button>');
                        $(divMsg).append('<button type="submit" onclick="remove(\'' + $.base64.btoa(msg['message_by_id'][0]['id']) + '\')" id="remove">刪除</button>');
                        $(divMsg).append("<hr>");
                        messages.append(divMsg);
                        initInput();
                    }
                }
            })
        } else if ($('#submit_button').attr('name') == "edit") {
            var id = $('#id').val();
            var user = $('#input-user').val();
            var content = $('#input-content').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'edit',
                data: {
                    'id': id,
                    'input-user': user,
                    'input-content': content,
                },
                success: function (msg) {
                    if (msg['success'] == 1) {
                        $('#' + $.base64.btoa(id) + ' > #user > h3 > b').text(msg['message_by_id'][0]['user']);
                        $('#' + $.base64.btoa(id) + ' > #content').text(msg['message_by_id'][0]['content']);
                        $('#' + $.base64.btoa(id) + ' > #time').text(msg['message_by_id'][0]['time']);
                        // TODO: 時間和id也要改
                    }
                    alert(msg['alertMsg']);
                    initInput();
                }
            })
        }
    });
});