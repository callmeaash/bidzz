<?php
require_once __DIR__ . '/../models/User.php';

class RegisterController{

    public function handle(){

        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $errors = $_SESSION['errors'] ?? [];
            $old = $_SESSION['old'] ?? [];

            unset($_SESSION['errors'], $_SESSION['old']);
            require_once __DIR__ . '/../views/register.php';
            return;
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        $errors = [];

        require_once __DIR__ . '/../../includes/utils.php';

        try{
            if ($username === ''){
                $errors['username'] = '<i class="fa-solid fa-x"></i> Username is required';
            
            }
            
            elseif (!validate_username($username)) {
                $errors['username'] = '<i class="fa-solid fa-x"></i> Username must be 3+ chars long';
            }

            elseif (User::findByUsername($username)) {
                $errors['username'] = '<i class="fa-solid fa-x"></i> Username already taken';
            }

            if ($email === ''){
                $errors['email'] ='<i class="fa-solid fa-x"></i> Email is required';
            
            } elseif (!validate_email($email)) {
                $errors['email'] = '<i class="fa-solid fa-x"></i> Invalid email format';
            
            } elseif (User::findByEmail($email)) {
                $errors['email'] = '<i class="fa-solid fa-x"></i> Email already registered';
            }
        
            if ($password === '')
                $errors['password'] = '<i class="fa-solid fa-x"></i> Password is required';
            elseif (!validate_password($password))
                $errors['password'] = '<i class="fa-solid fa-x"></i> Password must be 8+ chars & include a number';
        
            if ($password !== $confirm)
                $errors['confirm_password'] = '<i class="fa-solid fa-x"></i> Passwords do not match';
        
            if (!empty($errors)) {
                $errorData = $errors;
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: /register');
                return;
            }

            User::create($username, $email, hash_password($password));
            
            header('Location: /login');
            exit;
    
        } catch (Exception $e) {
            Logger::error(basename(__FILE__), 'User registration failed', $e->getMessage());
            
            $errors['password'] = 'Unable to complete registration. Please try again later.';
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            
            header('Location: /register');
            exit;
        }
    }
}
?>