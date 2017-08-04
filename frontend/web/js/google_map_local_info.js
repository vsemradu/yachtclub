var map;
var pins;
var business;
var infowindow;
var weather_action = 0;
var gmarkers = [];
var businessMarkers = [];
function showWeatherControl(controlDiv, map) {

    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.marginLeft = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.className = "weatger_button";
    controlUI.title = 'Click for show weather';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '38px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.className = "js-show-weatger";
    controlText.innerHTML = 'Show weather';
    controlUI.appendChild(controlText);

}

function hideWeatherControl(controlDiv, map) {

    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.marginLeft = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.className = "weatger_button";
    controlUI.title = 'Click for hide weather';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '38px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.className = "js-hide-weatger";
    controlText.innerHTML = 'Hide weather';
    controlUI.appendChild(controlText);



}
function initialize() {
    var mapOptions = {
        zoom: zoom,
        minZoom: 3,
        center: new google.maps.LatLng(lat, lng),
        panControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: true,
        overviewMapControl: true
    };
    map = new google.maps.Map(document.getElementById('js-map-canvas'),
            mapOptions);



    //get waether
    if (weather == 1) {
        addWeather(map);
    }
//get waether
}





function addWeather(map) {
    google.maps.event.addListener(map, "click", function (event) {
        if (weather == 1) {

            $('#loadingmessage').show();
            if (infowindow) {
                infowindow.setMap(null);
            }
            var latitude = event.latLng.lat();
            var longitude = event.latLng.lng();


            $('#loadingmessage').show();
            $.get("/site/weather-info", {lat: latitude, lng: longitude})
                    .done(function (data) {
                        $('.js-weather-block').html(data);

                        $('#loadingmessage').hide();
                        $.scrollTo('.js-weather-block', 500);
                    });
        }
    });

}

function addMarkers() {/*Add pins function*/
    if (pins != '') {
        $.each(pins, function (index, value) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(value.lat, value.lan),
                map: map,
                title: value.title,
                id_pin: value.id,
                icon: '/img/map_icons/' + value.type + '.png',
            });

            /*Information marker mouseover*/
            var infowindowOnMouseOver = new google.maps.InfoWindow({content: value.mouseover_inforamtion});
            google.maps.event.addListener(marker, 'mouseover', function () {
                infowindowOnMouseOver.open(map, this);
            });
            google.maps.event.addListener(marker, 'mouseout', function () {
                infowindowOnMouseOver.close();
            });
            /*Information marker mouseover*/



            /*marker click*/
            google.maps.event.addListener(marker, 'click', function () {
                location.href = "/pin/view?id=" + this.id_pin;
            });

            /*marker click*/
            gmarkers.push(marker);
        });
    }

}
function addBusinessMarkers() {/*Add busines function*/
    if (business != '') {
        $.each(business, function (index, value) {
            var markerBusiness = new google.maps.Marker({
                position: new google.maps.LatLng(value.lat, value.lan),
                map: map,
                title: value.title,
                id_busines: value.id,
                icon: '/img/create_icons/' + value.type + '.png',
            });

            /*Information marker mouseover*/
            var infowindowOnMouseOverBusines = new google.maps.InfoWindow({content: value.mouseover_inforamtion});
            google.maps.event.addListener(markerBusiness, 'mouseover', function () {

                infowindowOnMouseOverBusines.open(map, this);
            });
            google.maps.event.addListener(markerBusiness, 'mouseout', function () {
                infowindowOnMouseOverBusines.close();
            });
            /*Information marker mouseover*/



            /*marker click*/
            google.maps.event.addListener(markerBusiness, 'click', function () {
                location.href = "/busines/view?id=" + this.id_busines;
            });

            /*marker click*/
            businessMarkers.push(markerBusiness);
        });
    }

}

function removeBusinessMarkers() {
    for (i = 0; i < businessMarkers.length; i++) {
        businessMarkers[i].setMap(null);
    }


}
function removeMarkers() {
    for (i = 0; i < gmarkers.length; i++) {
        gmarkers[i].setMap(null);
    }


}
$(document).ready(function () {
    initialize();

    $('#js-cancel-drop-pin').click(function (event) {
        map_click.remove();
        $('.js-right-corner').fadeOut();
        event.preventDefault();
    });
    $('#js-drop-pin').click(function (event) {
//        removeDrawMap();
        if (infowindow) {
            infowindow.setMap(null);
        }
        $('.home-page-map').click();
        $.scrollTo('#js-map-canvas', 500);

        $('.js-right-corner').fadeIn();

        //get coordinate click
        map_click = google.maps.event.addListener(map, "click", function (event) {

            zoomLevel = map.getZoom();
            if (zoomLevel > 11) {


                var latitude = event.latLng.lat();
                var longitude = event.latLng.lng();
                var txt = latitude + ', ' + longitude + ' Are you sure you want to drop the pin here?';
                if (confirm(txt)) {

                    location.href = "/profile/create-pin?lat=" + latitude + '&lan=' + longitude;
                }

            } else {

                alert('Please zoom in to make sure pin coordinates are accurate. Scale must be at least 2 km/1 mile.');
            }
        }); //get coordinate click


        event.preventDefault();
    });
    $('#js-map-canvas').on('click', '.js-hide-weatger', function (event) {
        if (infowindow) {
            infowindow.setMap(null);
        }
        weather_action = 0;
    });

    $('#js-map-canvas').on('click', '.js-show-weatger', function (event) {

        if (infowindow) {
            infowindow.setMap(null);
        }
        weather_action = 1;
    });

});