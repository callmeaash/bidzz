<?php
require_once __DIR__ . '/../../includes/db.php';

class Item {
    public $id;
    public $owner_id;
    public $title;
    public $description;
    public $image;
    public $category;
    public $starting_bid;
    public $current_bid;
    public $is_active;
    public $end_at;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->owner_id = $row['owner_id'];
        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->image = $row['image'];
        $this->category = $row['category'];
        $this->starting_bid = $row['starting_bid'];
        $this->current_bid = $row['current_bid'];
        $this->is_active = $row['is_active'];
        $this->end_at = $row['end_at'];
    }

    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    public static function findById($id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new Item($res) : null;
    }

    public static function getItems($search = null) {
        $mysqli = self::getDb();
        if ($search) {
            $search = "%$search%";
            $stmt = $mysqli->prepare("SELECT * FROM items WHERE title LIKE ? OR description LIKE ? ORDER BY end_at ASC");
            $stmt->bind_param("ss", $search, $search);
        } else {
            $stmt = $mysqli->prepare("SELECT * FROM items ORDER BY end_at ASC");
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Item($row);
        }
        return $items;
    }

    public static function create($owner_id, $title, $description, $category, $starting_bid, $days, $image) {
        $mysqli = self::getDb();
        $end_at = date('Y-m-d H:i:s', strtotime("+$days days"));
        $stmt = $mysqli->prepare("INSERT INTO items (owner_id, title, description, category, starting_bid, current_bid, image, end_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssddss", $owner_id, $title, $description, $category, $starting_bid, $starting_bid, $image, $end_at);
        $stmt->execute();
        return $mysqli->insert_id;
    }

    // Fetch all bids for this item with user info
    public function getBids() {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT b.*, u.username, u.avatar
            FROM bids b
            JOIN users u ON b.user_id = u.id
            WHERE b.item_id = ?
            ORDER BY b.created_at DESC
        ");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $res = $stmt->get_result();
        $bids = [];
        while ($row = $res->fetch_assoc()) {
            $bids[] = [
                "user_id" => $row['user_id'],
                "username" => $row['username'],
                "avatar" => $row['avatar'],
                "bid" => $row['bid'],
                "created_at" => $row['created_at']
            ];
        }
        return $bids;
    }

    // Fetch all comments for this item with user info
    public function getComments() {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT c.*, u.username, u.avatar
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.item_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $res = $stmt->get_result();
        $comments = [];
        while ($row = $res->fetch_assoc()) {
            $comments[] = [
                "user_id" => $row['user_id'],
                "username" => $row['username'],
                "avatar" => $row['avatar'],
                "comment" => $row['comment'],
                "created_at" => $row['created_at']
            ];
        }
        return $comments;
    }

    public function getBidsCount() {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT COUNT(*) as total_bids FROM bids
            WHERE item_id = ?
        ");
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int)$res['total_bids'];
    }

    public static function delete($item_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            DELETE FROM items WHERE id = ?
        ");
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
    }
}

?>