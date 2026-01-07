<?php
require_once __DIR__ . '/../../includes/db.php';

class Watchlist {

    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    public static function add($user_id, $item_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("INSERT IGNORE INTO wishlists (user_id, item_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
        return $mysqli->insert_id;
    }

    public static function remove ($user_id, $item_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("DELETE FROM wishlists WHERE user_id = ? AND item_id = ?");
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
    }

    public static function search($user_id, $item_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM wishlists WHERE user_id = ? AND item_id = ?");
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows === 0 ? false : true;
    }

    public static function getItemsByUser($user_id) {
        require_once __DIR__ . '/Item.php';
        $mysqli = self::getDb();

        $stmt = $mysqli->prepare("
            SELECT i.*
            FROM wishlists w
            JOIN items i ON w.item_id = i.id
            WHERE w.user_id = ?
        ");

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Item($row);
        }

        return $items;
    }
}

?>