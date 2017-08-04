var autocomplete;
function initializeAutoCompleate() {
    autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('js-google-autocomplete')),
            {types: ['geocode']});
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        autocomplete.getPlace();
    });
}

$(function () {
    $('.open-menu').click(function () {
        $('nav.head-menu .left-collapse').toggle(300);
    });

    $('.page-preview-pins > li').click(function () {
        $('.pins-dropdown')
        $(this).find('.pins-dropdown').toggle(300);
    });

    $('.head-dropdown').click(function () {
        $('.head-drop-down-open').toggle(300);
    });
    $('.js-modal-reg-button').click(function (event) {
        event.preventDefault();
        $('#registrationModal').modal('hide');
        $('#loginModal').modal('show');
    });

    $('.js-modal-login-button').click(function (event) {
        event.preventDefault();
        $('#loginModal').modal('hide');
        $('#registrationModal').modal('show');
    });


    $('.js-profile-delete').click(function (event) {
        event.preventDefault();
        $.post('/profile/ajax-delete-profile-photo')
                .done(function (data) {
                    window.location.replace("/profile/edit");
                });
    });


    $('.js-send-weather').click(function () {
        $.post("/site/ajax-weather", {name: $('.js-weather-search #js-google-autocomplete').val()})
                .done(function (data) {
                    $('.js-container-weather').replaceWith(data);
                });
    });
    
    
    $('.home-page-map').click(function(){
        
        $('.map-canvas').removeClass('off');
        $('.home-page-map-overlay').addClass('off');
        
    });
    
    $('.go-down-btn').click(function(){
	destination = jQuery('.feauture-week').offset().top;
			$("body,html").animate({
				scrollTop:destination-100
			}, 800);
			return false;
    });
    
    $(".owl-carousel").owlCarousel({
        nav:true,
        items: 1
    });
    
    $(".photo-slider").owlCarousel({
        nav:false,
        items: 1,
        dots: false
    });
    
    var owl2 = $('.photo-slider');
    
    $('.slider-navigation .fa-chevron-right').click(function() {
        owl2.trigger('next.owl.carousel');
    })
    
    $('.slider-navigation .fa-chevron-left').click(function() {
        owl2.trigger('prev.owl.carousel');
    })
});


// FILE UPLOAD 

$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });
    

});