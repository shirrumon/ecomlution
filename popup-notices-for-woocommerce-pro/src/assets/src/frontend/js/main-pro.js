function ttt_onElementInserted(containerSelector, selector, callback) {
    if ("MutationObserver" in window) {
        var onMutationsObserved = function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.addedNodes.length) {
                    if (jQuery(mutation.addedNodes).length) {
                        var ownElement = jQuery(mutation.addedNodes).filter(selector);
                        ownElement.each(function (index) {
                            callback(jQuery(this), index + 1, ownElement.length, selector);
                        });
                        var childElements = jQuery(mutation.addedNodes).find(selector);
                        childElements.each(function (index) {
                            callback(jQuery(this), index + 1, childElements.length, selector);
                        });
                    }
                }
            });
        };

        var target = jQuery(containerSelector)[0];
        var config = {childList: true, subtree: true};
        var MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
        var observer = new MutationObserver(onMutationsObserved);
        observer.observe(target, config);
    } else {
        console.log('No MutationObserver');
    }
}

function ttt_getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

var ttt_pnwc_pro = {
    ttt_pnwc: null,
    init: function (ttt_pnwc) {
        this.ttt_pnwc = ttt_pnwc;
        if (ttt_pnwc_info.ajax_opt === 'yes') {
            ttt_onElementInserted('body', '.woocommerce-error li', ttt_pnwc.readNotice);
            ttt_onElementInserted('body', '.woocommerce-message', ttt_pnwc.readNotice);
            ttt_onElementInserted('body', '.woocommerce-info', ttt_pnwc.readNotice);
        }
    },
    open_popup_by_query_string:function(query_parameter){
        query_parameter = query_parameter || 'ttt_pnwc';
        var query_string_value = ttt_getParameterByName(query_parameter);
        if (query_string_value !== null && query_string_value !== '') {
            ttt_pnwc.clearPopupMessages();
            ttt_pnwc.messages.push({message: 'Customize Popup Notices style easily!', type: 'success'});
            ttt_pnwc.messages.push({message: 'Please take a look at an error message', type: 'error'});
            ttt_pnwc.messages.push({message: 'And a default one too', type: 'info'});
            ttt_pnwc.addMessagesToPopup();
            ttt_pnwc.openPopup();
        }
    }
}

if (typeof ttt_pnwc === 'undefined' || jQuery.isEmptyObject(ttt_pnwc)) {
    jQuery('body').on('ttt_pnwc', function (e) {
        ttt_pnwc = e.obj;
        ttt_pnwc_pro.init(ttt_pnwc);
        ttt_pnwc_pro.open_popup_by_query_string();
    });
} else {
    ttt_pnwc_pro.init(ttt_pnwc);
}