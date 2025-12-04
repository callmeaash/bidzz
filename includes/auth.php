<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
}

function requireAdmin() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['is_admin']);
}
?>
