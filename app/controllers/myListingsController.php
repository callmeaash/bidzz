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
        header('Content-Type: application/json');
        $item = Item::findById($itemId);

        if (!$item) {
            echo json_encode(['success' => false, 'message' => 'Item not found']);
            exit;
        }

        if ($item->owner_id !== (int)$_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'You do not have permission to delete this item']);
            exit;
        }

        try {
            Item::delete($itemId);
            
            echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
            exit;

        } catch (Exception $e) {
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error(basename(__FILE__), 'Failed to delete item: ' . $itemId, $e->getMessage());
            
            echo json_encode(['success' => false, 'message' => 'Failed to delete the item']);
            exit;
        }
    }

}