<?php

class ItemController {

    public function handle($itemId) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            require_once __DIR__ . '/../models/Item.php';
            require_once __DIR__ . '/../models/Watchlist.php';
            require_once __DIR__ . '/../models/User.php';

            $invalidBid = $_SESSION['invalidBid'] ?? false;
            unset($_SESSION['invalidBid']);
            $item = Item::findbyId((int)$itemId);
            if(isset($_SESSION['user_id'])){
                $item->is_favorited = Watchlist::search($_SESSION['user_id'], (int)$itemId);
            }
            $seller = User::findById($item->owner_id);
            if(!$item->is_active){
                $winner = User::findById($item->winner_id);
            }
            require_once __DIR__ . '/../views/item.php';
        exit;
        }
    }
}