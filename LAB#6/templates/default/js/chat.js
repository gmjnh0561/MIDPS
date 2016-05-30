function update_count() {
    $.get("server.php?action=count", function( data ) {
        $("#count").html(data);
    });
}

function quit() {
    $.get("server.php?action=quit", function( data ) {
        window.location.replace("/");
    });
}

function scroll_down() {
    chat = $('#html');
    chat.scrollTop(chat[0].scrollHeight)
}

function change_title() {
    $.titleAlert("[New chat message!]", {
        requireBlur:true,
        stopOnFocus:true,
        interval:1000
    });
}

function room() {
    $.get("server.php?action=room", function( data ) {
        if(data != '') {
            $("#html").append(data);
            scroll_down();
            change_title();
        }
    });
}

function send_text(chat_text) {
    if(chat_text.length <= 0) {
        chat_text = $.trim($('#text').val());
        $("#text").val('');
    }
    $.post("server.php?action=send", {text: chat_text});
}

function add_emoticons(icon_key) {
    chat_text = $('#text').val();
    chat_text = chat_text + ' ' + icon_key + ' ';
    $("#text").val(chat_text);
    $("#text").focus();
}

$(document).keyup(function(e) {
    if(e.which == 13) {
        var text = $.trim($('#text').val());
        if(text.length > 0) {
            send_text(text);
            $("#text").val('');
        }
    }
    
    if(e.which == 27) {
        quit();
    }
});

update_count();
room();
$(document).ready(function() {
    var term = setInterval(function() {
        $.get("server.php?action=status", function( data ) {
            if(data != '1') {
                if($(".sorry").length <= 0) {
                    $("#html").append(data);
                    scroll_down();
                }
                clearInterval(term);
            } else {
                update_count();
                room();
            }
        });
    }, 400);
});