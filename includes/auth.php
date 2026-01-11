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

function requireAdminLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: /403');
        exit();
    }
}
