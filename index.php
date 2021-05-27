<?php 

define('ROOT_DIR', dirname(__file__));

require realpath(ROOT_DIR.'/vendor/autoload.php');

use Magma\Application\Application;

$app =  new Application(ROOT_DIR);
$app->run()
    ->setSession()
    ->setRouteHandler();

