<?php
require_once __DIR__ . '/../../includes/flash.php';

class LogoutController {

    public function handle() {
        // Store username for flash message
        $username = $_SESSION['username'] ?? 'User';
        
        // Clear all session data except we'll set flash in new session
        $_SESSION = [];
        
        // Destroy session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Destroy the session
        session_destroy();
        
        // Start a fresh session for the flash message
        session_start();
        
        // Set the flash message in the new session
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Goodbye, ' . $username . '. You have been logged out successfully.'
        ];
        
        header("Location: /");
        exit;
    }
}