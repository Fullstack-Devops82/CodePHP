$(document).ready(function () {
    formValidate();
});

function formValidate() {
    $("form").each(function () {
        $(this).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
            }
        });
    });
}

// google map
var map, geocoder, infowindow;
var autocomplete;
var countryRestrict = { 'country': [] };
var MARKER_PATH = 'https://developers.google.com/maps/documentation/javascript/images/marker_green';
var hostnameRegexp = new RegExp('^https?://.+?/');
function initMap() {
    if ($("#autocomplete").length > 0) {
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(
                document.getElementById('autocomplete')), {
                types: ['(cities)'],
                componentRestrictions: countryRestrict
            });
    }

    if (document.getElementById('map') != null) {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 2,
            center: { lat: 15, lng: 0 },
            mapTypeControl: false,
            panControl: false,
            zoomControl: false,
            streetViewControl: false
        });
        geocoder = new google.maps.Geocoder;
        infowindow = new google.maps.InfoWindow;

        // Create the autocomplete object and associate it with the UI input control.
        // Restrict the search to the default country, and to place type "cities".


        autocomplete.addListener('place_changed', onPlaceChanged);
        if ($("#autocomplete").val() != "") {
            geocodeLatLng(geocoder, map, infowindow);
        }
    }
}

function onPlaceChanged() {
    var place = autocomplete.getPlace();
    if (place.geometry) {
        map.panTo(place.geometry.location);
        map.setZoom(15);
        var marker = new google.maps.Marker({
            position: { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() },
            map: map
        });
        infowindow.setContent($("#autocomplete").val());
        infowindow.open(map, marker);
    } else {
        document.getElementById('autocomplete').placeholder = 'Enter a city';
    }
}

function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
        if (markers[i]) {
            markers[i].setMap(null);
        }
    }
    markers = [];
}

// Load the place information into the HTML elements used by the info window.
function buildIWContent(place) {
    document.getElementById('iw-icon').innerHTML = '<img class="hotelIcon" ' +
        'src="' + place.icon + '"/>';
    document.getElementById('iw-url').innerHTML = '<b><a href="' + place.url +
        '">' + place.name + '</a></b>';
    document.getElementById('iw-address').textContent = place.vicinity;

    if (place.formatted_phone_number) {
        document.getElementById('iw-phone-row').style.display = '';
        document.getElementById('iw-phone').textContent =
            place.formatted_phone_number;
    } else {
        document.getElementById('iw-phone-row').style.display = 'none';
    }

    // Assign a five-star rating to the hotel, using a black star ('&#10029;')
    // to indicate the rating the hotel has earned, and a white star ('&#10025;')
    // for the rating points not achieved.
    if (place.rating) {
        var ratingHtml = '';
        for (var i = 0; i < 5; i++) {
            if (place.rating < (i + 0.5)) {
                ratingHtml += '&#10025;';
            } else {
                ratingHtml += '&#10029;';
            }
            document.getElementById('iw-rating-row').style.display = '';
            document.getElementById('iw-rating').innerHTML = ratingHtml;
        }
    } else {
        document.getElementById('iw-rating-row').style.display = 'none';
    }

    // The regexp isolates the first part of the URL (domain plus subdomain)
    // to give a short URL for displaying in the info window.
    if (place.website) {
        var fullUrl = place.website;
        var website = hostnameRegexp.exec(place.website);
        if (website === null) {
            website = 'http://' + place.website + '/';
            fullUrl = website;
        }
        document.getElementById('iw-website-row').style.display = '';
        document.getElementById('iw-website').textContent = website;
    } else {
        document.getElementById('iw-website-row').style.display = 'none';
    }
}

function geocodeLatLng(geocoder, map, infowindow) {
    var url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCew_xAnG6EfMLke0go0fGxU9FA6wFAUrI&address="' + $("#autocomplete").val() + '"&sensor=false';
    // var latlng = {lat: 35.6894875, lng: 139.6917064};
    $.get(url, function (data, status) {
        map.setZoom(11);
        var marker = new google.maps.Marker({
            position: data.results[0].geometry.location,
            map: map
        });
        infowindow.setContent($("#autocomplete").val());
        infowindow.open(map, marker);
    });
}

var alert_html = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
alert_html += '<p>You should check in on some of those fields below.</p>';
alert_html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
alert_html += '    <span aria-hidden="true">&times;</span>';
alert_html += '</button>';
alert_html += '</div>';

function showAlertModal(msg) {
    $("#myAlertModal .modal-body p").html(msg);
    $("#myAlertModal").modal("show");
}

function showAlert(msg) {
    var $container = $(".notification-container");
    var $alert = $(alert_html);
    $alert.find("p").html(msg);
    $container.append($alert);
    var $cur_alert = $alert;
    setTimeout(function () {
        $cur_alert.alert("close");
    }, 3000);
}

function showConfirm(msg, func) {
    $("#myConfirmModal .modal-body p").html(msg);
    $("#myConfirmModal").modal("show");
    $("#myConfirmModal .btn-confirm").unbind("click");
    $("#myConfirmModal .btn-confirm").click(function () {
        $("#myConfirmModal").modal("hide");
        func();
    });
}

function clearForm($form) {
    if ($form) {
        $("input:not([type='checkbox']), select, textarea", $form).each(function () {
            $(this).val("").trigger('change');
        });
        $(".preview img", $(this)).attr("src", "");
    } else {
        $('form').each(function () {
            $("input, select, textarea", $(this)).each(function () {
                $(this).val("").trigger('change');
            });
            $(".preview img", $(this)).attr("src", "");
        });
    }
}
// resize image
function cropImageData() {
    var img = new Image();
    img.onload = function () {
        canvas = $('<canvas/>').appendTo('body');
        var rx = img.width / crop["crop_w"];
        var ry = img.height / crop["crop_h"];

        ctx = canvas.get(0).getContext('2d'),
            cropCoords = {
                topLeft: {
                    x: Math.round(crop["x"] * rx),
                    y: Math.round(crop["y"] * ry)
                },
                bottomRight: {
                    x: Math.round(crop["w"] * rx),
                    y: Math.round(crop["h"] * ry)
                }
            };

        var base64ImageData = "";
        for (var key in crop["output"]) {
            canvas.attr({
                width: crop["output"][key][1],
                height: crop["output"][key][0]
            });
            ctx.drawImage(img, cropCoords.topLeft.x, cropCoords.topLeft.y, cropCoords.bottomRight.x, cropCoords.bottomRight.y, 0, 0, canvas.width(), canvas.height());
            base64ImageData = canvas.get(0).toDataURL();
            $("input[name='" + key + "']").val(base64ImageData);
            if (key == "picture") {
                crop["preview"].find("img").attr("src", base64ImageData);
            }
        }
        canvas.remove();
    }
    img.src = crop["img"];
}

function copyImage($canvas, width, height) {
    $canvas_copy = $('<canvas/>').appendTo('body');
    $canvas_copy.attr({
        width: width,
        height: height
    });
    var ctx = $canvas_copy.get(0).getContext('2d');
    ctx.drawImage($canvas.get(0), 0, 0, $canvas.get(0).width, $canvas.get(0).height, 0, 0, width, height);
    base64ImageData = $canvas_copy.get(0).toDataURL();
    $canvas_copy.remove();
    return base64ImageData;
}


// crop
var crop = {};
function cropImage(preview, output, file, input_name, title_name) {
    height = preview[0];
    width = preview[1];
    crop = {};
    crop["output"] = output;
    crop["container"] = $(file).closest("form");
    crop["preview"] = crop["container"].find(".preview");
    crop["preview"].find("img").attr("src", "");
    crop["preview"].height(0);
    if (input_name) {
        crop["input_name"] = crop["container"].find("label[name='" + input_name + "']");
        crop["input_name"].html("");
    }
    if (title_name) {
        crop["title_name"] = crop["container"].find("input[name='" + title_name + "']");
    }

    $(".preview-pane .preview-container").width(width);
    $(".preview-pane .preview-container").height(height);

    if (file.files.length > 0 && file.files[0].type.startsWith("image")) {
        crop["file_name"] = file.files[0].name;

        var reader = new FileReader();
        reader.onload = function (evt) {
            $("#cropImageModal .picture-container img").attr("src", evt.target.result);
            $("#cropImageModal .preview-container img").attr("src", evt.target.result);
            crop["img"] = evt.target.result;
            $("#cropImageModal").modal("show");
        }
        reader.readAsDataURL(file.files[0]);
    } else {

    }
}
$('#cropImageModal .btn-confirm').click(function () {
    $('#cropImageModal').modal("hide");

    crop["input_name"].html(crop["file_name"]);
    if (crop["title_name"] && crop["title_name"].val() == "") {
        var file_name = crop["file_name"].replace(/\.[^\.]*$/i, "");
        crop["title_name"].val(file_name);
    }
    crop["preview"].html('<img src="' + crop["img"] + '" />');

    cropImageData();

    // var preview_width = crop["preview"].width();
    // var preview_height = preview_width * crop["pre_h"] / crop["pre_w"];
    // crop["preview"].height(preview_height);

    // var rx = preview_width / crop["w"]; // 200 - preview box size
    // var ry = preview_height / crop["h"];

    // crop["preview"].find("img").css({
    //     width: Math.round(rx * crop["crop_w"]) + 'px',
    //     height: Math.round(ry * crop["crop_h"]) + 'px',
    //     marginLeft: '-' + Math.round(rx * crop["x"]) + 'px',
    //     marginTop: '-' + Math.round(ry * crop["y"]) + 'px'
    // });
});

$('#cropImageModal').modal({
    show: false
}).on("shown.bs.modal", function () {
    pwidth = $("#cropImageModal .picture-container").width();
    var ori_width = $("#cropImageModal .picture-container img").width();
    var ori_height = $("#cropImageModal .picture-container img").height();
    if (ori_width => ori_height) {
        $("#cropImageModal .picture-container img").width(pwidth);
        $("#cropImageModal .preview-container img").width(pwidth);
    } else {
        $("#cropImageModal .picture-container img").height(pwidth);
        $("#cropImageModal .preview-container img").height(pwidth);
    }
    $preview = $('.preview-pane'),
        $pcnt = $('.preview-pane .preview-container'),
        $pimg = $('.preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();

    var xstart = 0;
    var ystart = 0;
    var width = $("#cropImageModal .picture-container img").width();
    var height = $("#cropImageModal .picture-container img").height();
    if ((xsize / ysize) > (ori_width / ori_height)) {
        height = width * ysize / xsize;
        ystart = ($("#cropImageModal .picture-container img").height() - height) / 2;
    } else {
        width = height * xsize / ysize;
        xstart = ($("#cropImageModal .picture-container img").width() - width) / 2;
    }
    crop["pre_h"] = $('.preview-pane .preview-container').height();
    crop["pre_w"] = $('.preview-pane .preview-container').width();
    crop["crop_h"] = $("#cropImageModal .picture-container img").height();
    crop["crop_w"] = $("#cropImageModal .picture-container img").width();
    $('#target').Jcrop({
        setSelect: [xstart, ystart, width, height],
        onChange: updateCoords,
        onSelect: updateCoords,
        aspectRatio: xsize / ysize
    });
}).on('hidden.bs.modal', function () {

});

function updateCoords(c) {
    crop["x"] = c.x;
    crop["y"] = c.y;
    crop["w"] = c.w;
    crop["h"] = c.h;
    crop["x2"] = c.x2;
    crop["y2"] = c.y2;


    var rx = crop["pre_w"] / c.w; // 200 - preview box size
    var ry = crop["pre_h"] / c.h;

    $('.preview-pane .preview-container img').css({
        width: Math.round(rx * crop["crop_w"]) + 'px',
        height: Math.round(ry * crop["crop_h"]) + 'px',
        marginLeft: '-' + Math.round(rx * c.x) + 'px',
        marginTop: '-' + Math.round(ry * c.y) + 'px'
    });
};

function preview(file, input_name, title_name) {
    $containerForm = $(file).closest("form");

    var $prevDiv = $containerForm.find(".preview");
    if (input_name) {
        var $file_name = $containerForm.find("label[name='" + input_name + "']");
    }
    if (title_name) {
        var $title = $containerForm.find("input[name='" + title_name + "']");
    }

    if (file.files && file.files[0]) {
        var file_name = file.files[0].name;
        $file_name.html(file_name);
        if ($title && $title.val() == "") {
            file_name = file_name.replace(/\.[^\.]*$/i, "");
            $title.val(file_name);
        }

        if (file.files[0].type.startsWith("image")) {
            var reader = new FileReader();
            reader.onload = function (evt) {
                $prevDiv.html('<img src="' + evt.target.result + '" />');
            }
            reader.readAsDataURL(file.files[0]);
        }
    } else {
        $file_name.html("");
    }
}


function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
        '<span><img src="' + state.element.getAttribute("img") + '" class="img-flag" /> ' + state.text + '</span>'
    );
    return $state;
};