<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/utils.php';
require_once __DIR__ . '/../models/Notification.php';

date_default_timezone_set('Asia/Kathmandu');

Logger::error('check_ending_auctions.php', 'Cron job started', '');

try {
    if ($mysqli === null) {
        throw new Exception("Database connection not available");
    }

    $query = "
        SELECT DISTINCT 
            w.user_id,
            w.item_id,
            i.title as item_name,
            i.end_at,
            TIMESTAMPDIFF(MINUTE, NOW(), i.end_at) as minutes_remaining
        FROM wishlists w
        JOIN items i ON w.item_id = i.id
        LEFT JOIN notifications n ON (
            n.user_id = w.user_id 
            AND n.item_id = w.item_id 
            AND n.type = 'ending'
            AND n.created_at > DATE_SUB(NOW(), INTERVAL 2 HOUR)
        )
        WHERE i.is_active = TRUE
        AND i.end_at > NOW()
        AND i.end_at <= DATE_ADD(NOW(), INTERVAL 60 MINUTE)
        AND n.id IS NULL
        ORDER BY i.end_at ASC
    ";

    Logger::error('check_ending_auctions.php', 'Executing query to find ending auctions', '');
    
    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $mysqli->error);
    }

    $totalItems = $result->num_rows;
    Logger::error('check_ending_auctions.php', "Found {$totalItems} items to process", '');

    $count = 0;
    $errors = 0;

    while ($row = $result->fetch_assoc()) {
        try {
            $timeRemaining = (int)$row['minutes_remaining'];
            
            if ($timeRemaining < 0) {
                $msg = "Skipping item {$row['item_id']} (already ended)";
                Logger::error('check_ending_auctions.php', $msg, '');
                continue;
            }
            
            $notificationId = Notification::createEndingSoonNotification(
                $row['user_id'],
                $row['item_id'],
                $row['item_name'],
                $timeRemaining
            );
            
            if ($notificationId) {
                $count++;
                $msg = "Notified user {$row['user_id']} about item '{$row['item_name']}' (ends in {$timeRemaining} min)";
                echo "  - {$msg}\n";
                Logger::error('check_ending_auctions.php', $msg, '');
            } else {
                throw new Exception("Failed to create notification - returned null/false");
            }
            
        } catch (Exception $e) {
            $errors++;
            $errorMsg = "Failed to notify user {$row['user_id']} about item {$row['item_id']}";
            echo "  - ERROR: {$errorMsg} - {$e->getMessage()}\n";
            Logger::error('check_ending_auctions.php', $errorMsg, $e->getMessage());
        }
    }
    
    $summary = "Cron completed - Successfully sent: {$count}, Failed: {$errors}, Total processed: {$totalItems}";
    Logger::error('check_ending_auctions.php', $summary, '');
    
    if ($errors > 0) {
        Logger::error('check_ending_auctions.php', "Cron completed with errors", "Sent: {$count}, Failed: {$errors}");
    }

} catch (Exception $e) {
    $errorMsg = "Cron job failed: " . $e->getMessage();
    Logger::error('check_ending_auctions.php', 'FATAL: Cron job failed', $e->getMessage());
    exit(1);
}

Logger::error('check_ending_auctions.php', 'Cron job completed', '');