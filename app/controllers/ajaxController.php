<?php
class AjaxController{
    public function checkUsername(){
        header('Content-Type: application/json');
        $username = trim($_GET['username'] ?? '');
        if (!$username) {
            echo json_encode(['available' => false, 'message' => 'Username is required']);
            return;
        }
        try {
            require_once __DIR__ . '/../models/User.php';
            $user = User::findByUsername($username);
            
            if (!empty($user)){
                echo json_encode(['available' => false, 'message' => 'Username already taken']);
            } else {
                echo json_encode(['available' => true, 'message' => 'Username available']);
            }

        } catch (Exception $e) {
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error("Username check error: " . $e->getMessage());
            echo json_encode(['available' => false, 'message' => 'Unable to check username']);
        }
    }
}
