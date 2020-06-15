<?php
$data = file_get_contents('https://berkeleyside.com/wp-json/wp/v2/tags?per_page=100&page=1');
$data = json_decode($data, true);

foreach($data as $item) {
    echo "'" . $item['id'] . "' => '" . $item['name'] . "'";
    echo '<br>';
}