<?php
require_once __DIR__ . '/../../includes/db.php';

class Notification {

    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    // Create a new notification
    public static function create($user_id, $type, $title, $message, $item_id, $item_name, $triggered_by_user_id = null) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            INSERT INTO notifications 
            (user_id, type, title, message, item_id, item_name, triggered_by_user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $mysqli->error);
        }
        
        $stmt->bind_param("isssisi", $user_id, $type, $title, $message, $item_id, $item_name, $triggered_by_user_id);
        if ($stmt->execute()) {
            return $mysqli->insert_id;
        }
        
        throw new Exception("Failed to create notification: " . $mysqli->error);
    }

    // Get a notification by ID
    public static function getById($id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Get all notifications for a user
    public static function getByUserId($user_id, $limit = 50) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT * FROM notifications 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->bind_param("ii", $user_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get unread notifications for a user
    public static function getUnreadByUserId($user_id, $limit = 50) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT * FROM notifications 
            WHERE user_id = ? AND is_read = FALSE 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->bind_param("ii", $user_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get unread count for a user
    public static function getUnreadCount($user_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            SELECT COUNT(*) as count 
            FROM notifications 
            WHERE user_id = ? AND is_read = FALSE
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    
    // Mark a notification as read
    public static function markAsRead($id, $user_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            UPDATE notifications 
            SET is_read = TRUE, read_at = NOW() 
            WHERE id = ? AND user_id = ?
        ");
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    // Mark all notifications as read for a user
    public static function markAllAsRead($user_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("
            UPDATE notifications 
            SET is_read = TRUE, read_at = NOW() 
            WHERE user_id = ? AND is_read = FALSE
        ");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    // Delete a notification
    public static function delete($id, $user_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    // Delete all notifications for a user
    public static function deleteAll($user_id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("DELETE FROM notifications WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    // Helper methods for creating specific notification types

    // Create a bid notification
    public static function createBidNotification($item_owner_id, $item_id, $item_name, $bidder_id, $bidder_username, $bid_amount) {
        return self::create(
            $item_owner_id,
            'bid',
            'New Bid on Your Item',
            "$bidder_username placed a bid of $" . number_format($bid_amount),
            $item_id,
            $item_name,
            $bidder_id
        );
    }

    // Create a comment notification
    public static function createCommentNotification($item_owner_id, $item_id, $item_name, $commenter_id, $commenter_username) {
        return self::create(
            $item_owner_id,
            'comment',
            'New Comment on Your Item',
            "$commenter_username commented on your auction",
            $item_id,
            $item_name,
            $commenter_id
        );
    }

    // Create an outbid notification
    public static function createOutbidNotification($user_id, $item_id, $item_name, $new_bid_amount, $new_bidder_id = null) {
        return self::create(
            $user_id,
            'outbid',
            'You Were Outbid',
            "Someone placed a higher bid of $" . number_format($new_bid_amount),
            $item_id,
            $item_name,
            $new_bidder_id
        );
    }

    // Create an ending soon notification
    public static function createEndingSoonNotification($user_id, $item_id, $item_name, $time_remaining) {
        return self::create(
            $user_id,
            'ending',
            'Watchlist Item Ending Soon',
            "This auction ends in $time_remaining minutes",
            $item_id,
            $item_name,
            null
        );
    }

    public static function createWonNotification($winner_id, $item_id, $item_name) {
        return self::create(
            $winner_id,
            'won',
            'You Won the Auction!',
            "Congratulations! You won the auction.",
            $item_id,
            $item_name,
            null
        );
    }

    public static function createAuctionEndedNotification($seller_id, $item_id, $item_name, $hasWinner = true) {
    $message = $hasWinner
        ? "Your item has been sold."
        : "Your item ended with no bids.";

    return self::create(
        $seller_id,
        'ended',
        'Auction Ended',
        $message,
        $item_id,
        $item_name,
        null
    );
}
}
?>