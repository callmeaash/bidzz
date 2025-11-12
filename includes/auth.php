<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    return isset($_SESSION['user_id']);
}

function requireAdmin() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['is_admin']);
}

function requireUserOrAdmin() {
    return isset($_SESSION['user_id']);
}
?>
