<?php
header('Content-Type: application/json');
require_once '../includes/models.php';
require_once '../includes/utils.php';


$item_id = isset($_GET['item_id']) ? intval($_GET['item_id']) : 0;

if ($item_id <= 0) {
    json_response(["error" => "Invalid item_id"], 400);
}


$item = Item::findById($item_id);

if (!$item) {
    json_response(["error" => "Item does not exist"], 404);
}


$bids = $item->getBids();
$comments = $item->getComments();

json_response([
    "id" => $item->id,
    "owner_id" => $item->owner_id,
    "title" => $item->title,
    "description" => $item->description,
    "category" => $item->category,
    "starting_bid" => $item->starting_bid,
    "current_bid" => $item->current_bid,
    "image" => $item->image,
    "end_at" => $item->end_at,
    "bids" => $bids,
    "comments" => $comments
]);
?>
