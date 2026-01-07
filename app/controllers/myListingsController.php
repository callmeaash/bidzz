<?php

class MyListingsContoller {
    public function handle () {
        require_once __DIR__ . '/../models/Item.php';
        $items = Item::getItems($_SESSION['user_id']);
        $totalRevenue = 0;
        $totalBids = 0;
        $totalActive = 0;
        $totalInactive = 0;
        foreach ($items as $item) {
            if (!$item->is_active){
                $totalRevenue = $totalRevenue + $item->current_bid;
            }

            $totalBids = $totalBids + count($item->getBids());

            if ($item->is_active) {
                $totalActive++;
            } else {
                $totalInactive++;
            }

        }
        require_once __DIR__ . '/../views/listings.php';
        exit;
    }
}