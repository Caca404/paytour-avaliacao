<?php

use App\Router\Router;

require_once 'vendor/autoload.php';

$router = new Router();

if($_SERVER['REQUEST_METHOD'] === 'POST') echo $router->findRoute($_POST['urlFunction']);
else header("HTTP/1.0 405 Method Not Allowed");