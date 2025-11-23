<?php
require_once __DIR__ . '/../../includes/db.php';

class Bid {
    public static function add($user_id, $item_id, $bid_amount) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO bids (user_id, item_id, bid) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $user_id, $item_id, $bid_amount);
        $stmt->execute();

        // Update current bid of item
        $stmt2 = $mysqli->prepare("UPDATE items SET current_bid=? WHERE id=?");
        $stmt2->bind_param("di", $bid_amount, $item_id);
        $stmt2->execute();

        return $mysqli->insert_id;
    }

    public static function getUserLastBids($user_id) {
        global $mysqli;
        $sql = "
            SELECT b1.item_id, b1.bid, b1.created_at
            FROM bids b1
            INNER JOIN (
                SELECT item_id, MAX(created_at) AS last_time
                FROM bids
                WHERE user_id = ?
                GROUP BY item_id
            ) b2 ON b1.item_id = b2.item_id AND b1.created_at = b2.last_time
            WHERE b1.user_id = ?
        ";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $user_id, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $bids = [];
        while ($row = $res->fetch_assoc()) {
            $bids[] = $row;
        }
        return $bids;
    }
}

?>