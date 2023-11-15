<?php
require_once 'config.php';
require_once 'router.php';
require_once 'controllers/booksController.php';
require_once 'controllers/publishersController.php';

// Definindo o cabeçalho para aceitar requisições de qualquer origem (CORS)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Verificando o método da requisição e o caminho da rota
$method = $_SERVER['REQUEST_METHOD'];

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = route($method, $path);

if ($route) {
    list($controllerName, $methodName) = explode('@', $route);

    $controller = new $controllerName();

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $name = isset($_GET['name']) ? $_GET['name'] : null;
    if ($id) {
        $controller->$methodName($mysqli, $id);
    } elseif ($name) {
        $controller->$methodName($mysqli, $name);
    } else {
        $controller->$methodName($mysqli);
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['erro' => 'Página não encontrada']);
}

$mysqli->close();
?>
