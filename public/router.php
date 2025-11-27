<?php
$requestUri = $_SERVER['REQUEST_URI'];
$uri = parse_url($requestUri, PHP_URL_PATH);
$route = rtrim($uri, '/');

if ($route === '') {
    $route = 'home';
}

switch($route){
    case '/register':
        require __DIR__ . '/../app/controllers/registerController.php';
        (new RegisterController())->handle();
        break;
}

?>