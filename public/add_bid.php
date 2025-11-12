<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/models.php';
require_once '../includes/auth.php';

requireUserOrAdmin();
$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);
$item_id = intval($data['item_id']);
$bid_amount = floatval($data['bid']);

$item = Item::findById($item_id);
if (!$item) {
    http_response_code(404);
    echo json_encode(["error" => "Item not found"]);
    exit;
}

if ($item->owner_id == $user_id) {
    http_response_code(400);
    echo json_encode(["error" => "Cannot bid on your own item"]);
    exit;
}

$current_bid = $item->current_bid ?? $item->starting_bid;
if ($bid_amount < $current_bid) {
    http_response_code(400);
    echo json_encode(["error" => "Bid must be >= current bid"]);
    exit;
}

$bid_id = Bid::add($user_id, $item_id, $bid_amount);
$item->current_bid = $bid_amount;
echo json_encode(["message" => "Bid placed", "bid_id" => $bid_id]);
?>
