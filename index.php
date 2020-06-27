
<?php
    include "include.php";

    $client = new Google_Client();
    $client->setApplicationName('API code samples');
    $client->setScopes([
        'https://www.googleapis.com/auth/youtube',
        'https://www.googleapis.com/auth/youtubepartner',
    ]);

    $client->setAuthConfig($_ENV['JSON_FILE']);
    $client->setAccessType('offline');
    $response = null;
    if(!isset($_SESSION['accessToken'])){
        $authUrl = $client->createAuthUrl();
    }else{
        $client->setAccessToken($_SESSION['accessToken']);

        // Define service object for making API requests.
        $service = new Google_Service_YouTube($client);

        $queryParams = [
            'broadcastType' => 'all',
            'mine' => true
        ];

        $response = $service->liveBroadcasts->listLiveBroadcasts('snippet,contentDetails,status', $queryParams);
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Album example · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
  </head>
  <body>
    <header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        <strong>Album</strong>
      </a>
    </div>
  </div>
</header>

<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>Google Login</h1>
      <p class="lead text-muted">login with account with access to youtube live.</p>
      <?php if(!$response){ ?>
      <p>
        <a href="<?= $authUrl ?>" class="btn btn-primary my-2">login</a>
      </p>
      <?php } ?>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row">
      <?php if($response){ ?>
      <?php foreach ($response->items as $item) {  if($item->status->lifeCycleStatus != 'live'){ continue;} ?>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="<?= $item->snippet->thumbnails->standard->url ?>" alt="" class="bd-placeholder-img card-img-top" />
            <div class="card-body">
              <p class="card-text">
              <?= $item->id ?> (<?= $item->status->lifeCycleStatus ?>)
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><?= $item->snippet->title ?></small>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <a href="/liveBroadcasts.php?broadcastsId=<?= $item->id ?>&displaySlate=true" class="btn btn-danger btn-sm">Enable a slate</a>
                <a href="/liveBroadcasts.php?broadcastsId=<?= $item->id ?>&displaySlate=false" class="btn btn-success btn-sm">Disable a slate</a>
                <a href="/liveCuepoints.php?broadcastsId=<?= $item->id ?>" class="btn btn-success btn-sm">Add ads</a>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php } ?>
      </div>
    </div>
  </div>

</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script></body>
</html>
