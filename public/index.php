<?php

use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Kevinrob\GuzzleCache\Storage\FlysystemStorage;
use League\Flysystem\Adapter\Local;

require_once '../vendor/autoload.php';

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

// Create default HandlerStack
$handlerStack = HandlerStack::create();
$handlerStack->push(
    new CacheMiddleware(
        new GreedyCacheStrategy(
            new FlysystemStorage(
                new Local('../cache')
            ),
            5 //ttl in seconds
        )
    ),
    'greedy-cache'
);
$client = new GuzzleHttp\Client([
    'base_uri' => 'http://3ev.org',
    'handler' => $handlerStack
]);
try {
    $error = null;
    //Get the episodes from the API
    $response = $client->request('GET', 'dev-test-api');
    $data = json_decode($response->getBody(), true);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    $data = [];
    $error = 'Sorry, there was an error. Please try again by reloading the page.';
}
//Sort the episodes
$seasons = array_column($data, 'season');
$episodes = array_column($data, 'episode');
array_multisort($seasons, SORT_ASC, $episodes, SORT_ASC, $data);

//Render the template
try {
    echo $twig->render('page.html', [
        "episodes" => $data,
        "error" => $error
    ]);
} catch (\Twig\Error\LoaderError $e) {
    //
} catch (\Twig\Error\RuntimeError $e) {
    //
} catch (\Twig\Error\SyntaxError $e) {
    //
}
