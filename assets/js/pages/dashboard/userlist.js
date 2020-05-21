
// form validate
var addform, updateform;

$(document).ready(function () {
    addform = $("#addUserForm");
    addform.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
        }
    });
    updateform = $("#updateUserForm");
    updateform.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
        }
    });

    initTable();

    $('#btn-add').click(function () {
        $('#addUserModal').modal('show');
    });

    $("#data_table").on("click", "a.action-update", function () {
        var user_id = $(this).attr('user_id');
        // var user_name = $("#data_table tr[user_id='" + user_id + "'] td.user_name").html();
        $.ajax({
            url: base_url + "admin/ajaxGetUserdata",
            type: "POST",
            data: { user_id: user_id },
            dataType: "json",
            success: function (data) {
                $('#updateUserModal form input[name="name"]').val(data[0]['name']).trigger("change");
                $('#updateUserModal form input[name="userid"]').val(data[0]['userid']).trigger("change");
                $('#updateUserModal form select[name="sex"]').val(data[0]['sex']).trigger("change");
                $('#updateUserModal form input[name="birthday"]').val(data[0]['birthday']).trigger("change");
                $('#updateUserModal form input[name="age"]').val(data[0]['age']).trigger("change");
                $('#updateUserModal form input[name="password"]').val(data[0]['password']).trigger("change");
                $('#updateUserModal').modal('show');
            }
        });
    });

    $("#data_table").on("click", "a.action-delete", function () {
        var user_id = $(this).attr('user_id');
        var user_name = $("#data_table tr[user_id='" + user_id + "'] td.user_name").html();
        showConfirm("Do you want to delete " + user_name + "?", function () {
            $(".preloader").fadeIn();
            $.ajax({
                url: base_url + "admin/ajaxUserDel",
                type: "POST",
                data: { "user_id": user_id },
                dataType: "json",
                success: function (data) {
                    $(".preloader").fadeOut();
                    if (data.msg == "success") {
                        showAlert("user is deleted.");
                        initTable();
                    } else {
                        showAlert(data.msg);
                    }
                }
            });
        });
    });

    $('#data_table tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $("#btn-update-submit").click(function () {
        if (!updateform.valid()) {
            return false;
        }
        $('#updateUserModal').modal("hide");
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "admin/ajaxUserUpdate",
            type: "POST",
            data: $("#updateUserForm").serializeArray(),
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("User is updated.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });

    $("#btn-add-submit").click(function () {
        if (!addform.valid()) {
            return false;
        }
        $('#addUserModal').modal("hide");
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "admin/ajaxUserAdd",
            type: "POST",
            data: $("#addUserForm").serializeArray(),
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("User is added.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });

    $('#addUserModal').modal({
        show: false
    }).on("shown.bs.modal", function () {

    }).on('hidden.bs.modal', function () {
        clearForm();
    });

    $('#updateUserModal').modal({
        show: false
    }).on("shown.bs.modal", function () {

    }).on('hidden.bs.modal', function () {
        clearForm();
    });
});

var tb_userlist
function initTable() {
    if (tb_userlist != undefined) {
        tb_userlist.destroy();
    }
    tr_html = "";
    $.ajax({
        url: base_url + "admin/ajaxGetUserdata",
        dataType: "json",
        success: function (data) {
            data.forEach(rowData => {
                sexstr = (rowData['sex'] === '1') ? 'Male' : 'Female';
                tr_html += "<tr user_id='" + rowData['id'] + "'>";
                tr_html += "<td></td>"
                tr_html += "<td class='user_name'>" + rowData['name'] + "</td>"
                tr_html += "<td>" + rowData['userid'] + "</td>"
                tr_html += "<td>" + sexstr + "</td>"
                tr_html += "<td>" + rowData['birthday'] + "</td>"
                tr_html += "<td>" + rowData['age'] + "</td>"
                tr_html += '<td>';
                tr_html += '<a href="#" class="action-update" user_id="' + rowData['id'] + '" data-toggle="tooltip" data-placement="top" title="Update">';
                tr_html += '    <i class="mdi mdi-pencil"></i>';
                tr_html += '</a>';
                tr_html += '<a href="#" class="action-delete" user_id="' + rowData['id'] + '" data-toggle="tooltip" data-placement="top" title="Delete">';
                tr_html += '    </i><i class="mdi mdi-delete"></i>';
                tr_html += '</a> ';
                tr_html += '</td>';
                tr_html += "</tr>"
            });
            $("#data_table tbody").html(tr_html);
            tb_userlist = $('#data_table').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                // "order": [[1, 'asc']],
                // select: 'single',
                "autoWidth": false,
                responsive: true
            });
            tb_userlist.on('order.dt search.dt', function () {
                tb_userlist.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();


        }
    });
}
