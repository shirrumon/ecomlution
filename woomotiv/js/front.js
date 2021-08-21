/**
 * Woomotive plugin (Frontend script)
 */
 (function( $ ){
    
    var body = $('body');
    var nonce = woomotivObj.nonce;
    var ajax_url = woomotivObj.ajax_url;
    var currentIndex = 0; 
    var noMoreItems = false;
    var $items = [];
    var timer = false;
    var secTimer = false;
    var intervalTime = parseInt( woomotivObj.interval ) * 1000;
    var hideTime = parseInt( woomotivObj.hide ) * 1000;
    var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
    var cancelAnimationFrame = window.cancelAnimationFrame || window.mozCancelAnimationFrame;
    var requestAnimID;
    var excluded = {
        products: [],
        reviews: [],
        custom: [],
    };
    var isNoRepeatEnabled = parseInt(woomotivObj.is_no_repeat_enabled) === 1 && parseInt(woomotivObj.is_premium) === 1 ? 1 : 0;
    var excludedProductsKey = 'woomotiv_seen_products_' + woomotivObj.site_hash;
    var excludedReviewsKey = 'woomotiv_seen_reviews_' + woomotivObj.site_hash;
    var excludedCustomPopKey = 'woomotiv_seen_custompop_' + woomotivObj.site_hash;

    function whichTransitionEndEvent(){
        var t;
        var el = document.createElement('fakeelement');
        var transitions = {
          'transition':'transitionend',
          'OTransition':'oTransitionEnd',
          'MozTransition':'transitionend',
          'WebkitTransition':'webkitTransitionEnd'
        }
    
        for(t in transitions){
            if( el.style[t] !== undefined ){
                return transitions[t];
            }
        }
    }

    function whichAnimationEndEvent(){
        
        var t;
        var el = document.createElement('fakeelement');

        var transitions = {
          'animation':'animationend',
          'OAnimation':'oAnimationEnd',
          'MozAnimation':'animationend',
          'WebkitAnimation':'webkitAnimationEnd'
        }
    
        for(t in transitions){            
            if( el.style[t] !== undefined ){
                return transitions[t];
            }
        }
    }

    function whichTransitionStartEvent(){

        var t;
        var el = document.createElement('fakeelement');

        var transitions = {
          'transition':'transitionstart',
          'OTransition':'oTransitionStart',
          'MozTransition':'transitionstart',
          'WebkitTransition':'webkitTransitionStart'
        }
    
        for(t in transitions){
            if( el.style[t] !== undefined ){
                return transitions[t];
            }
        }
    }

    function whichAnimationStartEvent(){
        
        var t;
        var el = document.createElement('fakeelement');

        var transitions = {
          'animation':'animationstart',
          'OAnimation':'oAnimationStart',
          'MozAnimation':'animationstart',
          'WebkitAnimation':'webkitAnimationStart'
        }
    
        for(t in transitions){            
            if( el.style[t] !== undefined ){
                return transitions[t];
            }
        }
    }

    var transitionEndEvent = whichTransitionEndEvent();
    var animationEndEvent = whichAnimationEndEvent();
    var transitionStartEvent = whichTransitionStartEvent();
    var animationStartEvent = whichAnimationStartEvent();
    var transitionAnimations = [ 'fade', 'slideup', 'slidedown', 'slideright', 'slideleft' ];
    var tStartEvent = transitionAnimations.indexOf( woomotivObj.animation ) != -1 ? transitionStartEvent : animationStartEvent;
    var tEndEvent = transitionAnimations.indexOf( woomotivObj.animation ) != -1 ? transitionEndEvent : animationEndEvent;

    /**
     * Adds time to a date. Modelled after MySQL DATE_ADD function.
     * Example: dateAdd(new Date(), 'minutes', 30)  //returns 30 minutes from now.
     * 
     * @param date  Date to start with
     * @param interval  One of: year, quarter, month, week, day, hour, minute, second
     * @param units  Number of units of the given interval to add.
     */
    function dateAdd(date, interval, units) {
        var ret = new Date(date); //don't change original date
        var checkRollover = function() { if(ret.getDate() != date.getDate()) ret.setDate(0);};
        switch(interval.toLowerCase()) {
            case 'year'   :  ret.setFullYear(ret.getFullYear() + units); checkRollover();  break;
            case 'quarter':  ret.setMonth(ret.getMonth() + 3*units); checkRollover();  break;
            case 'month'  :  ret.setMonth(ret.getMonth() + units); checkRollover();  break;
            case 'week'   :  ret.setDate(ret.getDate() + 7*units);  break;
            case 'day'    :  ret.setDate(ret.getDate() + units);  break;
            case 'hour'   :  ret.setTime(ret.getTime() + units*3600000);  break;
            case 'minute' :  ret.setTime(ret.getTime() + units*60000);  break;
            case 'second' :  ret.setTime(ret.getTime() + units*1000);  break;
            default       :  ret = undefined;  break;
        }
        return ret;
    }

    /**
     * Wrapper for $.ajax
     * @param {String} action 
     * @param {Object} data 
     */
    function ajax( action, data ){

        data = typeof data === 'object' ? data : {};

        data.action = 'woomotiv_' + action;
        
        if( ! data.hasOwnProperty('nonce') ){
            data.nonce = nonce;
        }

        return $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
        });

    }

    /**
     * Looper
     */
    function start( cindex ){
        
        cindex = parseInt( cindex );
        currentIndex = cindex;

        var $item = $items[ cindex - 1 ];

        // Show element
        $item.addClass('wmt-current');

        // item.one( tStartEvent, function(){
        //     console.log(this);
        // });

        // First one fires after element is completely visible
        // Second one after element is completetly hidden
        $item.one( tEndEvent , function(){

            // Update excluded
            if( $item.is('[data-type="product"]') ){
                addExcludedProduct( parseInt( $item.attr('data-orderitemid') ) );
            }
            else if( $item.is('[data-type="review"]') ){
                addExcludedReview( parseInt( $item.attr('data-review') ) );
            }
            else if( $item.is('[data-type="custom"]') ){
                addExcludedCustomPop( parseInt( $item.attr('data-id') ) );
            }
            
            // Hide element
            secTimer = setTimeout(function(){
                $item.removeClass('wmt-current');

                // after animation is completed show the next one or fetch new popups
                $item.one( tEndEvent , function(){
                    timer = setTimeout( function(){

                        // Fetch new items if possible
                        if( cindex === $items.length && ! noMoreItems ){
                            
                            if( isNoRepeatEnabled ){
                                excluded.products = getExcludedProductsFromStorage();
                                excluded.reviews = getExcludedReviewsFromStorage();
                                excluded.custom = getExcludedCustomPopsFromStorage();
                            }

                            getItems(excluded);
                        }
                        // Reset current index
                        else if( cindex === $items.length && noMoreItems ){

                            // Clear excluded items
                            if( isNoRepeatEnabled ){
                                
                                clearLocalStorage();
                                excluded.products = [];
                                excluded.reviews = [];
                                excluded.custom = [];

                                // Do not show any items, leave for the next reload
                            }
                            else{
                                // First one
                                start( 1 );
                            }
                        }
                        else{
                            // Next one
                            start( cindex + 1 );
                        }

                    }, intervalTime );
                });

            }, hideTime );
        });
    }

    /**
     * Add excluded product to storage
     * @param {*} orderItemId 
     */
    function addExcludedProduct( orderItemId ){

        // No dulication
        excluded.products = excluded.products.filter(function( item ){
            if( item == orderItemId ) return false;

            return true;
        });
        
        excluded.products.push(orderItemId);

        if( ! isNoRepeatEnabled ) return;

        var products = getExcludedProductsFromStorage();
        var isFound = false;

        products.map(function( item ){
            if( item == orderItemId ) isFound = true;
        });

        if( ! isFound ){
            products.push(orderItemId);
            localStorage.setItem( excludedProductsKey, products.join(',') );
        }
    }

    /**
     * Add excluded review to storage
     * @param {*} reviewId 
     */
     function addExcludedReview( reviewId ){
        
        // No dulication
        excluded.reviews = excluded.reviews.filter(function( item ){
            if( item == reviewId ) return false;

            return true;
        });

        excluded.reviews.push(reviewId);

        if( ! isNoRepeatEnabled ) return;

        var reviews = getExcludedReviewsFromStorage();
        var isFound = false;

        reviews.map(function( item ){
            if( item == reviewId ) isFound = true;
        });

        if( ! isFound ){
            reviews.push(reviewId);
            localStorage.setItem( excludedReviewsKey, reviews.join(',') );
        }
    }

    /**
     * Add excluded custom popup to storage
     * @param {*} reviewId 
     */
     function addExcludedCustomPop( id ){
        
        // No dulication
        excluded.custom = excluded.custom.filter(function( item ){
            if( item == id ) return false;

            return true;
        });

        excluded.custom.push( id );

        if( ! isNoRepeatEnabled ) return;

        var customPops = getExcludedCustomPopsFromStorage();
        var isFound = false;

        customPops.map(function( item ){
            if( item == id ) isFound = true;
        });

        if( ! isFound ){
            customPops.push(id);
            localStorage.setItem( excludedCustomPopKey, customPops.join(',') );
        }
    }

    /**
     * Return excluded products from localStorage
     * 
     * @returns {array}
     */
    function getExcludedProductsFromStorage(){

        var products = localStorage.getItem( excludedProductsKey );
        products = ! products ? [] : products.split(',');

        return products.filter(function(item){

            if( item === "" ) return false;

            return true;
        });
    }

    /**
     * Return excluded reviews from localStorage
     * 
     * @returns {array}
     */
    function getExcludedReviewsFromStorage(){

        var reviews = localStorage.getItem( excludedReviewsKey );
        reviews = ! reviews ? [] : reviews.split(',');

        return reviews.filter(function(item){
            
            if( item === "" ) return false;

            return true;
        });
    }

    /**
     * Return excluded custom popups from localStorage
     * 
     * @returns {array}
     */
     function getExcludedCustomPopsFromStorage(){

        var customPops = localStorage.getItem( excludedCustomPopKey );
        customPops = ! customPops ? [] : customPops.split(',');

        return customPops.filter(function(item){
            
            if( item === "" ) return false;

            return true;
        });
    }

    /**
     * Clear localStorage
     */
    function clearLocalStorage(){
        localStorage.removeItem( excludedProductsKey );
        localStorage.removeItem( excludedReviewsKey );
        localStorage.removeItem( excludedCustomPopKey );
    }

    /**
     * Get items using ajax
     */
    function getItems( excluded ){
        
        // Get items and create html nodes 
        ajax( 'get_items', {
            excluded: excluded,
        }).done( function( response ){

            if( ! response.hasOwnProperty( 'data' ) ) return;
            if( response.data === '' ) return;
            if( response.data.length === 0 && $items.length === 0 ) return;

            // No more popups, let's show the first 1
            if( response.data.length === 0 ){
                noMoreItems = true;
                start(1);
                return;
            }

            // Add the new popups to the body
            response.data.map(function( itemData ){

                var $item = $(itemData.markup);
                
                $item.attr('data-index', $items.length + 1);

                // Add to body
                body.append( $item );
                $items.push( $item );

                // New items events
                $item.on( 'mouseenter', function( e ){
                    $(this).off( tEndEvent );
                    clearTimeout( timer );
                    clearTimeout( secTimer );
                    cancelAnimationFrame(requestAnimID);
                });

                $item.on( 'mouseleave', function( event ){

                    var $this = $('.woomotiv-popup.wmt-current');
                    var index = parseInt($this.attr('data-index'));
                    var halftime = parseInt( hideTime / 2 );

                    if( index === undefined ) return;
                    
                    setTimeout(function(){

                        $this.removeClass('wmt-current');
                        
                    }, halftime );

                    setTimeout( function (){
                        
                        requestAnimID = requestAnimationFrame( function(){
                            start( index + 1 );
                        });

                    }, ( hideTime + hideTime ) );

                });

                $item.find('.woomotiv-close').on( 'click', function( event ){
                    event.preventDefault();
                    $('.woomotiv-popup').remove();
                    localStorage.setItem('woomotiv_pause_date_' + woomotivObj.site_hash , dateAdd( new Date(), 'minute', 10 ) );
                });

                // Stats Update
                $item.on( 'click', function( event ){

                    event.preventDefault();

                    var self = $(this);
                    var data = {};

                    if( self.data('type') === 'product' ){
                        data.type = 'product';
                        data.product_id = self.data('product');
                    }
                    else if( self.data('type') === 'review' ){
                        data.type = 'review';
                        data.product_id = self.data('product');
                    }
                    else{
                        data.type = 'custom';
                        data.id = self.data('id');
                    }

                    ajax( 'update_stats', data ).done(function( response ){
                                            
                        if( woomotivObj.disable_link != 1 ){
                            location.href = self.find('.woomotiv-link').attr('href');
                        }

                    });

                });
            });

            // show time
            setTimeout(function(){
                
                requestAnimID = requestAnimationFrame( function(){
                    start( currentIndex + 1 );
                });

            }, parseInt( intervalTime / 2 ) );

        });
    }

    // No-repeat is disabled, lets clear the local storage
    if( ! isNoRepeatEnabled ){
        clearLocalStorage();
    }
    // No-repeat is enabled, let's get the excluded one from the local storage
    else{
        excluded.products = getExcludedProductsFromStorage();
        excluded.reviews = getExcludedReviewsFromStorage();
        excluded.custom = getExcludedCustomPopsFromStorage();
    }

    // Show time
    if( localStorage.getItem('woomotiv_pause_date_' + woomotivObj.site_hash ) ){
        var pause_date = new Date( localStorage.getItem('woomotiv_pause_date_' + woomotivObj.site_hash ) );

        if( pause_date > new Date() ){
            return;
        }
        else{
            getItems(excluded);
        }
    }
    else{
        getItems(excluded);
    }

})( jQuery );