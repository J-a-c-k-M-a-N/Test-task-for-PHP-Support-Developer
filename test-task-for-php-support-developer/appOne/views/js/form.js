$("#send").on("click", function() {
    let name = $.trim($("#user_name").val());
    let email = $("#email").val();
    let bDay = $("#b_day").val();
    let message = $.trim($("#message").val());

    const MIN_LENGTH_NAME = 2;
    const MIN_LENGTH_EMAIL = 4;
    const MIN_LENGTH_MESSAGE = 2;
    const STANDARD_DATE_VALUE_IN_INPUT = "1895-07-22";

    if (name.length < MIN_LENGTH_NAME) {
        $("#errorMess").text("Enter you name");
    } else if(email.length < MIN_LENGTH_EMAIL) {
        $("#errorMess").text("Enter your email address");
        return false;
    } else if(bDay === STANDARD_DATE_VALUE_IN_INPUT) {
        $("#errorMess").text("Select a date of you B-Day");
        return false;
    } else if(message.length < MIN_LENGTH_MESSAGE) {
        $("#errorMess").text("Message should be at least 2 characters in length");
        return false;
    } else {
        $("#errorMess").text("");
    }
    $.ajax({
        url: '../index.php',
        type: 'POST',
        cache: false,
        data:  { json: JSON.stringify({'name': name, 'email': email, 'bDay': bDay, 'message': message}) },
        dataType: 'json',
        success: function(data) {
            $("#errorMess").text("");

            if($.isArray(data)) {
                return $("#errorMess").text(data[0]);
            } else if (data) {
                $("#data-form").trigger("reset");

                let str = JSON.stringify(data, null, 4);
                $("#errorMess").text(str);
            }
            setTimeout(
                function() {
                    $("#errorMess").text("");
                }, 8000);
        },
    });
});