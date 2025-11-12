<?php

header('Content-Type: application/json');
require_once '../includes/models.php';
require_once '../includes/auth.php';
require_once '../includes/utils.php';


$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

if (!$username || !$password) {
    json_response(["error" => "Both fields are required"], 400);
}

$user = User::findByUsername($username);

if (!$user || !password_verify($password, $user->password)) {
    json_response(["error" => "Invalid Credentials"], 400);
}

$_SESSION['user_id'] = $user->id;
$_SESSION['is_admin'] = $user->is_admin;

json_response([
    "message" => "Logged in successfully",
    "user_id" => $user->id,
    "username" =>$user->username,
    "is_admin" => $user->is_admin
]);
?>
