$(function () {
    var request;
    $('#login-form').submit(function (e) {
        if (request) {
            request.abort();
        }

        var $form = $(this);
        var $inputs = $form.find("input, select, button, textarea");
        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "utils/login.php",
            type: "post",
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);
            if (response.indexOf("Error") === 0) {
                $("#error-message-login").html(response);
            } else {
                window.location.reload();
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

        request.always(function () {
            $inputs.prop("disabled", false);
        });

        e.preventDefault();
    });

    $('#sign-up-form').submit(function (e) {
        if (request) {
            request.abort();
        }

        var $form = $(this);
        var $inputs = $form.find("input, select, button, textarea");
        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "utils/signup.php",
            type: "post",
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);
            if (response.indexOf("Error") === 0) {
                $("#error-message-signup").html(response);
            } else {
                window.location.reload();
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

        request.always(function () {
            $inputs.prop("disabled", false);
        });

        e.preventDefault();
    });

    $('#profile').click(function (ev) {
        $("profile").find(".dropdown-toggle").dropdown("toggle");
    });
});