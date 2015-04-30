/**
 * Created by Thomas on 21-12-2014.
 */
$(function () {
    //acknowledgement message
    var message_status = $("#status");
    $("input[contenteditable=true]").blur(function () {
        var field_userid = $(this).attr("id");
        var value = $(this).text();
        $.post('ajax.php', field_userid + "=" + value, function (data) {
            if (data != '') {
                message_status.show();
                message_status.text(data);
                //hide the message
                setTimeout(function () {
                    message_status.hide()
                }, 3000);
            }
        });
    });
});