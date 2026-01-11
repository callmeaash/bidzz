<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/Report.php';

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
}