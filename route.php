<?php

use App\Router\Router;

require_once 'vendor/autoload.php';

$router = new Router();

if(isset($_POST)) echo $router->findRoute($_POST['urlFunction']);
else throw new \Exception("Metodo negado.", 405);