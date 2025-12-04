<?php

class ListingController {
    public function handle() {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $errors = $_SESSION['errors'] ?? [];
            unset($_SESSION['errors']);
            require_once __DIR__ . '/../../includes/utils.php';
            require_once __DIR__ . '/../views/listing.php';
            return;
        }

        $errors = [];

        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $category = trim($_POST['category']);
        $startingBid = trim($_POST['startingBid']);
        $duration = (int) trim($_POST['duration']);

        if ($title === ''){
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

        if ($duration === '') {
            $errors['duration'] = '✗ Duration is required';
        }

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
            }
        } else {
            $errors['image'] = "✗ Please upload an image";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /listing');
            exit;
        }

        try {
            require_once __DIR__ . '/../models/Item.php';
            $originalName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
            $originalName = preg_replace("/[^a-zA-Z0-9_-]/", "_", $originalName);
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newName = $_SESSION['username'] . '_' . $originalName . '_' . time() . '.' . $ext;

            $uploadPath = __DIR__ . "/../../public/images/uploads/$newName";

            $filepath = '/images/uploads/' . $newName;
            Item::create($_SESSION['user_id'], $title, $description, $category, $startingBid, $duration, $filepath);

            move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);

            header('Location: /');
            exit;

        } catch (Exception $e) {
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error(basename(__FILE__), 'Database Error', $e->getMessage());
            $errors['serverError'] = '✗ Something went wrong';
            $_SESSION['errors'] = $errors;
            header('Location: /listing');
            exit;
        }

    }
}