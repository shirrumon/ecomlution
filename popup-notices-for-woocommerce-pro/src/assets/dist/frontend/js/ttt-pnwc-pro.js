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
function ttt_onElementInserted(containerSelector, selector, childSelector, callback) {
	if ("MutationObserver" in window) {
		var onMutationsObserved = function (mutations) {
			mutations.forEach(function (mutation) {
				if (mutation.addedNodes.length) {
					if (jQuery(mutation.addedNodes).length) {
						var finalSelector = selector;
						var ownElement = jQuery(mutation.addedNodes).filter(selector);
						if (childSelector != '') {
							ownElement = ownElement.find(childSelector);
							finalSelector = selector + ' ' + childSelector;
						}
						ownElement.each(function (index) {
							callback(jQuery(this), index + 1, ownElement.length, finalSelector,true);
						});
						if (!ownElement.length) {
							var childElements = jQuery(mutation.addedNodes).find(finalSelector);
							childElements.each(function (index) {
								callback(jQuery(this), index + 1, childElements.length, finalSelector,true);
							});
						}
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

var ttt_pnwc = {
	messages: [],
	open: false,
	init: function () {
		this.initializePopup();
		if (ttt_pnwc_info.ajax_opt === 'yes') {
			ttt_onElementInserted('body', '.woocommerce-error', 'li', ttt_pnwc.readNotice);
			ttt_onElementInserted('body', '.woocommerce-message', '', ttt_pnwc.readNotice);
			ttt_onElementInserted('body', '.woocommerce-info', '', ttt_pnwc.readNotice);
		}

		//ttt_pnwc.checkExistingElements('.woo-wallet-transactions-items li');
		ttt_pnwc.checkExistingElements('.woocommerce-error li');
		ttt_pnwc.checkExistingElements('.woocommerce-message');
		ttt_pnwc.checkExistingElements('.woocommerce-info');
	},
	open_popup_by_query_string: function (query_parameter) {
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
	},
	checkExistingElements: function (selector) {
		var element = jQuery(selector);
		if (element.length) {
			element.each(function (index) {
				ttt_pnwc.readNotice(jQuery(this), index + 1, element.length, selector,false);
			});
		}
	},
	readNotice: function (element, index, total, selector, dynamic) {
		var noticeType = 'success';

		if (selector.indexOf('error') > -1) {
			noticeType = 'error';
		} else if (selector.indexOf('info') > -1) {
			noticeType = 'info';
		}

		if (ttt_pnwc_info.types[noticeType] === 'yes') {
			if (index <= total) {
				ttt_pnwc.storeMessage(element, noticeType, dynamic);
			}
			if (index == total) {
				ttt_pnwc.clearPopupMessages();
				ttt_pnwc.addMessagesToPopup();
				ttt_pnwc.openPopup(element);
			}
		}
	},
	clearPopupMessages: function () {
		jQuery('#ttt-pnwc-notice').find('.ttt-pnwc-content').empty();
	},
	clearMessages: function () {
		ttt_pnwc.messages = [];
	},
	removeDuplicatedMessages: function () {
		var obj = {};
		for (var i = 0, len = ttt_pnwc.messages.length; i < len; i++)
			obj[ttt_pnwc.messages[i]['message']] = ttt_pnwc.messages[i];

		ttt_pnwc.messages = new Array();
		for (var key in obj)
			ttt_pnwc.messages.push(obj[key]);
	},
	hashMessage: function (s) {
		return s.split("").reduce(function (a, b) {
			a = ((a << 5) - a) + b.charCodeAt(0);
			return a & a
		}, 0);
	},
	setCookie: function (name, value, time) {
		var expires;
		if (time) {
			var date = new Date();
			//date.setTime(date.getTime() + (time * 24 * 60 * 60 * 1000));
			date.setTime(date.getTime() + (time * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
		}
		else {
			expires = "";
		}
		document.cookie = name + "=" + value + expires + "; path=/";
	},
	getCookie: function (c_name) {
		if (document.cookie.length > 0) {
			c_start = document.cookie.indexOf(c_name + "=");
			if (c_start != -1) {
				c_start = c_start + c_name.length + 1;
				c_end = document.cookie.indexOf(";", c_start);
				if (c_end == -1) {
					c_end = document.cookie.length;
				}
				return unescape(document.cookie.substring(c_start, c_end));
			}
		}
		return "";
	},
	isMessageValid: function (message, dynamic) {
		if (
			ttt_pnwc_info.cookie_opt.enabled !== 'yes' ||
			(ttt_pnwc_info.cookie_opt.message_origin.search('dynamic') != -1 && !dynamic) ||
			(ttt_pnwc_info.cookie_opt.message_origin.search('static') != -1 && dynamic)
		) {
			return true;
		}
		if (ttt_pnwc.getCookie(ttt_pnwc.hashMessage(message))) {
			return false;
		}
		return true;
	},
	saveMessageInCookie: function (message) {
		if (ttt_pnwc_info.cookie_opt.enabled === 'yes') {
			var hashedMessage = ttt_pnwc.hashMessage(message);
			ttt_pnwc.setCookie(hashedMessage, hashedMessage, ttt_pnwc_info.cookie_opt.time);
		}
	},
	storeMessage: function (notice, type, dynamic) {
		if (ttt_pnwc.isMessageValid(notice.html(),dynamic)) {
			ttt_pnwc.saveMessageInCookie(notice.html());
			ttt_pnwc.messages.push({message: notice.html(), type: type, dynamic:dynamic});
			ttt_pnwc.removeDuplicatedMessages();
		}
	},
	getAdditionalIconClass: function (noticeType) {
		var iconClass = "";
		switch (noticeType) {
			case "success":
				iconClass = ttt_pnwc_info.success_icon_class;
				break;
			case "error":
				iconClass = ttt_pnwc_info.error_icon_class;
				break;
			case "info":
				iconClass = ttt_pnwc_info.info_icon_class;
				break;
		}
		if (iconClass == "") {
			iconClass += " " + ttt_pnwc_info.icon_default_class;
		}
		return iconClass;
	},
	addMessagesToPopup: function (notice) {
		jQuery.each(ttt_pnwc.messages, function (index, value) {
			var additional_icon_class = ttt_pnwc.getAdditionalIconClass(value.type);
			var dynamicClass = value.dynamic ? 'ttt-dynamic' : 'ttt-static';
			jQuery('#ttt-pnwc-notice .ttt-pnwc-content').append("<div class='ttt-pnwc-notice " + value.type + ' ' + dynamicClass + " '><i class='ttt-pnwc-notice-icon " + additional_icon_class + "'></i><div class='ttt-pnwc-message'>" + value.message + "</div></div>");
		});
	},
	initializePopup: function () {
		MicroModal.init({
			awaitCloseAnimation: true,
		});
	},
	openPopup: function () {
		if (!ttt_pnwc.open && ttt_pnwc.messages.length>0) {
			ttt_pnwc.open = true;
			MicroModal.show('ttt-pnwc-notice', {
				awaitCloseAnimation: true,
				onClose: function (modal) {
					ttt_pnwc.open = false;
					ttt_pnwc.clearMessages();
				}
			});
		}

	}
};
document.addEventListener('DOMContentLoaded', function () {
	ttt_pnwc.init();
	ttt_pnwc.open_popup_by_query_string();
	jQuery('body').trigger({
		type: 'ttt_pnwc',
		obj: ttt_pnwc
	});
});