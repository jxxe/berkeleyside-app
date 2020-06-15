<?php
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if(!file_exists('cache/' . date('d-m-Y-H') . '.json')) {
    $amount = '10';
    $page = '1';
    $url = 'https://www.berkeleyside.com/wp-json/wp/v2/posts?per_page=' . $amount . '&page=' . $page;

    $posts = file_get_contents($url);
    $posts = json_decode($posts, true);

    $neighborhoods = [
        '5879' => 'Berkeley Hills',
        '12480' => 'Central Berkeley',
        '9126' => 'Claremont',
        '156' => 'Downtown Berkeley',
        '18751' => 'The Elmwood',
        '4906' => 'Fourth Street',
        '1145' => 'Lorin District',
        '10583' => 'Gilman District',
        '2893' => 'North Berkeley',
        '11128' => 'Northside',
        '19775' => 'Northwest Berkeley',
        '1754' => 'Solano Avenue',
        '3578' => 'South Berkeley',
        '11333' => 'Southside',
        '9186' => 'Southwest Berkeley',
        '70' => 'West Berkeley'
    ];

    $categories = [
        '6' => 'Arts',
        '7' => 'Berkeleyside',
        '18937' => 'Bites',
        '197' => 'Business',
        '12' => 'City',
        '3106' => 'Community',
        '74' => 'Crime',
        '18939' => 'Crime & Safety',
        '845' => 'Drink',
        '39' => 'Events',
        '1136' => 'Fire',
        '34' => 'Housing',
        '5' => 'Nature',
        '19017' => 'News Wire',
        '40' => 'Nosh',
        '18887' => 'Nosh lists',
        '19645' => 'Nosh videos',
        '20233' => 'Oakland news',
        '10762' => 'Obituaries',
        '6075' => 'Opinion',
        '41' => 'Police',
        '1126' => 'Politics',
        '18936' => 'Recipes',
        '25' => 'Schools',
        '13377' => 'Sponsored posts',
        '2809' => 'Video',
        '19861' => 'Video story',
    ];

    foreach($posts as $post) {

        $date = $post['date']; // ISO 8601 date
        $dateStorage = $date;
        $link = $post['link']; // url
        $title = strip_tags($post['title']['rendered']); // string, strip tags
        $excerpt = strip_tags($post['excerpt']['rendered']); // string, strip tags
        $postCategory = $post['categories'][0]; // array of integers
        $tags = $post['tags']; // array of integers
        $content = $post['content']['rendered']; // html
        $author = $post['author']; // integer
        $comments = $post['yoast_head']; // string that includes json
        $image = $post['featured_media']; // integer
        $id = $post['id']; // integer

        preg_match('/<script type="application\/ld\+json" class="yoast-schema-graph">(.*?)<\/script>/s', $comments, $comments);

        $comments = $comments[1];
        $comments = json_decode($comments, true);
        $comments = $comments['@graph'][4]['commentCount'];

        $authorData = 'https://www.berkeleyside.com/wp-json/wp/v2/users?include=' . $author;
        $authorData = file_get_contents($authorData);
        $authorData = json_decode($authorData, true);
        $authorData = $authorData[0];
        $author = $authorData['name'];
        $authorLink = 'https://www.berkeleyside.com/author/' . $authorData['slug'];

        $imageData = 'https://www.berkeleyside.com/wp-json/wp/v2/media?include=' . $image;
        $imageData = file_get_contents($imageData);
        $imageData = json_decode($imageData, true);
        $imageData = $imageData[0];
        $image = $imageData['media_details']['sizes']['square-medium']['source_url'];
        $largeImage = $imageData['media_details']['sizes']['large']['source_url'];

        foreach($neighborhoods as $neighborhood_id => $neighborhood) {
            foreach($tags as $tag) {
                if($tag == $neighborhood_id) {
                    $locations[] = $neighborhoods[$neighborhood_id];
                }
            }
        }

        foreach($categories as $category_id => $categoryTemp) {
            if($postCategory == $category_id) {
                $category = $categoryTemp;
                break;
            }
        }

        if(empty($locations)) {
            $info = $category;
        } else if(count($locations) > 1) {
            $info = '<i class="material-icons">location_on</i>' . $locations[0] . ' (+' . (count($locations) - 1) . ' more)';
        } else {
            $info = $locations[0];
        }

        $postStorage[] = [
            'info' => $info,
            'date' => $dateStorage,
            'link' => $link,
            'title' => $title,
            'image' => $image,
            'large_image' => $largeImage,
            'author' => [
                'name' => $author,
                'link' => $authorLink,
            ],
            'comments' => $comments,
            'excerpt' => $excerpt,
            'content' => $content,
            'id' => $id,
        ];

        unset($locations);
    }

    $postStorage = json_encode($postStorage);
    file_put_contents('cache/' . date('d-m-Y-H') . '.json', $postStorage);
}

$data = file_get_contents('cache/' . date('d-m-Y-H') . '.json');
$data = json_decode($data, true);
foreach($data as &$post) {
    $post['date_text'] = time_elapsed_string($post['date']);
}
$data = json_encode($data);

if(isset($options)) {
    $data = json_decode($data, true);
    foreach($data as $post) {
        if($post['id'] == $options) {
            $data = $post;
        }
    }
} else {
    header('Content-type: text/json');
    print_r($data);
}
?>