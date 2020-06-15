<?php
$posts = file_get_contents('http://localhost:10018/berkeleyside-app/get_posts.php');
$posts = json_decode($posts, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - Berkeleyside</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Source Serif Pro:400,600,700|Source Sans Pro:400,600,700'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>

    <div class="main-content">

        <div class="above-header">
            <img src="sample.jpg">
        </div>

        <header class="app-header">
            <div class="header-left">
                <img src="logo-white.png" class="logo">
            </div>
            <div class="header-right search">
                <i class="material-icons">search</i>
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

            <div class="deal">
                
            </div>

        </div>

        <footer class="app-bottom-bar">
            <div class="bottom-bar-item-outer ripple-wrapper">
                <div class="bottom-bar-item ripple active-page" data-screen="articles" alt="Articles">
                    <i class="material-icons">home</i>
                    <span>Articles</span>
                </div>
            </div>
            <div class="bottom-bar-item-outer ripple-wrapper">
                <div class="bottom-bar-item ripple" data-screen="local-deals" alt="Local Deals">
                    <i class="material-icons">local_offer</i>
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