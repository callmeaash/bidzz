<?php

function setFlash($type, $message) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    
    return null;
}

function hasFlash() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['flash']);
}

function renderFlash() {
    $flash = getFlash();
    if (!$flash) return '';
    
    $type = htmlspecialchars($flash['type']);
    $message = htmlspecialchars($flash['message']);
    
    return "
    <div class='flash-message flash-{$type}' id='flashMessage'>
        <span class='flash-icon'></span>
        <span class='flash-text'>{$message}</span>
        <button class='flash-close' onclick='closeFlash()'>&times;</button>
    </div>
    ";
}