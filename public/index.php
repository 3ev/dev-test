<?php
require_once '../vendor/autoload.php';

session_start();

//Sorts array based on season and then episode
function cmp_episodes($a, $b) {
    if ($a["season"] == $b["season"]) {
        if ($a["episode"] == $b["episode"]) {
            return 0;
        }
        return ($a["episode"]<$b["episode"])?-1:1;
    }
    return ($a["season"]<$b["season"])?-1:1;
};

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

$cache = "";

//Get the episodes from the API
$client = new GuzzleHttp\Client();
try {
    if (isset($_SESSION["apidata"])) {
        $data = $_SESSION["apidata"];
        $cache = "Using cached data";
    } else {
        $res = $client->request('GET', 'http://3ev.org/dev-test-api/');

        $data = json_decode($res->getBody(), true);

        $_SESSION["apidata"] = $data;
    }
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    echo $twig->render( 'error.html');
}

//Sort the episodes
uasort($data,"cmp_episodes");

//Render the template
echo $twig->render('page.html', ["episodes" => $data, "cache" => $cache]);
