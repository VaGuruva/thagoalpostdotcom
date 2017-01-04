(function (root, $, undefined) {
    "use strict";

    $(function () {
        // Featured News Items
        $("#tt-featured-news").owlCarousel({
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
            // Autoplay
            autoPlay: 5000, //Set AutoPlay to 3 seconds
            stopOnHover: true,
            // Navigation
            navigation: true, // Show next and prev buttons
            navigationText: ["<i class=\"fa fa-chevron-left\"></i>", "<i class=\"fa fa-chevron-right\"></i>"],
            rewindNav: true,
            scrollPerPage: false,
            // Pagination
            pagination: true,
            paginationNumbers: false
        });

    });

    // Slider - Mobile
    if (Modernizr.mq('only screen and (max-width: 767px)')) {
        jQuery(document).ready(function() {
            $('.bxslider').bxSlider({
                touchEnabled: true,
                auto: true
            });
        });
    }

    // Hide All Home Menu Items on Desktop
    if (Modernizr.mq('only screen and (min-width: 1200px)')) {
        $('li.mega-menu-item > a:contains("Home")').parent().attr('style', 'display: none !important');
    }

    // Insert Arrow div to Show More button
    var show_more_arrow = '<div class="latest-news-button-arrow"></div>';

    $('.alm-btn-wrap').append(show_more_arrow);

    // Remove Show More button if no Latest News listed
    if ($('li.articleList__item').length < 5) {
        $('.alm-btn-wrap').hide();
    }

    // Tennis Weather Widget
    // Docs at http://simpleweatherjs.com
    $(document).ready(function() {
        $.simpleWeather({
            woeid: '615702',
            unit: 'c',
            success: function(weather) {
                var html = '<h2><img src="'+weather.image+'">'+weather.temp+'&deg;'+weather.units.temp+'</h2>';
                html += '<ul><li>'+weather.city+', '+weather.region+'</li>';
                html += '<li class="currently">&nbsp;&nbsp;|&nbsp;&nbsp;'+weather.currently+'</li></ul>';

                $("#weather").html(html);
            },
            error: function(error) {
                $("#weather").html('<p>'+error+'</p>');
            }
        });       
    });

    // Mobile Subnav
    $(document).ready(function(){

        $('.siteContainer__cat-subnav').slicknav({
            label: '',
            duration: 100
        });

        // Remove leagues-sub class on mobile
        if (Modernizr.mq('only screen and (max-width: 991px)')) {
            $('li.leagues-sub').removeClass('leagues-sub').addClass('mobile-leagues-sub');
            $('div.subnav--heading').prependTo('div.slicknav_menu');
            $('div.siteContainer__inner').css({"marginTop":"128px"});
        }

        // Facebook Comments on Live Commentary Blog
        $('.commentary-comment-share > .comment-item').on('click', function () {
            $('.share-container').slideUp(100);
            $(this).children('div.facebook-container').slideToggle(100);
        });

        // Share on Live Commentary Blog
        $('.commentary-comment-share > .share-item').on('click', function () {
            $('.facebook-container').slideUp(100);
            $(this).children('div.share-container').slideToggle(100);
        });

        // Gallery on Live Commentary Blog
        $('#imageGallery').lightSlider({
            gallery:true,
            item:1,
            autoWidth: true,
            thumbItem:5,
            slideMargin: 0,
            speed:500,
            auto:true,
            loop:true,
            responsive : [],
            onSliderLoad: function() {
                $('#imageGallery').removeClass('cS-hidden');
            }
        });

        // Window Resizing - Timeout
        var resizeTimer;

        $(window).on('resize', function(e) {

            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {

                // Remove leagues-sub class on mobile
                if (Modernizr.mq('only screen and (max-width: 991px)')) {
                    $('li.leagues-sub').removeClass('leagues-sub').addClass('mobile-leagues-sub');
                    $('div.subnav--heading').prependTo('div.slicknav_menu');
                }

                // Add leagues-sub class back when window resizes to min-widt: 992px
                if (Modernizr.mq('only screen and (min-width: 992px)')) {
                    $('li.mobile-leagues-sub').addClass('leagues-sub').removeClass('mobile-leagues-sub');
                    $('div.subnav--heading').prependTo('div.siteContainer__subnav');
                }

//                // Slider - Mobile
//                if (Modernizr.mq('only screen and (max-width: 767px)')) {
//                    $('.bxslider').bxSlider({
//                        touchEnabled: true,
//                        auto: true
//                    });
//                }

            }, 250);
        });

        // :: Localization menu
        // ---------------------------------------------------------
        $('.dropdown-toggle').dropdown();

        // jQuery brute styles
        $(".siteContainer__nav-wrapper").css("z-index", "10");

    });

    $( '#edition-int' ).click(function(e) {
        $.cookie('mu_edition', 'EN', {domain: '.foxsportsasia.com', path: '/', expires: 365});
        $.removeCookie('mu_edition', {domain: 'www.foxsportsasia.com', path: '/'});
    });
    $( '#edition-tw' ).click(function(e) {
        $.cookie('mu_edition', 'TW', {domain: '.foxsportsasia.com', path: '/', expires: 365});
        $.removeCookie('mu_edition', {domain: 'www.foxsportsasia.com', path: '/'});
    });

}(this, jQuery));
