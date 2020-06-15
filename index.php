<?php
$posts = file_get_contents('http://localhost:10018/berkeleyside-app/get_posts.php');
$posts = json_decode($posts, true);

$deals = file_get_contents('http://localhost:10018/berkeleyside-app/get_deals.php');
$deals = json_decode($deals, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#3F9EEA"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berkeleyside App</title>

    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png">

    <link rel="dns-prefetch" href="https://twitter.com">

    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Source Serif Pro:400,600,700|Source Sans Pro:400,600,700'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>

    <div class="main-content">

        <div class="above-header">
            <img src="sample.jpg">
        </div>

        <header class="app-header">
            <div class="app-header-inner">
                <div class="header-left">
                    <img src="logo-white.png" class="logo">
                </div>
                <div class="header-right search">
                    <i class="material-icons">search</i>
                </div>
            </div>
            <div class="search-form">
                <form action="https://berkeleyside.com" target="_blank" method="post">
                    <button>
                        <i class="material-icons">search</i>
                    </button>
                    <input required placeholder="Search Berkeleyside..." type="text" name="s" class="search-input">
                </form>
            </div>
        </header>

        <div class="post-template app-screen">

            <header class="post-header">
                <h1 class="post-title"><!-- Title --></h1>
                <div class="post-meta">
                    <div class="post-meta-left">
                        <span>By <a class="post-byline" href="" target="_blank"><!-- Author --></a></span>
                        <span class="post-date"><!-- Date --></span>
                    </div>
                    <div class="post-meta-right">
                        <img class="post-share share-facebook" data-url="" src="facebook.png">
                        <img class="post-share share-twitter" data-url="" src="twitter.png">
                        <img class="post-share share-email" data-url="" src="email.png">
                    </div>
                </div>
                <div class="post-content"><!-- Content --></div>
            </header>

        </div>

        <div class="articles app-screen active-screen">

            <div class="filters">

                <div class="filter" data-type="category">

                    <div class="filter-item filter-item-active" data-category="">
                        <span class="filter-text">All</span>
                    </div>
                    <div class="filter-item" data-category="12">
                        <span class="filter-text">City</span>
                    </div>
                    <div class="filter-item" data-category="3106">
                        <span class="filter-text">Community</span>
                    </div>
                    <div class="filter-item" data-category="40">
                        <span class="filter-text">Nosh</span>
                    </div>
                    <div class="filter-item" data-category="25">
                        <span class="filter-text">Schools</span>
                    </div>
                    <div class="filter-item" data-category="18939">
                        <span class="filter-text">Crime & Safety</span>
                    </div>
                    <div class="filter-item" data-category="6075">
                        <span class="filter-text">Opinion</span>
                    </div>

                </div>

                <div class="filter" data-type="sort">

                    <div class="filter-item filter-item-active" data-sort="date">
                        <span class="filter-text">Newest</span>
                    </div>
                    <div class="filter-item" data-sort="commentes">
                        <span class="filter-text">Most Commented</span>
                    </div>
                    <div class="filter-item" data-sort="recommended">
                        <span class="filter-text">Recommended</span>
                    </div>
                    <div class="filter-item" data-sort="nearest">
                        <span class="filter-text">Nearest</span>
                    </div>

                </div>

            </div>

            <?php foreach($posts as $post) { ?>

            <div class="post" data-id="<?php echo $post['id']; ?>">
                <div class="post-top">
                    <span class="location"><?php echo $post['info']; ?></span>
                    <span class="date"><?php echo $post['date_text']; ?></span>
                </div>
                <a class="post-middle" href="<?php echo $post['link']; ?>" target="_blank">
                    <h1 class="post-title"><?php echo $post['title']; ?></h1>
                    <img draggable="false" class="post-image" src="<?php echo $post['image']; ?>">
                </a>
                <div class="post-bottom">
                    <span class="post-byline">
                        By <a target="_blank" href="<?php echo $post['author']['link']; ?>"><?php echo $post['author']['name']; ?></a>
                    </span>
                    <a target="_blank" href="<?php echo $post['link']; ?>#comments-section" class="comment-count">
                        <i class="material-icons">comment</i>
                        <span><?php echo $post['comments']; ?></span>
                    </a>
                </div>
            </div>

            <?php } ?>

        </div>

        <div class="local-deals app-screen">

            <?php foreach($deals as $deal_id => $deal) { ?>

            <div data-color="<?php echo $deal['color']; ?>" class="deal deal-<?php echo $deal['color']; ?>" style="background-image:url(<?php echo $deal['image']; ?>)" data-deal="<?php echo $deal_id ?>">
                <div class="deal-inner">
                    <div class="deal-text-wrapper">
                        <span class="deal-date">Expires <?php echo $deal['expires']; ?></span>
                        <h2 class="deal-title"><?php echo $deal['title']; ?></h2>
                        <span class="deal-location"><?php echo $deal['venue']; ?></span>
                    </div>                 
                </div>
            </div>

            <?php } ?>

        </div>

        <div class="app-screen deal-template"><!-- Add Color as Class -->
            <div class="deal-template-inner">

                <div class="deal-coupon">
                    <div class="discount-title"><!-- Title --></div>
                    <span class="deal-venue"><!-- Store Name --></span>
                </div>
    
                <div class="deal-info">
                    <span class="deal-expires"><!-- Expiration Date --></span>
                    <div class="deal-address">
                        <i class="material-icons deal-location-icon">location_on</i>
                        <div class="deal-address-right">
                            <span class="deal-street-address"><!-- Street Address --></span>
                            <span class="deal-city"><!-- City Address --></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="app-screen stringer">

            <p>I haven't built this yet, but I was envsioning it as being a place where Berkeleyside could collect photos from the community. People could opt-in to the 'stringer' program and they would receive notifications about assignments near them. They would take a photo and get paid/points if Berkeleyside published their photo.</p>

        </div>

        <div class="app-screen twitter">

            <a class="twitter-timeline" data-chrome="noheader, nofooter, transparent, noscrollbar" data-dnt="true" data-theme="light" href="https://twitter.com/berkeleyside?ref_src=twsrc%5Etfw">Tweets by berkeleyside</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

        </div>

        <div class="app-screen settings">

            <div>
                <select name="neighborhood" id="neighborhood">
                    <option value="all">All Neighborhoods</option>
                    <option value="5879">Berkeley Hills</option>
                    <option value="12480">Central Berkeley</option>
                    <option value="9126">Claremont</option>
                    <option value="156">Downtown Berkeley</option>
                    <option value="18751">The Elmwood</option>
                    <option value="4906">Fourth Street</option>
                    <option value="1145">Lorin District</option>
                    <option value="10583">Gilman District</option>
                    <option value="2893">North Berkeley</option>
                    <option value="11128">Northside</option>
                    <option value="19775">Northwest Berkeley</option>
                    <option value="1754">Solano Avenue</option>
                    <option value="3578">South Berkeley</option>
                    <option value="11333">Southside</option>
                    <option value="9186">Southwest Berkeley</option>
                    <option value="70">West Berkeley</option>
                </select>

                <input placeholder="Display Name" type="text" name="name" id="name">

                <input type="email" name="email" id="email" placeholder="Email (optional)">

                <div class="settings-newsletters">
                    <div>
                        <input type="checkbox" name="newsletters[]" id="daily-briefing">
                        <label for="daily-briefing">Daily Briefing</label>
                    </div>
                    <div>
                        <input type="checkbox" name="newsletters[]" id="nosh-weekly">
                        <label for="nosh-weekly">Nosh Weekly</label>
                    </div>
                    <div>
                        <input type="checkbox" name="newsletters[]" id="news-alerts">
                        <label for="news-alerts">News Alerts</label>
                    </div>
                    <div>
                        <input type="checkbox" name="newsletters[]" id="best-of-times">
                        <label for="best-of-times">Best of Times</label>
                    </div>
                    <div>
                        <input type="checkbox" name="newsletters[]" id="oakland-news">
                        <label for="oakland-news">Oakland News</label>
                    </div>
                </div>
         
                <button>Update Settings</button>
                
                <p>Berkeleyside is the independent, award-winning news site in Berkeley, California, reporting on Berkeley and the East Bay.</p>
                <p>A pioneer in the field of online local journalism, Berkeleyside benefits from its large community of highly engaged readers. In 2019, Berkeleyside averaged more than 1 million pageviews and 360,000 unique visitors monthly.</p>
                <p>Our Team: Frances Dinkelspiel, Sarah Han, Lance Knobel, Colleen Leary, Doug Ng, Emilie Raguso, Tracey Taylor, Supriya Yelimeli</p>

            </div>

        </div>

        <footer class="app-bottom-bar">
            <div class="bottom-bar-item-outer ripple-wrapper">
                <div class="bottom-bar-item ripple active-page" data-screen="articles" alt="Articles">
                    <i class="material-icons">library_books</i>
                    <span>Articles</span>
                </div>
            </div>
            <div class="bottom-bar-item-outer ripple-wrapper">
                <div class="bottom-bar-item ripple" data-screen="local-deals" alt="Local Deals">
                    <i class="material-icons">fastfood</i>
                    <span>Local Deals</span>
                </div>
            </div>
            <div class="bottom-bar-item-outer ripple-wrapper">
                <div class="bottom-bar-item ripple" data-screen="stringer" alt="Stringer">
                    <i class="material-icons">photo_camera</i>
                    <span>Stringer</span>
                </div>
            </div>
            <div class="bottom-bar-item-outer ripple-wrapper">
                <div class="bottom-bar-item ripple" data-screen="twitter" alt="Twitter">
                    <i class="material-icons">forum</i>
                    <span>Twitter</span>
                </div>
            </div>
            <div class="bottom-bar-item-outer ripple-wrapper">
                <div class="bottom-bar-item ripple" data-screen="settings" alt="Settings">
                    <i class="material-icons">settings</i>
                    <span>Settings</span>
                </div>
            </div>
        </footer>

    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="javascript.js"></script>

</body>
</html>