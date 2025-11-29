<?php

// Starts a new session
session_start();

$requestUri = $_SERVER['REQUEST_URI'];
$uri = parse_url($requestUri, PHP_URL_PATH);
$route = trim($uri, '/');

switch($route){
    case 'register':
        require_once __DIR__ . '/../app/controllers/registerController.php';
        (new RegisterController())->handle();
        break;

    case 'login':
        require_once __DIR__ . '/../app/controllers/loginController.php';
        (new LoginController())->handle();
        break;

    case '':
        echo "hello";
}

?>