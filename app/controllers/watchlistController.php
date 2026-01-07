<?php 

class WatchlistController {

    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../models/Watchlist.php';
            try {
                $items = Watchlist::getItemsByUser($_SESSION['user_id']);

            } catch (Exception $e) {
                require_once __DIR__ . '/../../includes/utils.php';
                Logger::error(basename(__FILE__), "Couldnt fetch watchlists", $e);
            }
            require_once __DIR__ . '/../views/watchlist.php';
            exit;
        }
    }

    public function getWatchlists() {
        require_once __DIR__ . '/../models/Watchlist.php';
        try {
            $items = Watchlist::getItemsByUser($_SESSION['user_id']);
        } catch (Exception $e) {
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error(basename(__FILE__), "Couldnt fetch watchlists", $e);
        }
        header("application/json");
        echo json_encode($items);
        exit;
    }
}