
(function () {
    $(window).on('load', function () {

        /*
        =========================================================================================
        1. Spinner
        =========================================================================================
        */
        $("#preloader").fadeOut("slow");

    });
}());

$(document).ready(function(){
    $(document).on('click', '.mobile-menu-item', function() {
        $('.mobile_menu').removeClass('menu_open');
        $('.mobile_overlay').removeClass('mobile_overlay_open');
        $('#wrap').removeClass('menu_open');
    });
        // $(".header_menu > li").hover(function(){
        //     $(this).addClass("open");
        //     $('.header_area').addClass('theme_bg')
        //     }, function(){
        //     $(this).removeClass("open");
        //     $('.header_area').removeClass('theme_bg')
        // });
        $('.toggler').click(function () {
            $('html').toggleClass('left_menu_open');

        });

        $('.toggler').click(function () {
            $('#wrap').toggleClass('open_nav');
            $('.mobile_menu').toggleClass('menu_open');
            $('.mobile_overlay').toggleClass('mobile_overlay_open');
            return false;
        });
        $('.mobile_overlay , .m_close_menu').click(function () {
            $('.mobile_menu').removeClass('menu_open');
            $('.mobile_overlay').removeClass('mobile_overlay_open');
            $('#wrap').removeClass('menu_open');
        });
        $('.header_search_icon').click(function () {
            $('.header_search').slideToggle();
        });

    // function topMargin() {
    //     var headerHeight = $('.header_area').outerHeight();
    //     $('.common_margin').css({
    //         'margin-top': `${headerHeight}px`
    //     })
    // }

    $(window).on('scroll', function() {
        var scrollTop = $(window).scrollTop()
        var headerTopHeight = $('.header_top ').outerHeight();
        var headerHeight = $('.main_header').outerHeight();

        if (scrollTop > 50) {
            // $('.header_area').addClass('scrolled');
            $('.header_area').addClass('theme_bg')
            // $(".header_menu > li").hover(function(){
            //     $('.header_area').addClass('theme_bg')
            //     }, function(){
            //     $('.header_area').addClass('theme_bg')
            // });
        } else {
            // $('.header_area').removeClass('scrolled');
            $('.header_area').removeClass('theme_bg');
            // $(".header_menu > li").hover(function(){
            //     $('.header_area').addClass('theme_bg')
            //     }, function(){
            //     $('.header_area').removeClass('theme_bg')
            // });
        }

        if(scrollTop > headerTopHeight) {
            $('.main_header').addClass('fixed-top');
            $('.common_margin').css({
                'margin-top': `${headerHeight}px`
            })
        } else {
            $('.main_header').removeClass('fixed-top');
            $('.common_margin').css({
                'margin-top': 'auto'
            })
        }

        if(scrollTop > headerTopHeight) {
            $('.main_header').addClass('fixed-top');
            $('.common_margin').css({
                'margin-top': `${headerHeight}px`
            })
        } else {
            $('.main_header').removeClass('fixed-top');
            $('.common_margin').css({
                'margin-top': 'auto'
            })
        }

    });

    // topMargin();
    $(window).resize(function () {
        // topMargin();
    });




    /*
    =================================================
        TAB
    =================================================
    */

    $('.tabs li , .tabs a').click(function () {
        // e.preventDefault();
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $(".tab_content").removeClass("show");
        $($(this).attr("href")).addClass("show");
        //    alert($($(this).attr("href")));
    });

    $('.tabs ul li span').click(function () {

        if ($(this).parent().next().length > 0) {
            $(this).parent().next().addClass("active");
            $(this).parent().next().trigger('click');
        }

        if ($(this).parent().prev().length > 0) {
            $(this).parent().prev().addClass("active");
            $(this).parent().prev().trigger('click');
        }
        $(this).parent().remove();
        $($(this).parent().attr("href")).removeClass("show");
    });


    $('.left_tab li , .left_tab a').click(function () {
        // e.preventDefault();
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $(".left_tab_content").removeClass("show");
        $($(this).attr("href")).addClass("show");
        //    alert($($(this).attr("href")));
    });

    $('.left_tab ul li span').click(function () {

        if ($(this).parent().next().length > 0) {
            $(this).parent().next().addClass("active");
            $(this).parent().next().trigger('click');
        }

        if ($(this).parent().prev().length > 0) {
            $(this).parent().prev().addClass("active");
            $(this).parent().prev().trigger('click');
        }
        $(this).parent().remove();
        $($(this).parent().attr("href")).removeClass("show");
    });


    /*
    ===============================================
        ACCORDION
    ===============================================
    */

    $(document).on('click', '[data-toggle="accordion"]', function () {
        $($(this).toggleClass('open'));
        let target = $($(this).data('target'));
        target.slideToggle();
    });
});

