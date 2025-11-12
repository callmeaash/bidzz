<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/models.php';
require_once '../includes/auth.php';

requireUserOrAdmin // ensure the user is logged in
$user_id = $_SESSION['user_id'];

// Get the latest bid per item for this user
$bids = Bid::getUserLastBids($user_id);

$response = [];
foreach ($bids as $bid) {
    $item = Item::findById($bid['item_id']);
    $owner = User::findById($item->owner_id);

    $response[] = [
        "item_id" => $item->id,
        "title" => $item->title,
        "owner_avatar" => $owner->avatar,
        "current_bid" => $item->current_bid,
        "user_bid" => $bid['bid']
    ];
}

echo json_encode($response);
?>
