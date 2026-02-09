<?php
require_once __DIR__ . '/../../includes/flash.php';

class LogoutController {

    public function handle() {
        
        session_destroy();
        sleep(2);
        session_start();
        
        setFlash('success', 'You have been logged out successfully.');
        
        header("Location: /");
        exit;
    }
}