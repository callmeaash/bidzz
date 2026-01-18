<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/utils.php';
require_once __DIR__ . '/../models/Notification.php';

if (!$mysqli) {
    Logger::error(basename(__FILE__), "MySQLi not initialized");
    exit;
}

$sql = "
    SELECT id, title, owner_id
    FROM items
    WHERE end_at <= NOW()
      AND is_active = 1
      AND winner_id IS NULL
";

$result = $mysqli->query($sql);

if (!$result) {
    Logger::error(basename(__FILE__), "Failed to fetch expired items", $mysqli->error);
    exit;
}

while ($item = $result->fetch_assoc()) {

    $itemId   = (int)$item['id'];
    $itemName = $item['title'];
    $ownerId  = (int)$item['owner_id'];

    $mysqli->begin_transaction();

    try {
        $winnerSql = "
            SELECT user_id, bid
            FROM bids
            WHERE item_id = ?
            ORDER BY bid DESC, created_at ASC
            LIMIT 1
        ";

        $winnerStmt = $mysqli->prepare($winnerSql);
        if (!$winnerStmt) {
            throw new Exception("Prepare failed (winner)");
        }

        $winnerStmt->bind_param("i", $itemId);
        $winnerStmt->execute();
        $winnerResult = $winnerStmt->get_result();
        $winnerRow = $winnerResult->fetch_assoc();
        $winnerStmt->close();

        $winnerId = $winnerRow ? (int)$winnerRow['user_id'] : null;
        $finalBid = $winnerRow ? (float)$winnerRow['bid'] : null;

        $updateSql = "
            UPDATE items
            SET is_active = 0,
                winner_id = ?,
                current_bid = ?
            WHERE id = ?
        ";

        $updateStmt = $mysqli->prepare($updateSql);
        if (!$updateStmt) {
            throw new Exception("Prepare failed (update)");
        }

        $updateStmt->bind_param("idi", $winnerId, $finalBid, $itemId);
        $updateStmt->execute();
        $updateStmt->close();

        if ($winnerId !== null) {
            Notification::createWonNotification(
                $winnerId,
                $itemId,
                $itemName
            );
        }

        Notification::createAuctionEndedNotification(
            $ownerId,
            $itemId,
            $itemName,
            $winnerId !== null
        );

        $mysqli->commit();

    } catch (Exception $e) {
        $mysqli->rollback();

        Logger::error(
            basename(__FILE__),
            "Failed processing item {$itemId}",
            $e->getMessage()
        );
    }
}

$mysqli->close();
