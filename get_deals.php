<?php
$deals = [
    '1111' => [
        'title' => 'Two scoops for thrice the price of one',
        'expires' => '3:30 PM',
        'venue' => 'iScream Ice Cream',
        'address' => [
            'street' => '1819 Solano Avenue',
            'city' => 'Berkeley, CA 94707'
        ],
        'image' => 'http://localhost:10018/berkeleyside-app/deals/iscream.jpg',
        'color' => 'teal'
    ],
    '2222' => [
        'title' => 'Buy one burger for the price of two and get one free',
        'expires' => 'Tomorrow',
        'venue' => 'Barney\'s Gormet Hamburgers',
        'address' => 'Multiple Locations',
        'image' => 'http://localhost:10018/berkeleyside-app/deals/barneys.jpg',
        'color' => 'blue'
    ],
    '3333' => [
        'title' => 'Buy one restaurant, get one restaurant',
        'expires' => 'June 17',
        'venue' => 'Lalime\'s',
        'address' => [
            'street' => '1329 Gilman Street',
            'city' => 'Berkeley, CA 94706',
            'image' => 'http://localhost:10018/berkeleyside-app/deals/lalimes.png'
        ],
        'color' => 'orange'
    ],
    '3333' => [
        'title' => '0.07% off our cheapest drink or food item',
        'expires' => 'June 20',
        'venue' => 'Purple Kow',
        'address' => [
            'street' => '2164 Center Street',
            'city' => 'Berkeley, CA 94704'
        ],
        'image' => 'http://localhost:10018/berkeleyside-app/deals/purple_kow.jpg',
        'color' => 'dark-blue'
    ],
    '4444' => [
        'title' => 'All expired food items now only $2.00 each',
        'expires' => 'July 4',
        'venue' => 'The Dollar Store',
        'address' => [
            'street' => '1284 San Pablo Avenue',
            'city' => 'Berkeley, CA 94706'
        ],
        'image' => 'http://localhost:10018/berkeleyside-app/deals/dollar_store.jpg',
        'color' => 'red'
    ],
];

header('Content-type: text/json');

if( !empty( $_POST['deal_id'] ) ) {
    $deals = $deals[$_POST['deal_id']];
}

$deals = json_encode($deals);
print_r($deals);