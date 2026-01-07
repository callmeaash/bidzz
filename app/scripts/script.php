<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/utils.php';

if (!$mysqli) {
    Logger::error(basename(__FILE__), "MySQLi not initialized");
    exit;
}

$sql = "
    SELECT id
    FROM items
    WHERE end_at <= NOW()
";

$result = $mysqli->query($sql);

if (!$result) {
    Logger::error(basename(__FILE__), "Failed to fetch expired items", $mysqli->error);
    exit;
}

while ($item = $result->fetch_assoc()) {
    $itemId = (int)$item['id'];

    $winnerSql = "
        SELECT user_id
        FROM bids
        WHERE item_id = ?
        ORDER BY bid DESC, created_at ASC
        LIMIT 1
    ";

    $winnerStmt = $mysqli->prepare($winnerSql);
    if (!$winnerStmt) {
        Logger::error(basename(__FILE__), "Prepare failed (winner)", $mysqli->error);
        continue;
    }

    $winnerStmt->bind_param("i", $itemId);
    $winnerStmt->execute();
    $winnerResult = $winnerStmt->get_result();
    $winnerRow = $winnerResult->fetch_assoc();
    $winnerStmt->close();

    $winnerId = $winnerRow ? (int)$winnerRow['user_id'] : NULL;

    $updateSql = "
        UPDATE items
        SET is_active = 0,
            winner_id = ?
        WHERE id = ?
    ";

    $updateStmt = $mysqli->prepare($updateSql);
    if (!$updateStmt) {
        Logger::error(basename(__FILE__), "Prepare failed (update)", $mysqli->error);
        continue;
    }

    if ($winnerId === NULL) {
        $updateStmt->bind_param("si", $winnerId, $itemId);
    } else {
        $updateStmt->bind_param("ii", $winnerId, $itemId);
    }

    if (!$updateStmt->execute()) {
        Logger::error(
            basename(__FILE__),
            "Failed to update item {$itemId}",
            $updateStmt->error
        );
    }

    $updateStmt->close();
}

$mysqli->close();
