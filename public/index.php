<?php
require_once '../vendor/autoload.php';

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

//Get the episodes from the API
$client = new GuzzleHttp\Client();
$res = $client->request('GET', 'http://3ev.org/dev-test-api/');
$data = json_decode($res->getBody(), true);

//Sort the episodes
$seasons = array_column($data, 'season');
$episodes = array_column($data, 'episode');
array_multisort($seasons, SORT_ASC, $episodes, SORT_ASC, $data);

$season = 'all';
if (isset($_GET) && isset($_GET['season'])) {
    $season = $_GET['season'];
}
if ($season != 'all') {
    $data = array_filter($data, function ($row) use ($season) {
        return ($row['season'] == $season);
    });
}

//Render the template
echo $twig->render('page.html', [
    "season" => $season,
    "episodes" => $data,
    "favouriteSeasons" => array_unique($seasons)
]);
