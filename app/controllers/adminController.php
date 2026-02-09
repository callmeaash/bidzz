<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/Report.php';
require_once __DIR__ . '/../../includes/utils.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../../includes/db.php';


class AdminController {
    public function handle() {
        $users = User::findAll();
        $items = Item::getItems();
        $reports = Report::getAll();
        
        $totalActive = 0;
        $totalInactive = 0;
        $totalBids = 0;
        $totalSpend = 0;

        foreach ($items as $item) {
            if ($item->is_active) $totalActive++;
            else $totalInactive++;

            $totalBids += count($item->getBids());
            if (!$item->is_active) $totalSpend += $item->current_bid;
        }

        $averageSpend = $totalSpend / $totalInactive;
        $totalPendingReport = 0;
        $totalReport = 0;

        foreach ($reports as $report) {
            $totalReport++;
            if ($report['status'] == 'pending') $totalPendingReport++;
        }

        require_once __DIR__ . '/../views/admin.php';
    }

    public function toggleUserStatus() {
        $userId = $_POST['user_id'] ?? null;

        $user = User::findById((int)$userId);
        $newStatus = !$user->is_active;

        User::toggleUserStatus($userId, $newStatus);
        echo json_encode([
            'success' => true,
            'is_active' => (bool)$newStatus
        ]);
        exit;
    }

    public function deleteUser($userId) {
        User::delete($userId);

        echo json_encode([
            'success' => true
        ]);
    }

    public function deleteItem($itemId) {
        Item::delete($itemId);

        echo json_encode([
            'success' => true
        ]);
    }

    public function updateReportStatus() {
        $reportId = trim($_POST['report_id']);
        $status = trim($_POST['status']);

        Report::updateStatus($reportId, $status);

        echo json_encode([
            'success' => true
        ]);
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function endAuction($itemId) {

        $item = Item::findById($itemId);

        $itemName = $item['title'];
        $ownerId  = (int)$item['owner_id'];

        try {
            $highestBid = Item::getHighestBid($itemId);
            $winnerId = (int) $highestBid['user_id'] ?? null;
            $finalBid = (float) $highestBid['bid'] ?? null;
            $updateSql = "
                UPDATE items
                SET is_active = 0,
                    end_at = NOW(),
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

            if ($highestBid) {
                Notification::createWonNotification(
                    $highestBid['user_id'],
                    $itemId,
                    $itemName
                );
            }

            Notification::createAuctionEndedNotification(
                $item->owner_id,
                $item->id,
                $item->title,
                $highestBid !== null
            );

            echo json_encode([
                'success' => true,
                'message' => 'Auction ended successfully'
            ]);

        } catch (Exception $e) {

            Logger::error(
                basename(__FILE__),
                "Failed ending item {$itemId}",
                $e->getMessage()
            );

            echo json_encode([
                'success' => false,
                'message' => 'Failed to end auction'
            ]);
        }

    }
}