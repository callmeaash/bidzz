<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    case 'watchlists':
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

    case 'my-listings':
        $itemId = $segments[1] ?? null;
        $action = $segments[2] ?? null;
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/myListingsController.php';

        if ($action === 'delete'){
            (new MyListingsContoller())->deleteItem($itemId);
            break;
        }
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
    
    
    case 'notifications':
        $action = $segments[1] ?? null;
        $notifID = $segments[2] ?? null;
        require_once __DIR__ . '/../includes/auth.php';
        requireLogin();
        require_once __DIR__ . '/../app/controllers/notificationController.php';

        if ($action == 'get-notifications') {
            (new NotificationController())->getNotifications();
        }
        elseif ($action == 'mark-read') {
            (new NotificationController())->markRead($notifID);
        }
        elseif ($action == 'delete') {
            (new NotificationController())->deleteNotification($notifID);
        }
        elseif ($action == 'delete-all') {
            (new NotificationController())->deleteAll();
        }
        elseif ($action == 'read-all') {
            (new NotificationController())->readAll();
        }
        break;
    
    case 'admin':
        require_once __DIR__ . '/../includes/auth.php';
        require_once __DIR__ . '/../app/controllers/adminController.php';
        $action = $segments[1] ?? null;
        $Id = $segments[2] ?? null;
        requireAdminLogin();

        if ($action == 'toggle-user-status') {
            (new AdminController())->toggleUserStatus();
        }
        elseif ($action == 'delete-user') {
            (new AdminController())->deleteUser($Id);
        }
        elseif ($action == 'delete-item') {
            (new AdminController())->deleteItem($Id);
        }
        elseif ($action == 'resolve-report') {
            (new AdminController())->updateReportStatus();
        }
        elseif ($action == 'logout') {
            (new AdminController())->logout();
        }
        elseif ($action == 'end-auction') {
            (new AdminController())->endAuction($Id);
        }
        else {
            (new AdminController())->handle();
        }
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}