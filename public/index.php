<?php
require_once '../vendor/autoload.php';

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

//Get the episodes from the API
$client = new GuzzleHttp\Client();
try {
    $error = null;
    $res = $client->request('GET', 'http://3ev.org/dev-test-api/');
    $data = json_decode($res->getBody(), true);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    $data = [];
    $error = 'Sorry, there was an error. Please try again by reloading the page.';
}
//Sort the episodes
array_multisort(array_keys($data), SORT_ASC, SORT_STRING, $data);

//Render the template
echo $twig->render('page.html', [
    "episodes" => $data,
    "error" => $error
]);
