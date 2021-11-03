(function($) {
    "use strict";
    $('.navbar-nav>li>a').on('click', function() {
        $('.navbar-collapse').collapse('hide');
    });

    // Windows load

    $(window).on("load", function() {

        // Site loader 

        $(".loader-inner").fadeOut();
        $(".loader").delay(200).fadeOut("slow");

    });


    // Back-top

    $(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.scroll-to-top').addClass('active');
            } else {
                $('.scroll-to-top').removeClass('active');
            }
        });
    });


    // Scroll to

    $('a.scroll').smoothScroll({
        speed: 800,
        offset: -71
    });


    //Popup video

    $('.popup-youtube, .popup-vimeo').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });



    // Jarallax setup


    jarallax(document.querySelectorAll('.jarallax'), {
        speed: 0.5,
        disableParallax: /iPad|iPhone|iPod|Android/,
        disableVideo: /iPad|iPhone|iPod|Android/
    });


})(jQuery);