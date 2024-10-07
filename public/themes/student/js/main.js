$(document).ready(function(){

        var w = $(window).width();

        if (w > 767) {
            showHideNavigation();
        } else {

        }


        var headerHeight =  $('.header_area').outerHeight();
        contentHeight();
        if (w > 767) {
            $(window).on('scroll', function () {
                contentHeight();
            });

        } else {
            $('.video_thumbnail').css({
                top : 'auto'
            })
            $('.video_thumbnail .thumbnail_content').css({
                height : 'auto'
            })
        }

        /*
        ===============================================
            MODAL
        ===============================================
        */

        // OPEN
        $('[data-modal-open]').on('click', function (e) {
            // var window_height = $(window).height();
            // var body_height = $('body').height();
            // if (body_height > window_height) {
            //     $('body').css('padding-right', '17px');
            //     $('.header_area').css('margin-right', '17px');
            // } else {
            //     $('body').css('padding-right', '0px');
            //     $('.header_area').css('margin-right', '0px');
            // }
            $('body').addClass('model_open');
            var targeted_modal_class = jQuery(this).attr('data-modal-open');
            $('[data-modal="' + targeted_modal_class + '"]').addClass('open_modal');
            e.preventDefault();
        });

        // CLOSE
        $('[data-modal-close] , .modal_overlay').on('click', function (e) {
            // $('body').css('padding-right', '0px');
            // $('.header_area').css('margin-right', '0px');
            $('body').removeClass('model_open');
            var targeted_modal_class = jQuery(this).attr('data-modal-close');
            $('[data-modal="' + targeted_modal_class + '"]').removeClass('open_modal');
            e.preventDefault();
        });

        /*
        =================================================
            WINDOW RESIZE
        =================================================
        */
        /*$(window).resize(function () {
            contentHeight()
            showHideNavigation()
        });*/

});

function contentHeight() {
    var windowScroll = $(window).scrollTop();
    var sidelength = $(".video_thumbnail").length;
    if (sidelength == true) {
        var windowHeight =  $(window).height();
        var titleHeight =  $('.video_thumbnail .title').outerHeight();
        var headerHeight =  $('.header_area').outerHeight();
        var withoutHeaderHeight = headerHeight + titleHeight;
        if (windowScroll < headerHeight) {
            $('.video_thumbnail').css({
                top : `${headerHeight}px`
            })
            $('.video_thumbnail .thumbnail_content').css({
                height : `${windowHeight - withoutHeaderHeight}px`
            })
        } else {
            $('.video_thumbnail').css({
                top : '0px'
            })
            $('.video_thumbnail .thumbnail_content').css({
                height : `${windowHeight - titleHeight}px`
            })
        }
    }
}


function showHideNavigation() {
    $('.course_collapse').hide();
    $('.close_icon').click(function() {
        $('.main_video').css({
            width : '100%'
        })
        $('.course_collapse').show();
        $('.video_thumbnail').css({
            display : 'none'
        })
    });
    $('.course_collapse').click(function() {
        $('.main_video').css({
            width : '75%'
        })
        $('.course_collapse').hide();
        $('.video_thumbnail').css({
            display : 'block'
        })
    });
}
