function changeScreen(screenName, changeHash = true) { // if changeHash = false, hash will be removed
    if(changeHash) {
        window.location.hash = screenName; // change url hash
    } else {
        history.pushState("", document.title, window.location.pathname); // remove url hash
    }
    // change button class (color)
    $('.bottom-bar-item.active-page').removeClass('active-page'); // deactivate current screen icon
    $('[data-screen="' + screenName + '"]').addClass('active-page'); // make inputted screen icon active
    // change active screen
    $('.app-screen.active-screen').removeClass('active-screen'); // deactivate current screen
    $('.app-screen.' + screenName).addClass('active-screen'); // make inputted screen active
    currentScreen = screenName; // update currentScreen
    $('html,body').scrollTop(0); // jump to top of page
}

function closeArticle() {
    $('.app-bottom-bar').show(); // show app bottom bar
    $('.app-header').css('transform', 'initial'); // correct header
    $('.app-header .logo').css('transform', 'initial'); // correct logo
    $('.header-right > i.material-icons').text('search'); // replace close with search
    $('.header-right').removeClass('close').addClass('search'); // add search class, remove close class
    changeScreen('articles');
}

if( window.location.hash.substr(1) ) { // if there is a hash
    changeScreen( window.location.hash.substr(1) );
}

$(document).ready(function(){
    changeScreen( $('.bottom-bar-item.active-page').data('screen') );

    $('.post-middle').click(function(e){
        e.preventDefault(); // fallback to berkeleyside website
        changeScreen('post-template', false); // change screen, remove hash
        $('.app-bottom-bar').hide(); // hide app bottom bar
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

    $('.logo').click(function(){
        closeArticle(); // close article if is open
        if(currentScreen == 'articles') { // if home screen...
            if($(document).scrollTop() > $(window).height() / 3) { // if not basically at the top
                $('html,body').animate({
                    scrollTop: 0 // ...just scroll to top
                });
            }
        } else {
            changeScreen('articles'); // change to home screen
        }
    });

    $('.bottom-bar-item').click(function(){
        changeScreen( $(this).data('screen') );
    });

    $('.header-right').click(function(){
        if($(this).hasClass('close')) {
            closeArticle(); // close article if is open
        } else {
            // search feature here
        }
    })
});