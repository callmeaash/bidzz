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

    case 'check-username':
        require_once __DIR__ . '/../app/controllers/ajaxController.php';
        require_once __DIR__ . '/../includes/db.php';
        (new AjaxController())->checkUsername();
        break;

    case '':
    case 'index':
        require_once __DIR__ . '/../app/controllers/indexController.php';
        (new IndexController())->handle();
        break;

    case 'listing':
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/listingController.php';
        (new ListingController())->handle();
        break;
    
    
    case 'favorites/toggle':
        require_once __DIR__ . '/../app/controllers/favoritesController.php';
        (new FavoritesController())->handle();
        break;

    case 'logout':
        require_once __DIR__ . '/../app/controllers/logoutController.php';
        (new LogoutController())->handle();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}