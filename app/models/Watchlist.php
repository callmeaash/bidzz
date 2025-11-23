<?php
require_once __DIR__ . '/../../includes/db.php';

class Watchlist {
    public static function add($user_id, $item_id) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT IGNORE INTO wishlists (user_id, item_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
        return $mysqli->insert_id;
    }
}

?>