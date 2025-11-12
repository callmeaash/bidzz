<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/models.php';
require_once '../includes/auth.php';

requireUserOrAdmin();
$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);
$item_id = intval($data['item_id']);

Watchlist::add($user_id, $item_id);
echo json_encode(["message" => "Item added to watchlist"]);
?>
