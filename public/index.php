<?php
require_once '../vendor/autoload.php';

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

$page_data = EpisodeLoader::create()->run();

//Render the template
echo $twig->render('page.html', $page_data->getData());
