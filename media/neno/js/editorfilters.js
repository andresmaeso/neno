/**
 * @author      Jensen Technologies S.L. <info@notwebdesign.com>
 * @copyright   Copyright (C) 2014 Jensen Technologies S.L. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


jQuery(document).ready(function () {

    // Load strings on results scroll
    jQuery('#elements-wrapper').scroll(function(){
        var wrapper = jQuery(this);
        if(wrapper.scrollTop() + wrapper.innerHeight()>=wrapper[0].scrollHeight && wrapper.innerHeight() > 10) {
            loadStrings();
        }
    });

    // Load string passed by the URL
    var params = document.location.search.replace('?', '');
    var paramsArray = params.split('&');
    for (var i=0; i<paramsArray.length; i++) {
        if (paramsArray[i].indexOf('stringId=') != -1) {
            var stringId = paramsArray[i].split('=')[1];
            loadTranslation(stringId);
            break;
        }
    }

    // If there are no filter options, select "Manual", "Source has changed" and "Not translated"
    if (document.location.href == document.location.origin + document.location.pathname + '?option=com_neno&view=editor') {
        jQuery('.multiselect input[type=checkbox]').prop('checked', false);
        jQuery('#input-method-1').prop('checked', true);
        jQuery('#input-status-3').prop('checked', true);
        jQuery('#input-status-4').prop('checked', true);
        loadStrings(true);
    }

    // Bind event to search button
    jQuery('.submit-form').off('click').on('click', function (e) {
        loadStrings(true);
    });

    jQuery('#adminForm').off('submit').on('submit', function (e) {
        var ev = e || window.event;
        ev.preventDefault();
        loadStrings(true);
    });

    // Fit filters inside the sidebar
    jQuery(window).resize(function(){
       jQuery('#filter_search').width(jQuery('#j-sidebar-container').innerWidth() - jQuery('.submit-form').width() - 57);
       jQuery('.multiselect-wrapper').width(jQuery('#j-sidebar-container').innerWidth() - 45);
    });
    setTimeout(function(){
        jQuery(window).resize();
    },100);

    // Set results wrapper height
    setResultsWrapperHeight();

    // Bind click event to close multiselects
    // If you click anywhere else it closes
    jQuery('html').click(function(ev){
        
        // To prevent fake jquery .click() from closing the box skip those
        // http://stackoverflow.com/questions/6674669/in-jquery-how-can-i-tell-between-a-programmatic-and-user-click
        if(ev.hasOwnProperty('originalEvent') === false) {
            return;
        }
        
        if(jQuery(ev.target).parents('.js-stools-container-filters').length === 0 && !jQuery(ev.target).hasClass('icon-arrow-down-3') && !jQuery(ev.target).hasClass('icon-arrow-right-3')) {
            jQuery('.js-stools-container-filters .btn-toggle').each(function() {
                if (jQuery(this).hasClass('open')){
                    jQuery('#' + jQuery(this).attr('data-toggle')).slideToggle('fast');
                    jQuery(this).toggleClass('open');
                    jQuery(this).blur();
                }
            });
            setTimeout(setResultsWrapperHeight,500);
        }
    });

    // Show sidebar if it's hidden
    setTimeout(function(){
        if (jQuery('#j-sidebar-container').hasClass('j-sidebar-hidden')) {
            toggleSidebar(false);
        }
    }, 100);

    // Bind click event in order to load translations
    bindStringsTranslationsLoading();
});
