<?php
/** @ToDo disable before upload server */
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', __DIR__);

require_once(ROOT . '/components/Router.php');

$router = new Router();
$router->run();