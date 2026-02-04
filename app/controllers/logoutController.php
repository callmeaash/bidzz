<?php
require_once __DIR__ . '/../../includes/flash.php';

class LogoutController {

    public function handle() {
        
        $_SESSION = [];
        
        setFlash('success', 'You have been logged out successfully.');
        
        header("Location: /");
        exit;
    }
}