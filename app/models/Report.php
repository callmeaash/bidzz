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

    // Delete a report
    public static function delete($id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("DELETE FROM reports WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
