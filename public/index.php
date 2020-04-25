<?php
if(!isset($_SESSION)) {
    session_start();
}

require '../config/Autoloader.php';
require '../config/dev.php';
\App\config\Autoloader::register();

$router = new \App\config\Router();
$router->run();
