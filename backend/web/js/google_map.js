var map;

var addressArray = [];
var addressTypeArray = ['country', 'administrative_area_level_1', 'administrative_area_level_2', 'administrative_area_level_3', 'administrative_area_level_4', 'administrative_area_level_5'];


function initialize() {

    var mapOptions = {
        zoom: 5,
        minZoom: 3,
        center: new google.maps.LatLng(16.6239309, -78.1868336),
        panControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: true,
        overviewMapControl: true
    };
    map = new google.maps.Map(document.getElementById('js-map-canvas'),
            mapOptions);



    //get coordinate click
    map_click = google.maps.event.addListener(map, "click", function (event) {



        $('#js-form-block-address')[0].reset()
        $('#js-form-address').hide();

        var latitude = event.latLng.lat();
        var longitude = event.latLng.lng();


        var zoomLevel = map.getZoom();
        var bounds = this.getBounds();
        var ne = bounds.getNorthEast();
        var sw = bounds.getSouthWest();
        $.get("https://maps.googleapis.com/maps/api/geocode/json", {latlng: latitude + ',' + longitude, key: apiGoogleKey})
                .done(function (data) {

                    if (data.status == 'OK') {
                        addressArray = [];
                        $.each(data.results, function (index, value) {
                            $.each(value.types, function (i, v) {
                                if ($.inArray(v, addressTypeArray) >= 0) {
                                    addressArray[index] = value;
                                }
                            });
                        });

                        if (addressArray.length != 0) {
                            $('#js-address-list').find('option').remove();
                            $('#js-address-list').append($("<option></option>").attr("value", '').text('Select location'));
                            $.each(addressArray, function (index, value) {
                                if (value) {
                                    formatted_address = value.formatted_address;
                                    $('#js-address-list').append($("<option></option>").attr("value", index).text(formatted_address));
                                }
                            });





                            $('#js-zoom').val(zoomLevel);
                            $('#js-ne_lat').val(ne.lat());
                            $('#js-sw_lat').val(sw.lat());
                            $('#js-ne_lng').val(ne.lng());
                            $('#js-sw_lng').val(sw.lng());

                            $.get("/backend/local-info/ajax-buissiness", {ne_lat: ne.lat(), sw_lat: sw.lat(), ne_lng: ne.lng(), sw_lng: sw.lng()})
                                    .done(function (data) {
                                        data = jQuery.parseJSON(data);
                                        $('#js-local_life_id').empty();
                                        $('#js-featured_business_id').empty();
                                        if (data.length != 0) {
                                            $.each(data, function (index, value) {
                                                var newOption = $('<option value="' + index + '">' + value + '</option>');
                                                var newOption2 = $('<option value="' + index + '">' + value + '</option>');
                                                $('#js-local_life_id').append(newOption2);
                                                $('#js-featured_business_id').append(newOption);
                                            });
                                        }
                                        $('#js-local_life_id').trigger("chosen:updated");
                                        $('#js-featured_business_id').trigger("chosen:updated");
                                        $('#js-address-modal').modal('show');
                                    });


                        } else {
                            $('#js-address-modal').modal('hide');
                            alert('error');
                        }




                    } else {
                        $('#js-address-modal').modal('hide');
                        alert('error');
                    }
                });





    }); //get coordinate click



    /*Event zoom*/
    google.maps.event.addListener(map, 'zoom_changed', function () {
        zoom_change();
    });
    /*Event zoom*/


    /*Event center changed*/
    google.maps.event.addListener(map, 'center_changed', function () {
        zoom_change();
        var latitude = this.center.lat();
        var longitude = this.center.lng();
        $('#js-lat').val(latitude);
        $('#js-lng').val(longitude);
    });
    /*Event center changed*/

}

function zoom_change() {
    var zoomLevel = map.getZoom();
    var bounds = map.getBounds();
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    $('#js-zoom').val(zoomLevel);
    $('#js-ne_lat').val(ne.lat());
    $('#js-sw_lat').val(sw.lat());
    $('#js-ne_lng').val(ne.lng());
    $('#js-sw_lng').val(sw.lng());
}
jQuery(document).ready(function () {
    initialize();

    $('#js-address-list').change(function () {
        $('#js-address-modal').modal('hide');
        map.setCenter(new google.maps.LatLng(addressArray[$(this).val()].geometry.location.lat, addressArray[$(this).val()].geometry.location.lng));

        $('#js-lat').val(addressArray[$(this).val()].geometry.location.lat);
        $('#js-lng').val(addressArray[$(this).val()].geometry.location.lng);
        $('#js-area_name').val(addressArray[$(this).val()].formatted_address);
        $('#js-form-address').show();
    });

});
