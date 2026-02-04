<?php
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../../includes/flash.php';

class MyListingsContoller {
    public function handle () {
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

    public function deleteItem($itemId) {
        $item = Item::findById($itemId);

        if ($item->owner_id === $_SESSION['user_id']) {
            try{
                Item::delete($itemId);
                setFlash('success', 'Item deleted successfully');
                header('Location: /my-listings');
                exit;
            }
            catch (Exception $e) {
                setFlash('error', 'Failed to delete the item');
                header('Location: /my-listings');
                exit;
            }
        }
        setFlash('error', 'Failed to delete the item');
        header('Location: /my-listings');
        exit;
    }
}