<?php
require_once '../includes/db.php';
require_once '../includes/models.php';
require_once '../includes/auth.php';
require_once '../includes/utils.php';

requireUserOrAdmin();

$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);

$title = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$category = trim($data['category'] ?? '');
$starting_bid = floatval($data['starting_bid'] ?? 0);
$days = intval($data['days'] ?? 1);

$image_path = '/static/uploads/item.jpg';
$username = $_SESSION['username'] ?? 'user';

// Validate required fields
if (!$title || !$description || !$category || $starting_bid <= 0 || $days <= 0) {
    json_response(["error" => "All fields are required and must be valid"], 400);
}

// Image validation
$allowed_types = ['image/png', 'image/jpg', 'image/jpeg'];
$max_size = 5 * 1024 * 1024;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file_type = mime_content_type($_FILES['image']['tmp_name']);
    $file_size = $_FILES['image']['size'];

    if (!in_array($file_type, $allowed_types)) {
        json_response(["error" => "Invalid image type. Allowed: png, jpg, jpeg"], 400);
    }

    if ($file_size > $max_size) {
        json_response(["error" => "Image size must be less than 5MB"], 400);
    }

    $sanitized_username = preg_replace("/[^a-zA-Z0-9]/", "_", $username);
    $filename = time() . '_' . $sanitized_username . '_' . basename($_FILES['image']['name']);
    $target = '../static/uploads/' . $filename;
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image_path = $target;
    } else {
        json_response(["error" => "Failed to upload image"], 500);
    }
}

$item_id = Item::create($user_id, $title, $description, $category, $starting_bid, $days, $image_path);
json_response(["message" => "Item added", "item_id" => $item_id]);
?>
