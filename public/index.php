<?php
require_once "../vendor/autoload.php";

/**
 * @param $payload
 * @param null $sortBy
 * @return bool
 */
function sortEpisodes($payload, $sortBy = null) {
    array_multisort(array_keys($payload), SORT_ASC, SORT_STRING, $payload);
    return $payload;
};

/**
 * Get the episodes from the API
 * @return stdClass
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function fetchEpisodes() {
    $responseObject = new stdClass();
    $responseObject->success = false;
    $responseObject->data = [];
    $client = new GuzzleHttp\Client();
    try {
        $res = $client->request("GET", "http://3ev.org/dev-test-api/");
        $responseObject->data = json_decode($res->getBody(), true);
    } catch( \GuzzleHttp\Exception\ClientException $e) {
        throw $e;
    }

    return $responseObject;
}

/**
 * Load Twig templating environment, render the template
 * @throws Twig_Error_Loader
 * @throws Twig_Error_Runtime
 * @throws Twig_Error_Syntax
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function render() {
    $loader = new Twig_Loader_Filesystem("../templates/");
    $twig = new Twig_Environment($loader, ["debug" => true]);
    $payload = fetchEpisodes();
    $data = sortEpisodes($payload->data);
    echo $twig->render("page.html", ["episodes" => $data]);
}


render();



