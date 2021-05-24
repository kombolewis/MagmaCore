<?php 

define('ROOT_DIR', dirname(__file__));

require realpath(ROOT_DIR.'/vendor/autoload.php');

use Magma\Application\Application;

$query = $_SERVER['REQUEST_URI'] ? ltrim($_SERVER['REQUEST_URI'],'/') : '/';

$app =  new Application(ROOT_DIR);
$app->run()
    ->setSession()
    ->setRouteHandler($query);

