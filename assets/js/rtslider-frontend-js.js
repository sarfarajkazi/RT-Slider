$ = jQuery;
$(document).ready(function () {
    var rt_slider = {
        init: function () {
            var settings = JSON.parse($("#slick_settings").attr("data-settings"));
            var slide_to_show = 1;
            var slide_to_scroll = 1;
            $('.slick_slider').slick({
                dots: settings.bullets == 1 ? true : false,
                arrows: settings.arrows == 1 ? true : false,
                infinite: true,
                autoplay: settings.autoplay == 1 ? true : false,
                speed: settings.speed,
                autoplaySpeed: 3000,
                fade: true,
                fadeSpeed: 1000,
                adaptiveHeight: true
            });
            $('head').append(
                '<style>' +
                '.slick-prev:before, .slick-next:before' +
                '{' +
                'color: ' + settings.arrow_color + ' !important;' +
                '}' +
                '.slick-dots li.slick-active button:before,.slick-dots li button:before' +
                '{' +
                '   color:' + settings.bullet_color + '' +
                '}' +
                '@media (min-width:1281px) {' +
                '.rt_slider' +
                '{' +
                'width:' + settings.width + 'px;' +
                'height:' + settings.height + 'px;' +
                '}' +
                '.slick-initialized .slick-slide' +
                '{' +
                'height:' + settings.height + 'px;' +
                '}' +
                '}' +
                '</style>'
            );
        }
    };
    if ($('.slick_slider').length) {
        rt_slider.init();
    }


});
