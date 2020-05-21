$(document).ready(function () {
    initTable();

    jQuery('.datepicker-autoclose').each(function () {
        $(this).datepicker({
            format: 'dd/mm/yyyy', 
            autoclose: true,
            todayHighlight: true
        });
    });
    
    // edit note
    $("#data_table").on("click", "a.action-note", function () {
        var box_id = $(this).attr('box_id');
        clearForm($("#editNoteModal form"));
        $("#editNoteModal input[name='box_id']").val(box_id);
        $("#editNoteModal").modal("show");
    });

    $("#editNoteModal #btn-submit").click(function () {
        $("#editNoteModal").modal("hide");
        if (!$("#editNoteModal form").valid()) {
            return false;
        }
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxSaveNote",
            type: "POST",
            data: $("#editNoteModal form").serializeArray(),
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("Note is updated.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });
    // update stock box info
    $("#data_table").on("click", "a.action-edit", function () {
        var box_id = $(this).attr('box_id');
        clearForm($("#updateStockModal form"));
        $.ajax({
            url: base_url + "box/ajaxGetStockdata",
            type: "POST",
            data: { "box_id": box_id },
            dataType: "json",
            success: function (data) {
                if (data.msg == "success") {
                    var stock_data = data.data;
                    $("#updateStockModal input[name='box_id']").val(stock_data[0]['box_id']);
                    $("#updateStockModal input[name='sn']").val(stock_data[0]['sn']);
                    $("#updateStockModal input[name='model']").val(stock_data[0]['model']);
                    $("#updateStockModal input[name='batch']").val(stock_data[0]['batch']);
                    $("#updateStockModal input[name='carton']").val(stock_data[0]['carton']);
                    $("#updateStockModal input[name='dealer_id']").val(stock_data[0]['dealer_id']);
                    $("#updateStockModal input[name='note']").val(stock_data[0]['note']);
                    $("#updateStockModal input[name='register_date']").val(stock_data[0]['register_date']);
                    $("#updateStockModal input[name='expiry_date']").val(stock_data[0]['expiry_date']);
                    $("#updateStockModal input[name='package']").val(stock_data[0]['package']);
                    $("#updateStockModal input[name='client_name']").val(stock_data[0]['client_name']);
                    $("#updateStockModal input[name='telephone']").val(stock_data[0]['telephone']);
                    $("#updateStockModal input[name='email']").val(stock_data[0]['email']);
                    $("#updateStockModal input[name='address']").val(stock_data[0]['address']);
                    $("#updateStockModal input[name='city']").val(stock_data[0]['city']);
                    $("#updateStockModal input[name='zip']").val(stock_data[0]['zip']);
                    $("#updateStockModal input[name='state']").val(stock_data[0]['state']);
                    $("#updateStockModal input[name='country']").val(stock_data[0]['country']);
                    $("#updateStockModal input[name='region']").val(stock_data[0]['region']);
                    $("#updateStockModal input[name='expired']").val();
                    $("#updateStockModal input[name='register_ip']").val(stock_data[0]['register_ip']);
                    $("#updateStockModal input[name='livetvapk_ver']").val(stock_data[0]['livetvapk_ver']);
                    var isChecked = stock_data[0]['expired'];
                    if (isChecked == 0) {
                        $("#updateStockModal input[name='expired']").prop('checked', false);
                    } else {
                        $("#updateStockModal input[name='expired']").prop('checked', true)
                    }
                    $("#updateStockModal").modal("show");
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });

    $("#updateStockModal #btn-submit").click(function () {
        if (!$("#updateStockModal form").valid()) {
            return false;
        }
        $("#updateStockModal").modal("hide");
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxUpdateStock",
            type: "POST",
            data: $("#updateStockModal form").serializeArray(),
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("Stock is updated.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });
    // delect stock.
    $("#data_table").on("click", "a.action-delete", function () {
        var box_id = $(this).attr('box_id');
        showConfirm("Do you want to delete Stock box? (Box Id: " + box_id + ")", function () {
            $(".preloader").fadeIn();
            $.ajax({
                url: base_url + "box/ajaxStockDel",
                type: "POST",
                data: { "box_id": box_id },
                dataType: "json",
                success: function (data) {
                    $(".preloader").fadeOut();
                    if (data.msg == "success") {
                        showAlert("Stock box is deleted.");
                        initTable();
                    } else {
                        showAlert(data.msg);
                    }
                }
            });
        });
    });
    // add stock
    $(".btn-container #btn_add").click(function () {
        clearForm($("#addStockModal form"));
        $("#addStockModal").modal("show");
    });
    $("#addStockModal #btn-submit").click(function () {
        if (!$("#addStockModal form").valid()) {
            return false;
        }
        $("#addStockModal").modal("hide");
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxAddStock",
            type: "POST",
            data: $("#addStockModal form").serializeArray(),
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    showAlert("Stock is added.");
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });
    // add stock by csv
    $(".btn-container #btn_csv").click(function () {
        clearForm($("#csvStockModal form"));
        $("#csvStockModal").modal("show");
    });
    $("#csvStockModal #btn-submit").click(function () {
        if (!$("#csvStockModal form").valid()) {
            return false;
        }
        if ($("#csvStockModal input[type='file']")[0].files.length == 0) {
            showAlertModal("please choose csv file.");
            return false;
        }
        var formData = new FormData();
        formData.append("csv_file", $("#csvStockModal input[type='file']")[0].files[0]);

        $("#csvStockModal").modal("hide");
        $(".preloader").fadeIn();
        $.ajax({
            url: base_url + "box/ajaxCsvStock",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                $(".preloader").fadeOut();
                if (data.msg == "success") {
                    var count = data['cnt_data'];
                    var msg = "Total: " + count["total"] + "\n";
                    msg += "Success: " + count['success'] + "\n";
                    msg += "Fail: " + count['fail'] + "\n";
                    msg += "Duplicate Box Id: " + count['dupl_box'] + "\n";
                    msg += "Duplicate SN: " + count['dupl_sn'] + "\n";
                    showAlertModal(msg);
                    initTable();
                } else {
                    showAlert(data.msg);
                }
            }
        });
    });
});

var tb_boxlist
function initTable() {
    if (tb_boxlist != undefined) {
        tb_boxlist.destroy();
    }
    tb_boxlist = $('#data_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": $.fn.dataTable.pipeline({
            url: base_url + "box/ajaxGetStockPagedata",
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
