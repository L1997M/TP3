<?php
require_once './libs/Router.php';
require_once './controlador/discoControllerApi.php';
require_once './controlador/userControllerApi.php';


// crea el router
$router = new Router();

// define la tabla de ruteo
$router->addRoute('discos', 'GET', 'discoControllerApi', 'obtenerDiscos');
$router->addRoute('discos', 'POST', 'discoControllerApi', 'insertarDisco');
$router->addRoute('discos/:ID', 'GET', 'discoControllerApi', 'obtenerDisco');
$router->addRoute('discos/:ID', 'PUT', 'discoControllerApi', 'modificarDisco');
 # UserApiController->getToken()
$router->addRoute("auth/token", "GET", "userControllerApi", "getToken");

// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


        


