<?php
class MyBidsController {
    public function handle() {
        require_once __DIR__ . '/../models/Item.php';
        $items = Item::getItemsUserBidOn($_SESSION['user_id']);

        $winning = 0;
        $outbid  = 0;
        $won     = 0;
        $lost    = 0;
        $totalSpent = 0;
        $totalActive = 0;
        foreach ($items as $item) {
            if ($item['item']->is_active) {
                $totalActive++;
                if ($item['is_winning']) {
                    $winning++;
                } else {
                    $outbid++;
                }
            }

            if ($item['has_won']) {
                $won++;
                $totalSpent += $item['last_bid'];
            } elseif ($item['has_lost']) {
                $lost++;
            }
        }
        require_once __DIR__ . '/../views/bids.php';
    }
}
?>