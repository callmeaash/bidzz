<?php
require_once __DIR__ . '/../models/Notification.php';

class NotificationController {

    public function getNotifications() {

        $notifications = Notification::getByUserId($_SESSION['user_id']);

        header('Content-Type: application/json');
        echo json_encode($notifications);
        exit;
    }

    public function markRead($notifID) {
        $success = Notification::markAsRead($notifID, $_SESSION['user_id']);
    }

    public function deleteNotification($notifID) {
        $success = Notification::delete($notifID, $_SESSION['user_id']);
    }

    public function deleteAll() {
        $success = Notification::deleteAll($_SESSION['user_id']);
    }

    public function readAll() {
        $success = Notification::markAllAsRead($_SESSION['user_id']);
    }
}