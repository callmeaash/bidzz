<?php
require_once __DIR__ . '/../models/User.php';

class LoginController{

    public function handle(){
        // Display register form on GET request
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $errors = $_SESSION['errors'] ?? [];
            $old = $_SESSION['old'] ?? [];

            unset($_SESSION['errors'], $_SESSION['old']);
            require_once __DIR__ . '/../views/login.php';
            return;
        }

        // Handle post request
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $errors = [];

        // Include utility functions
        require_once __DIR__ . '/../../includes/utils.php';

        // Validate Inputs
        if ($username === ''){
            $errors['username'] = '✗ Username is required';
        }

        try{
            // Fetch user record from the database
            $user = User::findByUsername($username);

            // Check if the user credientials are correct
            if ($password === ''){
                $errors['password'] = '✗ Password is required';

            } elseif (empty($user) || !verify_password($password, $user->password)){
                $errors['password'] = '✗ Invalid username or password';
            }

        } catch (Exception $e){
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error(basename(__FILE__), "Database connection Error", $e->getMessage());
            $errors['password'] = '🔄 Something went wrong. Please try again.';
        }

        if (!empty($errors)){
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: /login');
            exit;
        }

        // Store the user data in session
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->is_admin ? 'admin' : 'user';

        if($user->is_admin == TRUE){
            header('Location: /admin');
            exit;
        
        } else {
            header('Location: /index');
            exit;
        }
    }
}
?>