<?php
include "include.php";

$client = new Google_Client();
$client->setApplicationName('API code samples');
$client->setDeveloperKey($_ENV['API_KEY']);
$client->setAccessToken($_SESSION['accessToken']);

// Define service object for making API requests.
$service = new Google_Service_YouTube($client);

$displaySlate = $_GET['displaySlate'] == "true" ? true : false;
$queryParams = [
    'displaySlate' => $displaySlate
];

$response = $service->liveBroadcasts->control($_GET['broadcastsId'], 'snippet,contentDetails', $queryParams);

header('Location: /');
exit;