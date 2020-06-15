<?php
$options = $_POST['post_id']; // post id
require('get_posts.php');
// $data is now available

$data = [
    'title' => html_entity_decode($data['title']),
    'date' => date('F j, Y', strtotime($data['date'])),
    'link' => $data['link'],
    'image' => $data['large_image'],
    'author' => $data['author']['name'],
    'author_link' => $data['author']['link'],
    'content' => $data['content'],
    'info' => $data['info']
];

$data = json_encode($data);

header('Content-type: text/json');
print_r($data);