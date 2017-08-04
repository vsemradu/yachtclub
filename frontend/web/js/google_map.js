var map;
var infowindow;
var weather_action = 0;
var key_wiki_map = '29C7C60E-8CE8C5DC-1B4124C1-7137963F-E7C0F6E9-46390981-D0BF5004-DB934C1';
var status_wiki_map = 1;
var show_pins = 1;
var show_pin_load = 0;
var show_localInfos_load = 0;
var show_localInfos = 1;
var s_show_pin_load = 0;
var s_show_localInfos_load = 0;
var map_click;
var styledMapOnlyCountries;
var styledMapAllLabel;
var styledMapRoad;
var markersArray = [];
var gmarkers = [];
var glocalInfo = [];
var hoverCountryArray = [];
var chicago = new google.maps.LatLng(41.85, -87.65);
var latitude;
var longitude;
var only_country = [
    {
        "featureType": "administrative.province",
        "stylers": [
            {"visibility": "off"}
        ]
    }, {
        "featureType": "administrative.locality",
        "stylers": [
            {"visibility": "off"}
        ]
    }, {
        "featureType": "administrative.neighborhood",
        "stylers": [
            {"visibility": "off"}
        ]
    }, {
        "featureType": "administrative.land_parcel",
        "stylers": [
            {"visibility": "off"}
        ]
    }, {
        "featureType": "poi.attraction",
        "stylers": [
            {"visibility": "off"}
        ]
    }, {
        "featureType": "poi.park",
        "stylers": [
            {"visibility": "off"}
        ]
    },
    {
        "featureType": "road",
        "stylers": [
            {"visibility": "off"}
        ]
    }
];
var all_label = [
    {
        "featureType": "administrative.province",
        "stylers": [
            {"visibility": "on"}
        ]
    }, {
        "featureType": "administrative.locality",
        "stylers": [
            {"visibility": "on"}
        ]
    }, {
        "featureType": "administrative.neighborhood",
        "stylers": [
            {"visibility": "on"}
        ]
    }, {
        "featureType": "administrative.land_parcel",
        "stylers": [
            {"visibility": "on"}
        ]
    }, {
        "featureType": "poi.attraction",
        "stylers": [
            {"visibility": "on"}
        ]
    }, {
        "featureType": "poi.park",
        "stylers": [
            {"visibility": "on"}
        ]
    },
    {
        "featureType": "road",
        "stylers": [
            {"visibility": "off"}
        ]
    }


];
var map_road = [
    {
        "featureType": "road",
        "stylers": [
            {"visibility": "on"}
        ]
    }


];
/**
 * The CenterControl adds a control to the map that recenters the map on Chicago.
 * This constructor takes the control DIV as an argument.
 * @constructor
 */
function hidePinsControl(controlDiv, map) {
    // Set CSS for the control border
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.textAlign = 'center';
    controlUI.className = "weatger_button hidePins";
    controlUI.title = 'Click to hide pins';
    controlDiv.appendChild(controlUI);

    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '38px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'Hide Pins';
    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to
    // Chicago
    google.maps.event.addDomListener(controlUI, 'click', function () {
        removeMarkers(0, 0);
    });
}

function showPinsControl(controlDiv, map) {
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.marginLeft = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Click to show pins';
    controlUI.className = "weatger_button showPins";
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '38px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'Show Pins';
    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to
    // Chicago
    google.maps.event.addDomListener(controlUI, 'click', function () {

        s_show_pin_load = 1;
        addMarkers(map);
    });

}


function showLocalInfoControl(controlDiv, map) {

    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.marginLeft = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.className = "weatger_button showLocalInfo";
    controlUI.title = 'Click to show Local Info';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '38px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'Show Local Info';
    controlUI.appendChild(controlText);
    google.maps.event.addDomListener(controlUI, 'click', function () {
        s_show_localInfos_load = 1;
        addMarkerLocalInfo(map);
    });
}

function hideLocalInfoControl(controlDiv, map) {

    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginBottom = '22px';
    controlUI.style.marginLeft = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.className = "weatger_button hideLocalInfo";
    controlUI.title = 'Click to show Local Info';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '38px';
    controlText.style.paddingLeft = '5px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = 'Hide Local Info';
    controlUI.appendChild(controlText);

    google.maps.event.addDomListener(controlUI, 'click', function () {
        removeLocalInfos(0, 0);
    });

}



function constructNewCoordinatesIslandMap(polygons) {
    var newCoordinates = [];
    $.each(polygons, function (index_polygon, polygon) {
        newCoordinates.push(new google.maps.LatLng(polygon.y, polygon.x));
    });
    return newCoordinates;
}
function constructNewCoordinates(polygon) {
    var newCoordinates = [];
    var coordinates = polygon['coordinates'][0];
    for (var i in coordinates) {
        newCoordinates.push(
                new google.maps.LatLng(coordinates[i][1], coordinates[i][0]));
    }
    return newCoordinates;
}

function initialize() {


    /*STYLE*/
    var styledMapOnlyCountries = new google.maps.StyledMapType(only_country,
            {name: "Only countries"});

    var styledMapAllLabel = new google.maps.StyledMapType(all_label,
            {name: "All label"});
    var styledMapRoad = new google.maps.StyledMapType(map_road,
            {name: "Road"});
    /*STYLE*/


    var mapOptions = {
        zoom: 5,
        minZoom: 3,
        center: new google.maps.LatLng(16.6239309, -78.1868336),
        mapTypeControlOptions: {
            mapTypeIds: ['only_country', 'all_label']
        },
        panControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: true,
        overviewMapControl: true
    };
    map = new google.maps.Map(document.getElementById('js-map-canvas'),
            mapOptions);



    map.mapTypes.set('only_country', styledMapOnlyCountries);
    map.setMapTypeId('only_country');


    /*Event zoom*/
    google.maps.event.addListener(map, 'zoom_changed', function () {
        zoomLevel = map.getZoom();
        if (zoomLevel > 7) {

            /*Add style*/
            map.mapTypes.set('all_label', styledMapAllLabel);
            map.setMapTypeId('all_label');
            /*Add style*/
            /*Add style*/
            map.mapTypes.set('road', styledMapRoad);
            map.setMapTypeId('road');
            /*Add style*/

            removeLocalInfos(show_localInfos, show_localInfos_load);
            removeMarkers(show_pins, show_pin_load);/*Remove pins*/


            if (show_pins == 1) {
                addMarkers(map);/*add pins*/
            }
            if (show_localInfos == 1) {
                addMarkerLocalInfo(map);/*add local info*/
            }
        } else {
            removeLocalInfos(show_localInfos, show_localInfos_load);
            removeMarkers(show_pins, show_pin_load);/*Remove pins*/

            /*Add style*/
            map.mapTypes.set('only_country', styledMapOnlyCountries);
            map.setMapTypeId('only_country');
            /*Add style*/
            if (show_pin_load == 1) {
                addMarkers(map);/*add pins*/
            }
            if (show_localInfos_load == 1) {
                addMarkerLocalInfo(map);/*add local info*/
            }

        }
    });
    /*Event zoom*/



    /*Pins block*/
    var pinsControlDiv = document.createElement('div');
    var pinsControl = new hidePinsControl(pinsControlDiv, map);


    var showPinsControlDiv = document.createElement('div');
    var showPinsControls = new showPinsControl(showPinsControlDiv, map);

    pinsControlDiv.index = 1;
    showPinsControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(pinsControlDiv);
    map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(showPinsControlDiv);
    /*Pins block*/




    /*local-info block*/
    var hideLocalInfoControlDiv = document.createElement('div');
    new hideLocalInfoControl(hideLocalInfoControlDiv, map);


    var showLocalInfoControlDiv = document.createElement('div');
    new showLocalInfoControl(showLocalInfoControlDiv, map);

    hideLocalInfoControlDiv.index = 1;
    showLocalInfoControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(hideLocalInfoControlDiv);
    map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(showLocalInfoControlDiv);
    /*local-info block*/





//    hoverCountry();// hover country

    //get waether
    addWeather(map);
    //get waether

}



function removeMarkers(s_pins, s_show_pin_load) {/*Remove pins function*/
    for (i = 0; i < gmarkers.length; i++) {
        gmarkers[i].setMap(null);
    }
    show_pins = s_pins;
    show_pin_load = s_show_pin_load;

}
function removeLocalInfos(s_localInfos, s_show_localInfo_load) {/*Remove pins function*/
    for (i = 0; i < glocalInfo.length; i++) {
        glocalInfo[i].setMap(null);
    }
    show_localInfos = s_localInfos;
    show_localInfos_load = s_show_localInfo_load;

}

function addWeather(map) {
    google.maps.event.addListener(map, "click", function (event) {
        if (weather_action == 1) {


            $('#loadingmessage').show();
            if (infowindow) {
                infowindow.setMap(null);
            }
            latitude = event.latLng.lat();
            longitude = event.latLng.lng();


            $('#loadingmessage').show();
            $.post("/site/ajax-weather-info", {lat: latitude, lng: longitude})
                    .done(function (data) {

                        infowindow = new google.maps.InfoWindow({
                            content: data,
                            position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()),
                            maxWidth: 1000
                        });
                        infowindow.open(map);
                        $('#loadingmessage').hide();
                    });
        }
    });

}
function addMarkers(map) {/*Add pins function*/
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
    show_pins = 1;
    if (s_show_pin_load == 1) {
        show_pin_load = 1;
    } else {
        show_pin_load = 0;
    }

}
function addMarkerLocalInfo(map) {/*Add localInfos function*/
    if (localInfo != '') {
        $.each(localInfo, function (index, value) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(value.lat, value.lan),
                map: map,
                title: value.title,
                id_localInfo: value.id,
                icon: '/img/map_icons/localInfo.png',
            });
            /*marker click*/
            google.maps.event.addListener(marker, 'click', function () {
                location.href = "/local-info/view?id=" + this.id_localInfo;
            });

            /*marker click*/
            glocalInfo.push(marker);
        });
    }
    show_localInfos = 1;
    if (s_show_localInfos_load == 1) {
        show_localInfos_load = 1;
    } else {
        show_localInfos_load = 0;
    }
}
google.maps.event.addDomListener(window, 'load', initialize);




jQuery(document).ready(function () {


    $('#js-pin-send').click(function (event) {


        latitude = $('#js-pin-modal #js-pin-lat').val().replace(/(<([^>]+)>)/ig, "");
        latitude = $.trim(latitude);
        longitude = $('#js-pin-modal #js-pin-lng').val().replace(/(<([^>]+)>)/ig, "");
        longitude = $.trim(longitude);

        if (latitude == '' || longitude == '') {
            alert('Fill in the fields Latitude and Longitude');
            return;
        }
        var txt = latitude + ', ' + longitude + ' Are you sure you want to drop the pin here?';


        $('#js-alert-pin-modal .js-content-modal').html(txt);
        $('#js-alert-pin-modal').modal('show');
       

        event.preventDefault();
    });
    $('#js-drop-pin').click(function (event) {

        $('#js-pin-modal').modal('hide');
        $('#js-pin-modal').modal('show');
    });
    $('#js-pin-modal #js-pin-find-map').click(function (event) {
//        removeDrawMap();
        $('.map-canvas').addClass('js-not-click');
        $('#js-pin-modal').modal('hide');
        if (infowindow) {
            infowindow.setMap(null);
        }
        weather_action = 0;
        $('.home-page-map').click();
        $.scrollTo('#js-map-canvas', 500);

        $('.js-right-corner').fadeIn();

        //get coordinate click
        map_click = google.maps.event.addListener(map, "click", function (event) {

            zoomLevel = map.getZoom();
            if (zoomLevel > 11) {


                latitude = event.latLng.lat();
                longitude = event.latLng.lng();
                var txt = latitude + ', ' + longitude + ' Are you sure you want to drop the pin here?';



                $('#js-alert-pin-modal .js-content-modal').html(txt);
                $('#js-alert-pin-modal').modal('show');


            } else {

                alert('Please zoom in to make sure pin coordinates are accurate. Scale must be at least 2 km/1 mile.');
            }
        }); //get coordinate click


        event.preventDefault();
    });


    $('#js-alert-pin-modal .js-pin-send').click(function (event) {
        location.href = "/profile/create-pin?lat=" + latitude + '&lan=' + longitude;

    });
    $('#js-cancel-drop-pin').click(function (event) {
//        hoverCountry();
        weather_action = 1;
        map_click.remove();
        $('.js-right-corner').fadeOut();
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

