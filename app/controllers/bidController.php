<?php
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/Bid.php';

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
                header("Location: /items/{$itemId}");
                exit();
            }

            // Get the previous highest bidder before placing new bid
            $previousBids = $item->getBids();
            $previousHighestBid = !empty($previousBids) ? $previousBids[0] : null;
            $previousBidderId = $previousHighestBid ? $previousHighestBid['user_id'] : null;

            Bid::add($_SESSION['user_id'], $itemId, $bidAmount);

            // Notify item owner about new bid (only if bidder is not the owner)
            if ($item->user_id != $_SESSION['user_id']) {
                Notification::createBidNotification(
                    $item->owner_id,
                    $itemId,
                    $item->title,
                    $_SESSION['user_id'],
                    $_SESSION['username'],
                    $bidAmount
                );
            }

            // Notify previous highest bidder that they were outbid (if exists and not the current bidder)
            if ($previousBidderId && $previousBidderId != $_SESSION['user_id']) {
                Notification::createOutbidNotification(
                    $previousBidderId,
                    $itemId,
                    $item->title,
                    $bidAmount,
                    $_SESSION['user_id']
                );
            }

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