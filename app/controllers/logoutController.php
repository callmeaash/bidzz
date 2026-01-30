<?php
require_once __DIR__ . '/../../includes/flash.php';

class LogoutController {

    public function handle() {
        // Store username for flash message
        $username = $_SESSION['username'] ?? 'User';
        
        // Set flash message before destroying session
        setFlash('success', 'Goodbye, ' . $username . '. You have been logged out successfully.');
        
        // Keep flash message in a temporary variable
        $flashMessage = $_SESSION['flash'];
        
        // Clear session
        $_SESSION = [];
        
        // Restore flash message
        $_SESSION['flash'] = $flashMessage;
        
        // Destroy session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        session_destroy();
        
        // Start new session for flash message
        session_start();
        $_SESSION['flash'] = $flashMessage;
        
        header("Location: /");
        exit;
    }
}