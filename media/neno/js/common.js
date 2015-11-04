/**
 * @author      Jensen Technologies S.L. <info@notwebdesign.com>
 * @copyright   Copyright (C) 2014 Jensen Technologies S.L. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */



function highlightBox(selector) {
    
    jQuery(selector).addClass('highlighted-box');
    setTimeout(function () {
        jQuery(selector).removeClass('highlighted-box');
    }, 500);    
    
}




// Check if the user has lost the session
function onBeforeAjax() {
    jQuery.get('index.php?option=com_neno&task=checkSession', function (response) {
        if (response != 'ok') {
            document.location.reload();
        }
    });
}

/**
 * Fixes issues with a language such as "language out of date" or "missing content"
 */
function fixIssue() {
    var button = jQuery(this);
    button.closest('.alert').remove();
    jQuery.ajax({
        beforeSend: onBeforeAjax,
        url: 'index.php?option=com_neno&task=fixLanguageIssue',
        data: {
            language: button.data('language'),
            issue: button.data('issue')
        },
        type: 'POST'
    });
}

function loadMissingTranslationMethodSelectors(listSelector, placement) {
    apply = false;
    if (typeof listSelector != 'string') {
        var parent = jQuery('.translation-method-selector-container').parent();

        if (typeof parent.prop('id') == 'undefined' || parent.prop('id') == '') {
            listSelector = '.method-selectors';
        }
        else {
            listSelector = '#' + parent.prop('id');
        }
    }

    if (typeof placement != 'string') {
        placement = 'language';
    }

    if (typeof jQuery(this).prop("tagName") == 'undefined') {
        i = 1;
        jQuery(listSelector).each(function () {
            //Count how many we currently are showing
            var n = jQuery(this).find('.translation-method-selector-container').length;

            //If we are loading because of changing a selector, remove all children
            var selector_id = jQuery(this).find('.translation-method-selector').attr('data-selector-id');
            if (typeof selector_id !== 'undefined') {
                //Loop through each selector and remove the ones that are after this one
                for (var i = 0; i < n; i++) {
                    if (i > selector_id) {
                        jQuery(this).find("[data-selector-container-id='" + i + "']").remove();
                    }
                }
            }
            //Create a string to pass the current selections
            var selected_methods_string = '';
            jQuery(this).find('.translation-method-selector').each(function () {
                selected_methods_string += '&selected_methods[]=' + jQuery(this).find(':selected').val();
            });
            var lang = jQuery(this).closest(listSelector).data('language');
            var otherParams = '';

            if (typeof lang != 'undefined') {
                otherParams = '&language=' + lang;
            }

            executeAjaxForTranslationMethodSelectors(listSelector, placement, n, selected_methods_string, jQuery(this).find('.translation-method-selector'), otherParams, false);
        });
    }
    else {

        //If we are loading because of changing a selector, remove all children
        var selector_id = jQuery(this).data('selector-id');
        var n = jQuery(this).closest(listSelector).find('.translation-method-selector-container').length;
        if (typeof selector_id !== 'undefined') {
            //Loop through each selector and remove the ones that are after this one
            for (var i = 0; i < n; i++) {
                if (i > selector_id) {
                    jQuery(this).closest(listSelector).find("[data-selector-container-id='" + i + "']").remove();
                    n--;
                }
            }
        }
        var selected_methods_string = '&selected_methods[]=' + jQuery(this).find(':selected').val();
        var lang = jQuery(this).closest(listSelector).data('language');
        var otherParams = '';
        var element = jQuery(this);

        if (typeof lang != 'undefined') {
            otherParams = '&language=' + lang;
        }

        var modal = jQuery('#translationMethodModal');

        // There isn't a modal, so we are on the installation process setting up the translation method for the source language
        if (modal.length == 0) {
            executeAjaxForTranslationMethodSelectors(listSelector, 'general', n, selected_methods_string, element, otherParams);
        }
        else {
            var run = modal.length == 0;


            modal.modal('show');
            modal.find('.yes-btn').off('click').on('click', function () {
                saveTranslationMethod(element.find(':selected').val(), lang, selector_id + 1, true);
                run = true;
                modal.modal('hide');
                apply = true;
            });

            modal.off('hide').on('hide', function () {
                if (!run) {
                    saveTranslationMethod(element.find(':selected').val(), lang, selector_id + 1, false);
                }

                executeAjaxForTranslationMethodSelectors(listSelector, placement, n, selected_methods_string, element, otherParams);
            });

        }

    }
}


function executeAjaxForTranslationMethodSelectors(listSelector, placement, n, selected_methods_string, element, otherParams) {
    if (typeof otherParams == 'undefined') {
        otherParams = '';
    }
    jQuery.ajax({
        beforeSend: onBeforeAjax,
        url: 'index.php?option=com_neno&task=getTranslationMethodSelector&placement=' + placement + '&n=' + n + selected_methods_string + otherParams,
        success: function (html) {
            if (html !== '') {
                jQuery(element).closest(listSelector).append(html);

                if (placement == 'language') {
                    jQuery(element).closest(listSelector).find('.translation-method-selector').each(function () {
                        saveTranslationMethod(jQuery(this).find(':selected').val(), jQuery(this).closest(listSelector).data('language'), jQuery(this).data('selector-id') + 1, apply);
                    });
                }
            }

            jQuery('select').chosen();
            jQuery('.translation-method-selector').off('change').on('change', loadMissingTranslationMethodSelectors);
            var container = element.parents('.language-configuration');
            var select1 = element.parents(listSelector).find("[data-selector-container-id='1']");
            if (select1.length) {
                if (!container.hasClass('expanded')) {
                    container.css('min-height',
                        parseInt(container.css('min-height')) + 60
                    );
                    container.addClass('expanded');
                }
            } else if (container.hasClass('expanded')) {
                container.css('min-height',
                    parseInt(container.css('min-height')) - 60
                );
                container.removeClass('expanded');
            }
        }
    });
}

function saveTranslationMethod(translationMethod, language, ordering, applyToElements) {
    if (typeof applyToElements == 'undefined') {
        applyToElements = false;
    }

    applyToElements = applyToElements ? 1 : 0;

    jQuery.ajax({
        beforeSend: onBeforeAjax,
        url: 'index.php?option=com_neno&task=saveTranslationMethod',
        type: 'POST',
        data: {
            translationMethod: translationMethod,
            language: language,
            ordering: ordering,
            applyToElements: applyToElements
        }
    });
}

function setResultsWrapperHeight() {
    var available = jQuery(window).outerHeight() - jQuery('header').outerHeight() - jQuery('.subhead-collapse').outerHeight() - jQuery('#status').outerHeight();
    var sidebar = jQuery('#j-sidebar-container');
    sidebar.height(available);

    var results = jQuery('#results-wrapper');
    var resultsBottom = results.position().top + results.outerHeight();
    var gap = sidebar.outerHeight() - resultsBottom;
    var elements = jQuery('#elements-wrapper');
    elements.height(elements.outerHeight() + gap - 70);
}
