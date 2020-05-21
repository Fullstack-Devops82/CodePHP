
$(document).ready(function () {
    profile = new Profile();
    profile.init();
});

function Profile() {
    main = this;
    main.user_data = {};

    main.init = function () {
        main.initBody();
        main.initParam();
        main.initEnv();
    };
    main.initBody = function () {
        var user_id = $(".user-info").attr("user_id");
        $.ajax({
            url: base_url + "user/ajaxgetUserInfo",
            type: "POST",
            dataType: "json",
            data: { user_id: user_id },
            success: function (data) {
                if (data.msg == "success") {
                    var user_data = data.user_data;
                    main.user_data = user_data;
                    $(".user-info .picture").html("<img src='" + user_data.picture_path + "'/>");
                    $(".user-info .name").html("<h3>" + user_data.name + "</h3>");
                    $(".user-info .email").html("<h4>" + user_data.email + "</h4>");
                    $(".user-info .city").html("<h4>" + user_data.city + "</h4>");
                    $(".user-info .status").html("<h4>" + user_data.status_str + "</h4>");

                } else {
                    showAlertModal(data.msg);
                }
            }
        });
    };
    main.resetFormData = function () {
        var user_data = main.user_data;
        $("#updateUserForm .preview img").attr("src", user_data.picture_path);
        $("#updateUserForm input[name='user_id']").val(user_data.id).trigger("change");
        $("#updateUserForm input[name='email']").val(user_data.email).trigger("change");
        $("#updateUserForm input[name='city']").val(user_data.city).trigger("change");
        $("#updatePasswordForm input[name='user_id']").val(user_data.id).trigger("change");
    }
    main.initParam = function () {
        main.updateUserForm = $("#updateUserForm");
        main.updatePasswodForm = $("#updatePasswordForm");
        main.updateUserForm.validate({
            errorPlacement: function errorPlacement(error, element) { element.after(error); },
            rules: {

            }
        });
        main.updatePasswodForm.validate({
            errorPlacement: function errorPlacement(error, element) { element.after(error); },
            rules: {
                // new_password: { notEqualTo: "#pre_password" }
            }
        });
    };
    main.initEnv = function () {
        main.initModal();

    };
    main.initModal = function () {
        // clear modal
        $("#updateUserModal, #updatePasswordModal").each(function () {
            $(this).modal({
                show: false
            }).on("shown.bs.modal", function () {
                main.resetFormData();
                $citys = $(this).find(".automap");
                if ($citys.length > 0) {
                    for (i = 0; i < $citys.length; i++) {
                        new google.maps.places.Autocomplete(
                            /** @type {!HTMLInputElement} */(
                                $citys[i]), {
                                types: ['(cities)'],
                                componentRestrictions: countryRestrict
                            });
                    }
                }
            }).on('hidden.bs.modal', function () {
                clearForm();
            });
        });
        $("#updateUserModal .btn-action").click(function () {
            $form = $("#updateUserModal form");
            if (false == $form.valid()) {
                return false;
            }
            $(".preloader").fadeIn();
            $.ajax({
                url: base_url + "user/ajaxUpdateUser",
                type: "POST",
                data: $form.serializeArray(),
                dataType: "json",
                success: function (data) {
                    $(".preloader").fadeOut();
                    main.initBody();
                    if (data.msg == "success") {
                        $("#updateUserModal").modal("hide");
                        showAlert("User info is updated.");
                    } else {
                        showAlert(data.msg);
                    }
                }
            });
        });
        $("#updatePasswordModal .btn-action").click(function () {
            $form = $("#updatePasswordModal form");
            if (false == $form.valid()) {
                return false;
            }
            $(".preloader").fadeIn();
            $.ajax({
                url: base_url + "user/ajaxUpdatePassword",
                type: "POST",
                data: $form.serializeArray(),
                dataType: "json",
                success: function (data) {
                    $(".preloader").fadeOut();
                    main.initBody();
                    if (data.msg == "success") {
                        $("#updatePasswordModal").modal("hide");
                        showAlertModal("Password is updated.");
                    } else {
                        showAlertModal(data.msg);
                    }
                }
            });
        });
    }


}