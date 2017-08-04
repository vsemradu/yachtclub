var autocomplete;


function htmlTexttruncate(text) {

    return $.truncate(text, {
        length: 300,
        words: true,
        ellipsis: '...<a class="js-read-more" href="#">Read more</a>'
    });
}

function initializeAutoCompleate() {

    if (document.getElementById('js-google-autocomplete') != undefined) {
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {HTMLInputElement} */(document.getElementById('js-google-autocomplete')),
                {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            autocomplete.getPlace();
        });
    }


    if (document.getElementById('js-google-autocomplete-header') != undefined) {
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {HTMLInputElement} */(document.getElementById('js-google-autocomplete-header')),
                {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            autocomplete.getPlace();
        });
    }

}
function header_search() {
    $('#loadingmessage').show();
    $.post("/site/ajax-search-local-info", {name: $('.js-search').val()})
            .done(function (data) {
                data = jQuery.parseJSON(data);
                $('#loadingmessage').hide();
                $('#js-search-modal .js-content-modal').html(data.value);
                $('#js-search-modal').modal('show');
                return;
            });
}
$(function () {

    $('.js-review-block').on('click', 'a.js-reply-review', function (event) {
        block = $(this).parents('.js-review-block');
        $(block).find('.js-add-reviewReply-block').show(300);
        event.preventDefault();
    });
    $('.js-review-block').on('click', 'button.js-reviewReply-cancel', function (event) {
        block = $(this).parents('.js-review-block');
        $(block).find('.js-add-reviewReply-block').hide(300);
        event.preventDefault();
    });
    $('.js-text-localInfo').on('click', 'a.js-read-more', function (event) {
        block = $(this).parents('.js-text-localInfo');

        $(block).find('.js-little').hide();
        $(block).find('.js-big').show();


        event.preventDefault();
    });
    $('.js-text-localInfo').on('click', 'a.js-read-less', function (event) {
        block = $(this).parents('.js-text-localInfo');

        $(block).find('.js-big').hide();
        $(block).find('.js-little').show();


        event.preventDefault();
    });

    $(document).on('click', ".js-delete-comment-blog", function (event) {
        block = $(this);
        if (confirm("Are you sure you want to delete comment?")) {
            $.get($(block).attr('href')).done(function (data) {
                if (data == 'true') {
                    $(block).parents('.comment').remove();
                    $.pjax.reload({container: "#blog-comments"});
                }
            });
        }
        event.preventDefault();
    });
    $(document).on('click', ".js-delete-review", function (event) {
        block = $(this);

        if (confirm("Are you sure you want to delete review?")) {
            $.get($(block).attr('href')).done(function (data) {
                if (data == 'true') {
                    $(block).parents('.comment').remove();
//                    alert('Review has been deleted');
//                    $.pjax.reload({container: "#js-list-review"});
                    location.reload();
                }
            });
        }


        event.preventDefault();
    });
    $(document).on('click', ".js-delete-reviewReply", function (event) {
        block = $(this);

        if (confirm("Are you sure you want to delete review?")) {
            $.get($(block).attr('href')).done(function (data) {
                if (data == 'true') {
                    $(block).parents('.js-reviewReply-block').remove();
                    location.reload();
                }
            });
        }


        event.preventDefault();
    });


    $('.js-form-search').submit(function (event) {
        header_search();
        event.preventDefault();
    });
    $('.js-search-icon').click(function (event) {
        header_search();
        event.preventDefault();
    });


    $('.js-add-review').click(function (event) {
        $('.js-add-review-block').show();
        event.preventDefault();
    });


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
    $(document).on('click', '.js-vessel-yes', function (event) {
        $('.js-vessel-no').find('a').removeClass('active');
        $(this).find('a').addClass('active');
        $('.js-vessel-block').show(300);

        event.preventDefault();
    });
    $(document).on('click', '.js-vessel-no', function (event) {
        $('.js-vessel-yes').find('a').removeClass('active');
        $(this).find('a').addClass('active');


        $('.js-vessel-block').hide(300);
        $('.js-vessel_name').val('');
        $('.js-vessel_draft').val('');
        $('.js-vessel_lenght').val('');
        $('.js-vessel_beam').val('');
        $('.js-vessel_air_draft').val('');
        $('.js-vessel_sail').val('');
        $('.js-yacht-select').val('');
        event.preventDefault();
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


    $('.home-page-map').click(function (event) {

        $('.home-page-map-overlay').addClass('off');


        $('.map-canvas').removeClass('off');
        if (!$('.map-canvas').hasClass('js-not-click')) {
            document.elementFromPoint(event.clientX, event.clientY).click();
        }

        $('.map-canvas').addClass('js-not-click');
    });

    $('#go-down-home').click(function () {
        destination = jQuery('.feauture-week').offset().top;
        $("body,html").animate({
            scrollTop: destination - 100
        }, 800);
        return false;
    });

    $('#go-down').click(function () {
        destination = $('.local-page_map').height();
        $("body,html").animate({
            scrollTop: destination + 100
        }, 800);
        return false;
    });

    $(".owl-carousel").owlCarousel({
        nav: true,
        items: 1
    });

    if ($('.photo-slider').html != undefined) {
        $(".photo-slider").owlCarousel({
            nav: false,
            items: 1,
            dots: false,
            loop: true
        });
    }



    var owl2 = $('.photo-slider');

    $('.slider-navigation .fa-chevron-right').click(function () {
        owl2.trigger('next.owl.carousel');
    })

    $('.slider-navigation .fa-chevron-left').click(function () {
        owl2.trigger('prev.owl.carousel');
    });

    $(".slider-bus").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    $(".slider-review").owlCarousel({
        loop: false,
        margin: 10,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    });

    // scroll btn 
    $('.js-scroll-users').click(function () {
        destination = jQuery('.js-to-crew').offset().top;
        $("body,html").animate({
            scrollTop: destination - 50
        }, 800);
        return false;
    });
    $('.js-scroll-comments').click(function () {
        destination = jQuery('.js-to-blog').offset().top;
        $("body,html").animate({
            scrollTop: destination - 0
        }, 800);
        return false;
    });
    $('.js-scroll-star').click(function () {
        destination = jQuery('.js-to-reviews').offset().top;
        $("body,html").animate({
            scrollTop: destination - 50
        }, 800);
        return false;
    });

});



// FILE UPLOAD 

$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

$(document).ready(function () {
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log)
                alert(log);
        }

    });

    $(document).on('change', '.js-yacht-select', function (event) {

        $.post("/yacht/ajax-get-yacht", {id: $(this).val()})
                .done(function (data) {
                    if (data != '') {
                        data = JSON.parse(data);
                        $('.js-vessel_name').val(data.name);
                        $('.js-vessel_draft').val(data.draft);
                        $('.js-vessel_lenght').val(data.length);
                        $('.js-vessel_beam').val(data.beam);
                        $('.js-vessel_air_draft').val(data.air_draft);
                        $('.js-vessel_sail').val(data.type_yacht);
                    } else {

                        $('.js-vessel_name').val('');
                        $('.js-vessel_draft').val('');
                        $('.js-vessel_lenght').val('');
                        $('.js-vessel_beam').val('');
                        $('.js-vessel_air_draft').val('');
                        $('.js-vessel_sail').val('');
                    }

                });


        event.preventDefault();
    });
});

$(document).scroll(function () {
    if ($('.fixed-right-sidebar').html() != undefined) {
        if ($('.fixed-right-sidebar').offset().top >= 550) {
            $('.fixed-right-sidebar').show(300);
        } else {
            $('.fixed-right-sidebar').hide(300);
        }
    }
});

// FIXED btn 

$(window).scroll(function () {
    if ($('.right-corner').offset().top >= 171) {
        $('.right-corner').css({
            'top': '15px'
        });
    } else {
        $('.right-corner').css({
            'top': '100px'
        });
    }

});


// yes btn aka checkbox 
$(function () {
    $('.yes-btn').click(function () {
        if ($(this).find('input[name="enable_blog"]').is(':checked')) {
            $(this).find('span').text('Yes');
            $(this).find('input[name="enable_blog"]').prop("checked", true);

        } else {
            $(this).find('input[name="enable_blog"]').prop("checked", false);
            $(this).find('span').text('No');
        }
    });


    $('.js-yes-btn').click(function (event) {
        $('.js-button-yes-no').prop("checked", true);
        $(this).addClass('active');
        $('.js-no-btn').removeClass('active');
        event.preventDefault();
    });
    $('.js-no-btn').click(function (event) {
        $('.js-button-yes-no').prop("checked", false);
        $(this).addClass('active');
        $('.js-yes-btn').removeClass('active');
        event.preventDefault();
    });
});


// block height - yacht page 
$(function () {
    if ($(window).width() >= 992) {
        var whiteBLock = $('.full-screen-img.yaht .full-screen-overlay').outerHeight();
        var mainBlock = $('.full-screen-img.yaht').height();
        if (mainBlock < whiteBLock) {
            $('.full-screen-img.yaht').height(whiteBLock);
        }
    }
});


// butttons active class
$(function () {
    $('.blue-block-btns a').click(function () {
        if ($(this).hasClass('red-btn') || $(this).hasClass('blue-btn')) {
            $('.blue-block-btns a').removeClass('active');
            $(this).addClass('active');
        }
    });
});
