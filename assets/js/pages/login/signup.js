$(document).ready(function () {
    $("#btn_login").click(function () {
        window.location = base_url + "login";
    });
    $("#btn_signup").click(function () {
        if ($("#name").val() == "") {
            showAlert("Please input your name.");
            return false;
        }
        if ($("#email").val() == "") {
            showAlert("Please input your email address.");
            return false;
        }
        if (!validateEmail($("#email").val())) {
            showAlert("Please input your email address correctly.");
            $("#email").val("");
            $("#email").focus();
            return false;
        }
        if ($("#password").val() == "") {
            showAlert("Please input password.");
            return false;
        }
        if ($("#confirm").val() == "") {
            showAlert("Please input confirm password.");
            return false;
        }
        if ($("#confirm").val() != $("#password").val()) {
            showAlert("Confirm password is not the same as the password.");
            $("#confirm").val("");
            $("#confirm").focus();
            return false;
        }
        return true;
    });
});
// var form = $("#signupform");
// form.validate({
//     errorPlacement: function errorPlacement(error, element) { element.before(error); },
//     rules: {
//         confirm: {
//             equalTo: "#password"
//         }
//     }
// });