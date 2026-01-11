<?php
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/Notification.php';

class CommentController {
    public function handle($itemId) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $input = file_get_contents('php://input');

            $data = json_decode($input, true);

            $commentText = $data['comment'] ?? null;

            Comment::add($_SESSION['user_id'], $itemId, $commentText);

            $item = Item::findById($itemId);
            if ($item && $item->owner_id != $_SESSION['user_id']) {
                Notification::createCommentNotification(
                    $item->owner_id,
                    $itemId,
                    $item->title,
                    $_SESSION['user_id'],
                    $_SESSION['username']
                );
            }
            
            $comments = Item::getComments($itemId);
            echo json_encode($comments);
            exit;
        }

        $comments = Item::getComments($itemId);
        echo json_encode($comments);
        exit;
    }
}