<?php
require_once 'db.php';

class User {
    public $id;
    public $username;
    public $password;
    public $email;
    public $avatar;
    public $is_admin;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->avatar = $row['avatar'];
        $this->is_admin = $row['is_admin'];
    }

    public static function findByEmail($email) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new User($res) : null;
    }

    public static function findByUsername($username) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new User($res) : null;
    }

    public static function findById($id) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new User($res) : null;
    }

    public static function create($username, $email, $password) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
        return $mysqli->insert_id;
    }
}

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

class Comment {
    public static function add($user_id, $item_id, $comment) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO comments (user_id, item_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $item_id, $comment);
        $stmt->execute();
        return $mysqli->insert_id;
    }
}

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
