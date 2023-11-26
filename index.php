<?php
require_once 'config.php';
require_once 'router.php';
require_once 'controllers/booksController.php';
require_once 'controllers/publishersController.php';
require_once 'controllers/commonController.php';

header('Access-Control-Allow-Origin: *');

$method = $_SERVER['REQUEST_METHOD'];

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = route($method, $path);

if ($route) {
  list($controllerName, $methodName) = explode('@', $route);

  $controller = new $controllerName();

  $id = isset($_GET['id']) ? $_GET['id'] : null;
  $name = isset($_GET['name']) ? $_GET['name'] : null;
  $query = isset($_GET['query']) ? $_GET['query'] : null;
  if ($id) {
    $controller->$methodName($mysqli, $id);
  } elseif ($name) {
    $controller->$methodName($mysqli, $name);
  } elseif ($query) {
    $controller->$methodName($mysqli, $query);
  } else {
    $controller->$methodName($mysqli);
  }
} elseif ($path === '/') {
  include './pages/index.html';
} else {
  include './pages/404/index.html';
}

$mysqli->close();
