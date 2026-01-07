<?php 
require_once __DIR__ . '/../models/User.php';

class UserController {

    public function handle() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $user = User::findById($_SESSION['user_id']);
            require_once __DIR__ . '/../views/user.php';
            exit;
        }

        header('Content-Type: application/json');

        $userId = (int) $_SESSION['user_id'];
        $fullName = trim($_POST['fullName'] ?? null);
        $country = trim($_POST['country'] ?? null);
        $phone   = trim($_POST['phone'] ?? null);
        $bio     = trim($_POST['bio'] ?? null);

        $avatarPath = null;

        if (!empty($_FILES['profileImage']['name'])) {
        
            $file = $_FILES['profileImage'];
        
            if ($file['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['error' => 'Image upload failed']);
                exit;
            }
        
            if ($file['size'] > 5 * 1024 * 1024) {
                echo json_encode(['error' => 'Image size must be less than 5MB']);
                exit;
            }
        
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file['type'], $allowedTypes)) {
                echo json_encode(['error' => 'Invalid image format']);
                exit;
            }
        
            $uploadDir = __DIR__ . '/../../public/images/uploads/';

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
            $destination = $uploadDir . $fileName;

            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                echo json_encode(['error' => 'Failed to save image']);
                exit;
            }

            $avatarPath = '/images/uploads/' . $fileName;
        }

        try {
            $updated = User::updateProfile($userId, [
                'fullName' => $fullName,
                'country' => $country,
                'phone'   => $phone,
                'bio'     => $bio,
                'avatar'  => $avatarPath
            ]);

            echo json_encode([
                'success' => true,
                'avatar'  => $avatarPath
            ]);
        } catch (Exception $e) {
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error(basename(__FILE__), "User Update failed: ", $e->getMessage());
            echo json_encode(['error' => "Couldn't update the data"]);
        }
    }
}