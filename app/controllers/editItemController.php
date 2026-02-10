<?php

class EditItemController {
    public function handleEdit($itemId) {
        require_once __DIR__ . '/../models/Item.php';
        require_once __DIR__ . '/../../includes/utils.php';
        
        $item = Item::findById($itemId);
        
        if (!$item) {
            header('Location: /');
            exit;
        }
        
        if ($item->owner_id !== $_SESSION['user_id']) {
            header('Location: /');
            exit;
        }
        
        if ($item->getBidsCount() > 0) {
            header('Location: /items/' . $itemId);
            exit;
        }
        
        if (!$item->is_active) {
            header('Location: /items/' . $itemId);
            exit;
        }
        
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        
        require_once __DIR__ . '/../views/editItem.php';
    }
    
    public function handleUpdate($itemId) {
        require_once __DIR__ . '/../models/Item.php';
        require_once __DIR__ . '/../../includes/utils.php';
        require_once __DIR__ . '/../../includes/flash.php';
        
        $item = Item::findById($itemId);
        
        if (!$item || $item->owner_id !== $_SESSION['user_id'] || $item->getBidsCount() > 0 || !$item->is_active) {
            header('Location: /');
            exit;
        }
        
        $errors = [];
        
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $category = trim($_POST['category']);
        $startingBid = trim($_POST['startingBid']);
        
        if ($title === '') {
            $errors['title'] = '✗ Title is required';
        }
        
        if (strlen($description) < 20) {
            $errors['description'] = '✗ Description must be at least 20 characters';
        }
        
        if ($category === '') {
            $errors['category'] = '✗ Category is required';
        }
        
        if (!is_numeric($startingBid) || $startingBid < 0) {
            $errors['startingBid'] = '✗ Enter a valid starting bid';
        }
        
        $imagePath = null;
        $allowedTypes = ['image/jpeg', 'image/png'];
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['image']['tmp_name'];
            $fileSize = $_FILES['image']['size'];
            
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $fileTmp);
            finfo_close($finfo);
            
            if (!in_array($mime, $allowedTypes)) {
                $errors['image'] = '✗ Invalid image type. Only JPG, PNG allowed';
            } elseif ($fileSize > 10 * 1024 * 1024) {
                $errors['image'] = '✗ Image too large';
            } else {
                $originalName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
                $originalName = preg_replace("/[^a-zA-Z0-9_-]/", "_", $originalName);
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $newName = $_SESSION['username'] . '_' . $originalName . '_' . time() . '.' . $ext;
                
                $uploadPath = __DIR__ . "/../../public/images/uploads/$newName";
                $imagePath = '/images/uploads/' . $newName;
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $errors['image'] = '✗ Failed to upload image';
                }
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /my-listings/");
            exit;
        }
        
        try {
            Item::update($itemId, $title, $description, $category, $startingBid, $imagePath);
            
            header("Location: /my-listings/");
            exit;
            
        } catch (Exception $e) {
            Logger::error(basename(__FILE__), 'Database Error', $e->getMessage());
            $errors['serverError'] = '✗ Something went wrong';
            $_SESSION['errors'] = $errors;
            header("Location: /my-listings/");
            exit;
        }
    }
}