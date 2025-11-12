<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/models.php';
require_once '../includes/auth.php';

requireUserOrAdmin();
$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);
$item_id = intval($data['item_id']);
$comment_text = trim($data['comment']);

if (!$comment_text) {
    http_response_code(400);
    echo json_encode(["error" => "Comment cannot be empty"]);
    exit;
}

$comment_id = Comment::add($user_id, $item_id, $comment_text);
echo json_encode(["message" => "Comment added", "comment_id" => $comment_id]);
?>
