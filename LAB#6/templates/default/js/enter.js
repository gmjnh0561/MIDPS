function update_count() {
    $.get("server.php?action=count", function( data ) {
        $("#count" ).html(data);
    });
}

function chat() {
    $.get("server.php?action=chat", function( data ) {
        if(data.length > 5) {
            window.location.replace("chat.php");
        }
    });
}

update_count()
$(document).ready(function() {
    var term = setInterval(function() {
        update_count();
        chat();
    }, 1000);
});

function search_user() {
    $("#proccess").removeClass('hide');
    $(".page-header").addClass('hide');
    $("#login").addClass('hide');
    $("#description").addClass('hide');
    $.get("server.php?action=search");
}