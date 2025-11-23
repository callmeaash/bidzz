<?php
require_once __DIR__ . '/../../includes/db.php';

class Comment {
    public static function add($user_id, $item_id, $comment) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO comments (user_id, item_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $item_id, $comment);
        $stmt->execute();
        return $mysqli->insert_id;
    }
}

?>