$(function () {
    $("#sm_edit_user").submit(function (event) {
        grecaptcha.execute();
    });

    function onSubmit(token) {
        $('sm_edit_user_captcha').val(token);
    }
});
