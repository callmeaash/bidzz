<?php
require_once __DIR__ . '/../models/Item.php';

class BidController {
    public function handle($itemId) {

        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            try {
                $item = Item::findById($itemId);
                $bids = $item->getBids();

                header('Content-Type: application/json');
                echo json_encode($bids);
                exit;
            
            } catch (Exception $e) {
                require_once __DIR__ . '/../../includes/utils.php';
                Logger::error(basename(__FILE__), 'Failed to fetch item or bids');
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bidAmount = trim($_POST['bid-amount']) ?? '';

            $item = Item::findbyId((int)$itemId);

            if ($bidAmount === '' || $bidAmount <= $item->current_bid){
                $_SESSION['invalidBid'] = true;
            }

            require_once __DIR__ . '/../models/Bid.php';
            Bid::add($_SESSION['user_id'], $itemId, $bidAmount);


            header("Location: /items/{$itemId}");

            exit;
        }
    }

    public function currentBid($itemId) {
        $item = Item::findById($itemId);
        header('Content-Type: application/json');
        if(!$item->current_bid) {
            echo json_encode(['newBid' => $item->starting_bid]);
        }
        else {
            echo json_encode(['newBid' => $item->current_bid]);
        }
        exit;
    }
}