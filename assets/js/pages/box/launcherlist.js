
$(document).ready(function () {
    initTable();
    initGroupData();

    $("#data_table").on("click", "a.action-move", function () {
        var box_id = $(this).attr('box_id');
        clearForm($("#moveGroupModal form"));
        $("#moveGroupModal input[name='box_id']").val(box_id);
        $("#moveGroupModal").modal("show");
    });

    $("#moveGroupModal #btn-submit").click(function () {
        if (!$("#moveGroupModal form").valid()) {
            return false;
        }
        $("#moveGroupModal").modal("hide");
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxMoveToGroup",
            type: "POST",
            data: $("#moveGroupModal form").serializeArray(),
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("Moving is finished.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });

    $("#data_table").on("click", "a.action-delete", function () {
        var box_id = $(this).attr('box_id');
        showConfirm("Do you want to delete Launcher User? (Box Id: " + box_id + ")", function () {
            $(".preloader").fadeIn();
            $.ajax({
                url: base_url + "box/ajaxUserDel",
                type: "POST",
                data: { "box_id": box_id },
                dataType: "json",
                success: function (data) {
                    $(".preloader").fadeOut();
                    if (data.msg == "success") {
                        showAlert("User is deleted.");
                        initTable();
                    } else {
                        showAlert(data.msg);
                    }
                }
            });
        });
    });

    $("#data_table").on("click", "a.action-active", function () {
        var box_id = $(this).attr('box_id');
        // showConfirm("Do you want to active Launcher User? (Box Id: " + box_id + ")", function () {
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxUserActive",
            type: "POST",
            data: { "box_id": box_id },
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("User is actived.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
        // });
    });

    $("#data_table").on("click", "a.action-block", function () {
        var box_id = $(this).attr('box_id');
        // showConfirm("Do you want to block Launcher User? (Box Id: " + box_id + ")", function () {
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxUserBlock",
            type: "POST",
            data: { "box_id": box_id },
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("User is blocked.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
        // });
    });
    //
    $(".add-single #btn_add").click(function () {
        var box_id = $(".add-single #box_id").val();
        if (box_id == "") {
            return false;
        }
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxAddSingle",
            type: "POST",
            data: { "box_id": box_id },
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert(box_id + " is added.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });
    // multi action
    $(".action-multi #action_sel").select2({});
    $(".action-multi #action_sel").change(function () {
        var action_str = $(this).val();
        if (action_str == "action-move") {
            $(".action-multi .group-to").each(function () {
                $(this).show();
            });
        } else {
            $(".action-multi .group-to").each(function () {
                $(this).hide();
            });
        }
    });
    $(".action-multi #btn_action").click(function () {
        var from_group_id = $(".action-multi select#group_from").val();
        var to_group_id = $(".action-multi select#group_to").val();
        var action_str = $(".action-multi select#action_sel").val();
        var alert_str = "";
        if (action_str == "action-move") {
            if (from_group_id == to_group_id) {
                return false;
            }
            alert_str = "Do you want to move users from " + group_data[from_group_id] + " to " + group_data[to_group_id] + "?";
        } else if (action_str == "action-active") {
            alert_str = "Do you want to active users of " + group_data[from_group_id] + "?";
        } else if (action_str == "action-block") {
            alert_str = "Do you want to block users of " + group_data[from_group_id] + "?";
        } else if (action_str == "action-delete") {
            alert_str = "Do you want to delete users of " + group_data[from_group_id] + "?";
        }
        showConfirm(alert_str, function () {
            $(".preloader").fadeIn();
            $.ajax({
                url: base_url + "box/ajaxMultiAction",
                type: "POST",
                data: {
                    "from_group_id": from_group_id,
                    "to_group_id": to_group_id,
                    "action_str": action_str
                },
                dataType: "json",
                success: function (data) {
                    $(".preloader").fadeOut();
                    if (data.msg == "success") {
                        showAlert("Action is finished");
                        initTable();
                    } else {
                        showAlert(data.msg);
                    }
                }
            });
        });
    });
});

var group_data = {};
function initGroupData() {
    $.ajax({
        url: base_url + "admin/ajaxGetGroups",
        dataType: "json",
        success: function (data) {
            data = data.data;

            var option_html = "";
            for (i = 0; i < data.length; i++) {
                option_html += "<option img='" + data[i]["picture_path"] + "' value='" + data[i]["id"] + "'>" + data[i]["name"] + "</option>"
                group_data[data[i]["id"]] = data[i]["name"];
            }
            $("select.group").each(function () {
                $(this).html(option_html);
                $(this).select2({
                    templateResult: formatState
                });
            });
        }
    });
}

var tb_boxlist
function initTable() {
    if (tb_boxlist != undefined) {
        tb_boxlist.destroy();
    }
    tb_boxlist = $('#data_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $.fn.dataTable.pipeline({
            url: base_url + "box/ajaxGetBoxPageData",
            pages: 7 // number of pages to cache,
        }),
        "autoWidth": false,
        responsive: true
    });
}

//
// Pipelining function for DataTables. To be used to the `ajax` option of DataTables
//
$.fn.dataTable.pipeline = function (opts) {
    // Configuration options
    var conf = $.extend({
        pages: 5,     // number of pages to cache
        url: '',      // script url
        data: null,   // function or object with parameters to send to the server
        // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts);

    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;

    return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;

        if (settings.clearCache) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
            JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
            JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }

        // Store the request for checking next time around
        cacheLastRequest = $.extend(true, {}, request);

        if (ajax) {
            // Need data from the server
            if (requestStart < cacheLower) {
                requestStart = requestStart - (requestLength * (conf.pages - 1));

                if (requestStart < 0) {
                    requestStart = 0;
                }
            }

            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);

            request.start = requestStart;
            request.length = requestLength * conf.pages;

            // Provide the same `data` options as DataTables.
            if (typeof conf.data === 'function') {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data(request);
                if (d) {
                    $.extend(request, d);
                }
            }
            else if ($.isPlainObject(conf.data)) {
                // As an object, the data given extends the default
                $.extend(request, conf.data);
            }

            settings.jqXHR = $.ajax({
                "type": conf.method,
                "url": conf.url,
                "data": request,
                "dataType": "json",
                "cache": false,
                "success": function (json) {
                    cacheLastJson = $.extend(true, {}, json);

                    if (cacheLower != drawStart) {
                        json.data.splice(0, drawStart - cacheLower);
                    }
                    if (requestLength >= -1) {
                        json.data.splice(requestLength, json.data.length);
                    }

                    drawCallback(json);
                }
            });
        }
        else {
            json = $.extend(true, {}, cacheLastJson);
            json.draw = request.draw; // Update the echo for each response
            json.data.splice(0, requestStart - cacheLower);
            json.data.splice(requestLength, json.data.length);

            drawCallback(json);
        }
    }
};

// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register('clearPipeline()', function () {
    return this.iterator('table', function (settings) {
        settings.clearCache = true;
    });
});
