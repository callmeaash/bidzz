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
    public $winner_id;
    public $end_at;
    public $created_at;
    public $is_favorited;

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
        $this->winner_id = $row['winner_id'];
        $this->end_at = $row['end_at'];
        $this->created_at = $row['created_at'];
        $this->is_favorited = $row['is_favorited'] ?? '';
    }

    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    public static function create($owner_id, $title, $description, $category, $starting_bid, $duration, $image) {
        $mysqli = self::getDb();
        $end_at = date('Y-m-d H:i:s', strtotime("+{$duration} days"));

        $stmt = $mysqli->prepare("
            INSERT INTO items 
            (owner_id, title, description, image, category, starting_bid, end_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("issssds", $owner_id, $title, $description, $image, $category, $starting_bid, $end_at);
        
        if ($stmt->execute()) {
        return $mysqli->insert_id;
    }
    }

    public static function findById($id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new Item($res) : null;
    }

    public static function getItems($userId = null) {
        $mysqli = self::getDb();
        if ($userId) {
            $stmt = $mysqli->prepare("SELECT * FROM items WHERE owner_id = ? ORDER BY end_at ASC");
            $stmt->bind_param("i", $userId);
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

    public static function getItemsWithFavouriteStatus($userId) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT 
                items.*,
                CASE 
                    WHEN wishlists.item_id IS NOT NULL THEN 1
                    ELSE 0
                    END AS is_favorited
            FROM items
            LEFT JOIN wishlists 
            ON wishlists.item_id = items.id 
            AND wishlists.user_id = ?
        ");

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = new Item($row);
        }
        return $items;
    }

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
                "avatar" => $row['avatar'],
                "user_id" => $row['user_id'],
                "username" => $row['username'],
                "avatar" => $row['avatar'],
                "bid" => $row['bid'],
                "created_at" => $row['created_at']
            ];
        }
        return $bids;
    }

    public static function getItemsUserBidOn($user_id) {
        $mysqli = self::getDb();
        $sql = "
            SELECT 
                i.*,
                b.bid AS user_last_bid,
                b.created_at AS bid_time,

                -- User is currently winning
                CASE 
                    WHEN i.is_active = 1 AND i.current_bid = b.bid THEN 1
                    ELSE 0
                END AS is_winning,

                -- User won auction
                CASE
                    WHEN i.is_active = 0 AND i.current_bid = b.bid THEN 1
                    ELSE 0
                END AS has_won,

                -- User lost auction
                CASE
                    WHEN i.is_active = 0 AND i.current_bid <> b.bid THEN 1
                    ELSE 0
                END AS has_lost

            FROM items i
            JOIN bids b ON b.item_id = i.id
            JOIN (
                SELECT item_id, MAX(created_at) AS last_time
                FROM bids
                WHERE user_id = ?
                GROUP BY item_id
            ) lb ON lb.item_id = b.item_id AND lb.last_time = b.created_at
            WHERE b.user_id = ?
            
            ORDER BY b.created_at DESC
        ";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $user_id, $user_id);
        $stmt->execute();

        $res = $stmt->get_result();
        $items = [];

        while ($row = $res->fetch_assoc()) {
            $items[] = [
                "item"       => new Item($row),
                "last_bid"   => (float)$row['user_last_bid'],
                "bid_time"   => $row['bid_time'],
                "is_winning" => (bool)$row['is_winning'],
                "has_won"    => (bool)$row['has_won'],
                "has_lost"   => (bool)$row['has_lost'],
            ];
        }

        return $items;
    }

    // Fetch all comments for this item with user info
    public static function getComments($itemId) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT c.*, u.username, u.avatar
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.item_id = ?
            ORDER BY c.created_at DESC
        ");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $res = $stmt->get_result();
        $comments = [];
        while ($row = $res->fetch_assoc()) {
            $comments[] = [
                "user_id" => $row['user_id'],
                "avatar" => $row['avatar'],
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

    public static function getHighestBid($itemId) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT b.bid, u.username, u.id as user_id
            FROM bids b
            JOIN users u ON b.user_id = u.id
            WHERE b.item_id = ?
            ORDER BY b.bid DESC, b.created_at ASC
            LIMIT 1
        ");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($res) {
            return [
                'bid' => (float)$res['bid'],
                'username' => $res['username'],
                'user_id' => $res['user_id']
            ];
        }

        // No bids yet
        return null;
    }
}

?>