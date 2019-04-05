<?php
require_once '../vendor/autoload.php';

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

//Get the episodes from the API
$client = new GuzzleHttp\Client();

// Catch errors in connections to the API
try{
    $res = $client->request('GET', 'http://3ev.org/dev-test-api/');
    
    $data = json_decode($res->getBody(), true);

    // Get values of season and episode in two seprate arrays which will be used for sorting
    $season  = array_column($data, 'season');
    $episode = array_column($data, 'episode');

    //Sort the data multi-array accroding to season and episode in ascending order respectively
    array_multisort($season, SORT_ASC, $episode, SORT_ASC, $data);
    
    //Render the template
    echo $twig->render('page.html', ["episodes" => $data]);

}catch (\Exception $e){
    $error = 'Sorry, there was an error. Please try again by reloading the page.';
    //Render the template
    echo $twig->render('page.html', ["error" => $error]);
}

