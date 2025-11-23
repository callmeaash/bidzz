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

    public static function findById($id) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new Item($res) : null;
    }

    public static function getActiveItems($search = null) {
        global $mysqli;
        if ($search) {
            $search = "%$search%";
            $stmt = $mysqli->prepare("SELECT * FROM items WHERE is_active=1 AND (title LIKE ? OR description LIKE ?) ORDER BY end_at ASC");
            $stmt->bind_param("ss", $search, $search);
        } else {
            $stmt = $mysqli->prepare("SELECT * FROM items WHERE is_active=1 ORDER BY end_at ASC");
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
        global $mysqli;
        $end_at = date('Y-m-d H:i:s', strtotime("+$days days"));
        $stmt = $mysqli->prepare("INSERT INTO items (owner_id, title, description, category, starting_bid, current_bid, image, end_at) VALUES (?, ?, ?, ?, ?, NULL, ?, ?)");
        $stmt->bind_param("isssdss", $owner_id, $title, $description, $category, $starting_bid, $image, $end_at);
        $stmt->execute();
        return $mysqli->insert_id;
    }

    // Fetch all bids for this item with user info
    public function getBids() {
        global $mysqli;
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
        global $mysqli;
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
}

?>