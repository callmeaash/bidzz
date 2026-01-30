<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../includes/flash.php';

class LoginController{

    public function handle(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $errors = $_SESSION['errors'] ?? [];
            $old = $_SESSION['old'] ?? [];

            unset($_SESSION['errors'], $_SESSION['old']);
            require_once __DIR__ . '/../views/login.php';
            return;
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $errors = [];

        require_once __DIR__ . '/../../includes/utils.php';

        if ($username === ''){
            $errors['username'] = '✗ Username is required';
        }

        try{
            $user = User::findByUsername($username);

            if ($password === ''){
                $errors['password'] = '✗ Password is required';

            } elseif (empty($user) || !verify_password($password, $user->password)){
                $errors['password'] = '✗ Invalid username or password';
            }

        } catch (Exception $e){
            require_once __DIR__ . '/../../includes/utils.php';
            Logger::error(basename(__FILE__), "Database connection Error", $e->getMessage());
            $errors['password'] = 'Something went wrong. Please try again.';
        }

        if (!empty($errors)){
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: /login');
            exit;
        }

        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->is_admin ? 'admin' : 'user';
        setFlash('success', 'Welcome back, ' . $user->username . '!');
        
        if($user->is_admin == TRUE){
            header('Location: /admin');
            exit;
        
        } else {
            header('Location: /');
            exit;
        }
    }
}
?>