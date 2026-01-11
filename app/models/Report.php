<?php
require_once __DIR__ . '/../../includes/db.php';

class Report {

    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    public static function getAll() {
        $mysqli = self::getDb();
        
        $sql = "
            SELECT 
                r.*, 
                u.username AS reporter_username, 
                u.avatar AS reporter_avatar,
                i.title AS item_title,
                i.image AS item_image,
                i.current_bid AS item_current_bid
            FROM reports r
            JOIN users u ON r.reporter_id = u.id
            JOIN items i ON r.target_id = i.id
            ORDER BY r.created_at DESC
        ";
        
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function add($reporter_id, $target_id, $reason, $message = null) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("INSERT INTO reports (reporter_id, target_id, reason, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $reporter_id, $target_id, $reason, $message);
        $stmt->execute();
        return $mysqli->insert_id;
    }

    // Get a report by ID
    public static function getById($id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM reports WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update report status
    public static function updateStatus($id, $status) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("UPDATE reports SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}
?>
