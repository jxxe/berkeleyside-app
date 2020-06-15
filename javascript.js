function changeScreen(screenName, changeHash = true) { // if changeHash = false, hash will be removed
    if(changeHash) {
        window.location.hash = screenName; // change url hash
    } else {
        history.pushState("", document.title, window.location.pathname); // remove url hash
    }

    var screenNames = {
        'articles': 'Articles',
        'local-deals': 'Local Deals',
        'stringer': 'Stringer',
        'settings': 'Settings',
        'post-template': 'Post',
        'deal-template': 'Deal',
        'twitter': 'Twitter'
    };

    // change button class (color)
    $('.bottom-bar-item.active-page').removeClass('active-page'); // deactivate current screen icon
    $('[data-screen="' + screenName + '"]').addClass('active-page'); // make inputted screen icon active
    // change active screen
    $('.app-screen.active-screen').removeClass('active-screen'); // deactivate current screen
    $('.app-screen.' + screenName).addClass('active-screen'); // make inputted screen active
    currentScreen = screenName; // update currentScreen
    $('html,body').scrollTop(0); // jump to top of page

    $(document).prop('title', screenNames[currentScreen] + ' - Berkeleyside App'); // change document title
}

function closeArticle() {
    $('.app-bottom-bar').show(); // show app bottom bar
    $('.app-header').css('transform', 'initial'); // correct header
    $('.app-header .logo').css('transform', 'initial'); // correct logo
    $('.header-right > i.material-icons').text('search'); // replace close with search
    $('.header-right').removeClass('close').addClass('search'); // add search class, remove close class
    if(currentScreen == 'post-template') {
        changeScreen('articles');
    } else if(currentScreen == 'deal-template') {
        changeScreen('local-deals');
    }
}

if( window.location.hash.substr(1) ) { // if there is a hash
    changeScreen( window.location.hash.substr(1) );
}

$(document).ready(function(){
    changeScreen( $('.bottom-bar-item.active-page').data('screen') );

    // load article
    $('.post-middle').click(function(e){
        e.preventDefault(); // fallback to berkeleyside website
        changeScreen('post-template', false); // change screen, remove hash
        $('.app-bottom-bar').hide(); // hide app bottom bar
        $('.search-form').hide(); // hide search form
        $('.app-header').css('transform', 'scaleX(-1)'); // flip header
        $('.app-header .logo').css('transform', 'scaleX(-1)'); // flip logo again (correct reflection)
        $('.header-right > i.material-icons').text('close'); // replace search with x
        $('.header-right').addClass('close').removeClass('search'); // add close class, remove search class
        var postId = $(this).parent().data('id');
        var articleURL = $(this).attr('href');
        $.ajax({ // load the post
            type: 'POST',
            url: 'http://localhost:10018/berkeleyside-app/get_full_post.php',
            data: {
                post_id: postId, // send post id
            },
            success: function(data) {
                // now display the post
                $('.post-template .post-title').text(data.title); // post title
                $('.post-template .post-byline').text(data.author); // post author
                $('.post-template .post-byline').attr('href', data.author_link); // author link
                $('.post-template .post-date').text(data.date); // post date
                $('.post-template .post-content').html(data.content); // post content (todo: sanitize, clean up, etc)
                $('.post-template .post-share').attr('data-url', data.link); // add url to each share button
                if(data.info == 'News Wire') {
                    $('.post-template .post-content').html('<p>This content is not available in the Berkeleyside app. You are being redirected to Berkeleyside.com...</p>'); // show redirect message
                    location.replace(articleURL); // some problem with news wires
                }
            },
            error: function(data) {
                location.replace(articleURL); // fallback to article url
            }
        })
    });

    // share buttons
    $('.share-facebook').click(function(){
        var shareUrl = $(this).data('url');
        window.open('http://facebook.com/sharer/sharer.php?u=' + shareUrl, '_blank');
    });
    $('.share-twitter').click(function(){
        var shareUrl = $(this).data('url');
        window.open('http://twitter.com/intent/tweet?text=' + shareUrl, '_blank');
    });
    $('.share-email').click(function(){
        var shareUrl = $(this).data('url');
        window.open('mailto:?body=' + shareUrl, '_blank');
    });

    // ripple effect on bottom bar buttons
    $('.ripple-wrapper').click(function(){
        $(this).animate({
            'background-size': '50%' // jump to 50%
        }, 25);
        $(this).animate({
            'background-size': '120%' // continue to fill entire button
        }, 150, function(){
            $(this).children('.ripple').css('background', 'white'); // fade out ripple
        });
        $(this).children('.ripple').css('background', 'none'); // reset ripple
    });

    // logo click actions
    $('.logo').click(function(){
        closeArticle(); // close article if is open
        $('html,body').animate({
            scrollTop: 0 // ...just scroll to top
        });
    });
    
    // change screen on icon click
    $('.bottom-bar-item').click(function(){
        changeScreen( $(this).data('screen') );
    });

    // search button & close button
    $('.header-right').click(function(){
        if($(this).hasClass('close')) { // if article is open
            closeArticle(); // close article if is open
        } else { // otherwise toggle search form
            $('.search-form').slideToggle('fast', function(){
                $('.search-input').val(''); // clear field
            }); // slide down/up search form
            $('.search-input').focus(); // keyboard focus to field
        }
    });

        // load article
    $('.post-middle').click(function(e){
        e.preventDefault(); // fallback to berkeleyside website
        changeScreen('post-template', false); // change screen, remove hash
        $('.app-bottom-bar').hide(); // hide app bottom bar
        $('.search-form').hide(); // hide search form
        $('.app-header').css('transform', 'scaleX(-1)'); // flip header
        $('.app-header .logo').css('transform', 'scaleX(-1)'); // flip logo again (correct reflection)
        $('.header-right > i.material-icons').text('close'); // replace search with x
        $('.header-right').addClass('close').removeClass('search'); // add close class, remove search class
        var postId = $(this).parent().data('id');
        var articleURL = $(this).attr('href');
        $.ajax({ // load the post
            type: 'POST',
            url: 'http://localhost:10018/berkeleyside-app/get_full_post.php',
            data: {
                post_id: postId, // send post id
            },
            success: function(data) {
                // now display the post
                $('.post-template .post-title').text(data.title); // post title
                $('.post-template .post-byline').text(data.author); // post author
                $('.post-template .post-byline').attr('href', data.author_link); // author link
                $('.post-template .post-date').text(data.date); // post date
                $('.post-template .post-content').html(data.content); // post content (todo: sanitize, clean up, etc)
                $('.post-template .post-share').attr('data-url', data.link); // add url to each share button
                if(data.info == 'News Wire') {
                    $('.post-template .post-content').html('<p>This content is not available in the Berkeleyside app. You are being redirected to Berkeleyside.com...</p>'); // show redirect message
                    location.replace(articleURL); // some problem with news wires
                }
            },
            error: function(data) {
                location.replace(articleURL); // fallback to article url
            }
        })
    });




    // load deal
    $('.deal').click(function(e){
        changeScreen('deal-template', false); // change screen, remove hash
        $('.app-bottom-bar').hide(); // hide app bottom bar
        $('.search-form').hide(); // hide search form
        $('.app-header').css('transform', 'scaleX(-1)'); // flip header
        $('.app-header .logo').css('transform', 'scaleX(-1)'); // flip logo again (correct reflection)
        $('.header-right > i.material-icons').text('close'); // replace search with x
        $('.header-right').addClass('close').removeClass('search'); // add close class, remove search class
        var dealId = $(this).data('deal');
        var dealColor = $(this).data('color');
        $.ajax({ // load the deal via AJAX
            type: 'POST',
            url: 'http://localhost:10018/berkeleyside-app/get_deals.php',
            data: {
                deal_id: dealId, // send the deal id
            },
            success: function(data) {
                // now display the deal
                $('.deal-template .discount-title').text(data.title);
                $('.deal-template .deal-expires').text('Expires ' + data.expires);
                $('.deal-template .deal-venue').text(data.venue);
                if(typeof(data.address) == 'object') {
                    $('.deal-template .deal-street-address').text(data.address.street);
                    $('.deal-template .deal-city').html(data.address.city);
                } else {
                    $('.deal-template .deal-street-address').text(data.address);
                }
                $('.deal-template-inner').attr('data-deal-color', dealColor);
            },
            error: function(data) {
                changeScreen('articles');
            }
        })
    });


    // filters
    $('.filter-item').click(function(){
        $(this).siblings('.filter-item-active').removeClass('filter-item-active');
        $(this).addClass('filter-item-active');
    });


});