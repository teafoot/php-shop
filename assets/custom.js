(function($) {

    "use strict";

    var mainWindow          = $(window),
        mainDocument        = $(document),
        productCarousel     = $('.product-carousel'),
        bxMainSlider        = $('.bxslider'),
        prodSlider          = $('.prod-slider'),
        popup               = $('.popup'),
        bootstrapTouchSlider = $('#bootstrap-touch-slider');

    mainWindow.on('load', function() {
        // Carousel - Product
        productCarousel.owlCarousel({
            loop: true,
            autoplay: true,
            margin: 20,
            animateIn: true,
            responsiveClass: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true
                }
            }
        });
    });

    mainDocument.ready(function(){
        bxMainSlider.bxSlider({
            auto: true,
            autoControls: true,
            useCSS: false,
            pager: false,
            mode: 'fade',
            nextText: '<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>',
            prevText: '<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>'
        });
        prodSlider.bxSlider({
            pagerCustom: '#prod-pager'
        });
        popup.magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            },
        });
        $(".select2").select2();
    });

})(jQuery);