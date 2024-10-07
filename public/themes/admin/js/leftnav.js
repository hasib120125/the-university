/*
=================================================
    FUNCTIONS
=================================================
*/

function navSwitch(selector, listSelector = '.left_nav_list > li', finder = '.left_f_list', childSelector = '', childFinder = '') {
    $($(selector).toggleClass('open'));
    list = $(listSelector);
    var id = $(selector).data('target');
    var hideCount = 0;
    for (let index = 0; index < list.length; index++) {
        const element = list[index];
        var elementId = $(element).find(finder).data('target');
        if (id === elementId) {
            if ($(id).is(":visible")) {
                $(id).slideUp();
                $(id).removeClass('current');
                hideCount++;
            } else {
                $(id).slideDown();
                $(id).addClass('current');
            }
        } else {
            $(element).find('.left_f_list').removeClass('open');
            $(element).find('.left_f_list_level2').removeClass('open');
            $(element).find('.left_f_list_level3').removeClass('open');
            $(elementId).slideUp();
            $(elementId).removeClass('current');
            hideCount++;
            if (childSelector && childFinder) {
                hideOtherNav(childSelector, childFinder)
            }
        }
    }
}

function showHideNav(selector, listSelector = '.left_nav_list > li', parentFinder = '[data-toggle="accordion"]', innerFinder = '.left_f_list') {
    $($(selector).parent().find(parentFinder).toggleClass('open'));
    var id = $(selector).parent().find(parentFinder).data('target');
    list = $(listSelector);
    var hideCount = 0;
    for (let index = 0; index < list.length; index++) {
        const element = list[index];
        var elementId = $(element).find(innerFinder).data('target');
        if (id === elementId) {
            $(id).show();
            var idOffset = $(id).offset().top;
            var idHeight = $(id).height();
            var windowHeight = $(window).height();
            var coputedHeight = idHeight / 3;
            totalOffset = idOffset + idHeight;

            if (totalOffset > windowHeight) {
                $(id).css({
                    'top': 'auto',
                    'bottom': -coputedHeight,
                });
            }
        } else {
            $(elementId).hide();
            hideCount++;
        }
    }
}

function hideOtherNav(selector = '.left_nav_list > li', finderSelector = '.left_f_list') {
    var list = $(selector);
    for (let index = 0; index < list.length; index++) {
        const element = list[index];
        var elementId = $(element).find(finderSelector).data('target');
        $($(element).find(finderSelector).removeClass('open'));
        $(elementId).hide();
    }
}

/*
=================================================
    DOCUMENT READY
=================================================
*/
$(document).ready(function () {

    $(document).on('click', '[data-toggle="accordion"]', function () {
        navSwitch(this, '.left_nav_list > li', '.left_f_list', '.left_nav_level2', '.left_f_list_level2');
    });

    $(document).on('click', '[data-toggle="accordion_level2"]', function () {
        navSwitch(this, '.left_nav_level2', '.left_f_list_level2', '.left_nav_level3', '.left_f_list_level3');
    });

    $(document).on('click', '[data-toggle="accordion_level3"]', function () {
        navSwitch(this, '.left_nav_level3', '.left_f_list_level3');
    });

    hideOtherNav('.left_nav_list > li', '.left_f_list');

});
