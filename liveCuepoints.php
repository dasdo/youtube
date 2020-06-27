<?php
include "include.php";

$client = new GuzzleHttp\Client();
$bearer = 'Bearer '.$_SESSION['accessToken']['access_token'];
try {
    $response = $client->post('https://www.googleapis.com/youtube/partner/v1/liveCuepoints', [
        'form_params' => [
            'broadcastId' => $_GET['broadcastsId'],
            'settings' => [
                'cueType' => 'ad',
                'durationSecs' => 15,
            ]
        ],
        'headers' => [
            'Authorization' => $bearer
        ]
    ]);
    
    $body = $response->getBody();
    dump($body);
} catch (\Exception $e) {
    dump($e);
}
