$(document).ready(function(){
    $("#btn_signup").click(function(){
        window.location = base_url + "login/signup";
    });
    $("#btn_login").click(function(){
        if ($("#name").val() == "") {
            showAlert("Please input your name.");
            return false;
        }
        if ($("#password").val() == ""){
            showAlert("Please input password.");
            return false;
        }
        return true;
    });
    
});