<?php
require_once '../includes/models.php';
require_once '../includes/utils.php';

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data['email'] ?? '');
$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');
$confirm_password = trim($data['confirm_password'] ?? '');

// Validate required fields
if (!$email) {
    json_response(["error" => "Email is required"], 400);
}

if (!$username) {
    json_response(["error" => "Username is required"], 400);
}

if (!$password) {
    json_response(["error" => "Password is required"], 400);
}

if (!$confirm_password) {
    json_response(["error" => "Confirm password is required"], 400);
}

// Validate field formats
if (!validate_email($email)) {
    json_response(["error" => "Invalid email format"], 400);
}

if (!validate_username($username)) {
    json_response(["error" => "Username must start with a letter, 3-20 chars, letters/numbers/_/. only"], 400);
}

if (!validate_password($password)) {
    json_response(["error" => "Password must be at least 6 characters and include a number"], 400);
}

// Password match check
if ($password !== $confirm_password) {
    json_response(["error" => "Passwords do not match"], 400);
}

// Check if email or username already exists
if (User::findByEmail($email)) {
    json_response(["error" => "Email already exists"], 409);
}

if (User::findByUsername($username)) {
    json_response(["error" => "Username already exists"], 409);
}

// Create user
$hashed_password = hash_password($password);
$user = User::create($username, $email, $hashed_password);

json_response([
    "message" => "User registered successfully",
    "user_id" => $user
]);
?>
