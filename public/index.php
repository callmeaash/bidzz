<?php

// Starts a new session
session_start();

$requestUri = $_SERVER['REQUEST_URI'];
$uri = parse_url($requestUri, PHP_URL_PATH);
$route = trim($uri, '/');
$segments = explode('/', $route);

switch($segments[0]){
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
    
    case 'favorites':
        require_once __DIR__ . '/../app/controllers/favoritesController.php';
        (new FavoritesController())->handle();
        break;

    case 'logout':
        require_once __DIR__ . '/../app/controllers/logoutController.php';
        (new LogoutController())->handle();
        break;

    case 'items':
        $itemId = $segments[1] ?? null;
        $action = $segments[2] ?? null;
        
        if ($action === 'bid') {
            require_once __DIR__ . '/../app/controllers/bidController.php';
            (new BidController())->handle($itemId);
        } elseif ($action === 'comment') {
            require_once __DIR__ . '/../app/controllers/commentController.php';
            (new CommentController())->handle($itemId);
        
        } elseif ($action === 'get-current-bid') {
            require_once __DIR__ . '/../app/controllers/bidController.php';
            (new BidController())->currentBid($itemId);
        
        } elseif ($action === 'report') {
             require_once __DIR__ . '/../app/controllers/reportController.php';
            (new reportController())->handle($itemId);
        } else {
            require_once __DIR__ . '/../app/controllers/itemController.php';
            (new ItemController())->handle($itemId);
        }
        break;

    case 'watchlist':
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/watchlistController.php';
        (new WatchlistController())->handle();
        break;

    case 'get-watchlists':
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/watchlistController.php';
        (new WatchlistController())->getWatchlists();
        break;

    case 'my-listing':
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/myListingsController.php';
        (new MyListingsContoller())->handle();
        break;

    case 'my-bids':
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/myBidsController.php';
        (new MyBidsController())->handle();
        break;

    case 'me':
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/userController.php';
        (new UserController())->handle();
        break;
        
    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}