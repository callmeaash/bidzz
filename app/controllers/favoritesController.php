<?php

class FavoritesController {
    public function handle() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        $itemId = $input['itemId'];
        $userId = $_SESSION['user_id'];
        $isFavorited = $input['isFavorited'];

        require_once __DIR__ . '/../models/watchlist.php';

        if ($isFavorited) {
            Watchlist::remove($userId, $itemId);
        }

        if (!$isFavorited) {
            Watchlist::add($userId, $itemId);
        }
        
        exit;

    }
}