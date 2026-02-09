<?php
require_once __DIR__ . '/../../includes/db.php';

class Bid {
    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    public static function add($user_id, $item_id, $bid_amount) {
        $mysqli = self::getDb();
        try {
            $mysqli->begin_transaction();

            $stmt = $mysqli->prepare("INSERT INTO bids (user_id, item_id, bid) VALUES (?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param("iid", $user_id, $item_id, $bid_amount);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $bid_id = $mysqli->insert_id;
            $stmt->close();

            $stmt2 = $mysqli->prepare("UPDATE items SET current_bid=? WHERE id=?");
            if (!$stmt2) {
                throw new Exception("Prepare failed: " . $mysqli->error);
            }
            $stmt2->bind_param("di", $bid_amount, $item_id);
            if (!$stmt2->execute()) {
                throw new Exception("Execute failed: " . $stmt2->error);
            }
            $stmt2->close();

            $mysqli->commit();
            return $bid_id;

        } catch (Exception $e) {
            $mysqli->rollback();
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error("Bid.php", "Failed to add bid for user {$user_id}", $e->getMessage());
            throw $e;
        }
    }

    public static function getUserLastBids($user_id) {
        $mysqli = self::getDb();
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