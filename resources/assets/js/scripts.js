/* 01. Handle Scrollbar
------------------------------------------------ */
var handleSlimScroll = function() {
    "use strict";
    $('[data-scrollbar=true]').each( function() {
        generateSlimScroll($(this));
    });
};
var generateSlimScroll = function(element) {
    if ($(element).attr('data-init')) {
        return;
    }
    var dataHeight = $(element).attr('data-height');
        dataHeight = (!dataHeight) ? $(element).height() : dataHeight;
    
    var scrollBarOption = {
        height: dataHeight
    };
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $(element).css('height', dataHeight);
        $(element).css('overflow-x','scroll');
    } else {
        $(element).slimScroll(scrollBarOption);
    }
    $(element).attr('data-init', true);
    $('.slimScrollBar').hide();
};


/* 02. Handle Sidebar - Menu
------------------------------------------------ */
var handleSidebarMenu = function() {
    "use strict";
    
    var expandTime = ($('.sidebar').attr('data-disable-slide-animation')) ? 0 : 250;
    $('.sidebar .nav > .has-sub > a').click(function() {
        var target = $(this).next('.sub-menu');
        var otherMenu = $('.sidebar .nav > li.has-sub > .sub-menu').not(target);
    
        if ($('.page-sidebar-minified').length === 0) {
            $(otherMenu).closest('li').addClass('closing');
            $(otherMenu).slideUp(expandTime, function() {
                $(otherMenu).closest('li').addClass('closed').removeClass('expand closing');
            });
            if ($(target).is(':visible')) {
                $(target).closest('li').addClass('closing').removeClass('expand');
            } else {
                $(target).closest('li').addClass('expanding').removeClass('closed');
            }
            $(target).slideToggle(expandTime, function() {
                var targetLi = $(this).closest('li');
                if (!$(target).is(':visible')) {
                    $(targetLi).addClass('closed');
                    $(targetLi).removeClass('expand');
                } else {
                    $(targetLi).addClass('expand');
                    $(targetLi).removeClass('closed');
                }
                $(targetLi).removeClass('expanding closing');
            });
        }
    });
    $('.sidebar .nav > .has-sub .sub-menu li.has-sub > a').click(function() {
        if ($('.page-sidebar-minified').length === 0) {
            var target = $(this).next('.sub-menu');
            if ($(target).is(':visible')) {
                $(target).closest('li').addClass('closing').removeClass('expand');
            } else {
                $(target).closest('li').addClass('expanding').removeClass('closed');
            }
            $(target).slideToggle(expandTime, function() {
                var targetLi = $(this).closest('li');
                if (!$(target).is(':visible')) {
                    $(targetLi).addClass('closed');
                    $(targetLi).removeClass('expand');
                } else {
                    $(targetLi).addClass('expand');
                    $(targetLi).removeClass('closed');
                }
                $(targetLi).removeClass('expanding closing');
            });
        }
    });
};


/* 03. Handle Sidebar - Mobile View Toggle
------------------------------------------------ */
var handleMobileSidebarToggle = function() {
    var sidebarProgress = false;
    
    $('.sidebar').bind('click touchstart', function(e) {
        if ($(e.target).closest('.sidebar').length !== 0) {
            sidebarProgress = true;
        } else {
            sidebarProgress = false;
            e.stopPropagation();
        }
    });
    
    $(document).bind('click touchstart', function(e) {
        if ($(e.target).closest('.sidebar').length === 0) {
            sidebarProgress = false;
        }
        if ($(e.target).closest('#float-sub-menu').length !== 0) {
            sidebarProgress = true;
        }
        
        if (!e.isPropagationStopped() && sidebarProgress !== true) {
            if ($('#page-container').hasClass('page-sidebar-toggled')) {
                sidebarProgress = true;
                $('#page-container').removeClass('page-sidebar-toggled');
            }
            if ($(window).width() <= 767) {
                if ($('#page-container').hasClass('page-right-sidebar-toggled')) {
                    sidebarProgress = true;
                    $('#page-container').removeClass('page-right-sidebar-toggled');
                }
            }
        }
    });
    
    $('[data-click=right-sidebar-toggled]').click(function(e) {
        e.stopPropagation();
        var targetContainer = '#page-container';
        var targetClass = 'page-right-sidebar-collapsed';
            targetClass = ($(window).width() < 979) ? 'page-right-sidebar-toggled' : targetClass;
        if ($(targetContainer).hasClass(targetClass)) {
            $(targetContainer).removeClass(targetClass);
        } else if (sidebarProgress !== true) {
            $(targetContainer).addClass(targetClass);
        } else {
            sidebarProgress = false;
        }
        if ($(window).width() < 480) {
            $('#page-container').removeClass('page-sidebar-toggled');
        }
        $(window).trigger('resize');
    });
    
    $('[data-click=sidebar-toggled]').click(function(e) {
        e.stopPropagation();
        var sidebarClass = 'page-sidebar-toggled';
        var targetContainer = '#page-container';

        if ($(targetContainer).hasClass(sidebarClass)) {
            $(targetContainer).removeClass(sidebarClass);
        } else if (sidebarProgress !== true) {
            $(targetContainer).addClass(sidebarClass);
        } else {
            sidebarProgress = false;
        }
        if ($(window).width() < 480) {
            $('#page-container').removeClass('page-right-sidebar-toggled');
        }
    });
};


/* 04. Handle Sidebar - Minify / Expand
------------------------------------------------ */
var handleSidebarMinify = function() {
    $(document).on('click', '[data-click=sidebar-minify]', function(e) {
        e.preventDefault();
        console.log('clicked');
        var sidebarClass = 'page-sidebar-minified';
        var targetContainer = '#page-container';
        
        if ($(targetContainer).hasClass(sidebarClass)) {
            $(targetContainer).removeClass(sidebarClass);
        } else {
            $(targetContainer).addClass(sidebarClass);
    
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                $('#sidebar [data-scrollbar="true"]').css('margin-top','0');
                $('#sidebar [data-scrollbar="true"]').css('overflow-x', 'scroll');
            }
        }
        $(window).trigger('resize');
    });
};
