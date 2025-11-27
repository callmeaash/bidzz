<?php
require_once __DIR__ . '/../models/User.php';

class RegisterController{

    public function handle(){
        // Display register form on GET request
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            require_once __DIR__ . '/../views/register.php';
            return;
        }

        // Form data from POST method
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        $errors = [];

        // Include utility functions
        require_once __DIR__ . '/../../includes/utils.php';

        // Username Validation
        if ($username === ''){
            $errors['username'] = '✗ Username is required';

        } elseif (User::findByUsername($username)) {
            $errors['username'] = '✗ Username already taken';
        }

        // Email Validation
        if ($email === ''){
            $errors['email'] ='✗ Email is required';

        } elseif (!validate_email($email)) {
            $errors['email'] = '✗ Invalid email format';

        } elseif (User::findByEmail($email)) {
            $errors['email'] = '✗ Email already registered';
        }

        // Password Validation
        if ($password === '')
            $errors['password'] = '✗ Password is required';
        elseif (!validate_password($password))
            $errors['password'] = '✗ Password must be 8+ chars & include a number';

        if ($password !== $confirm)
            $errors['confirm_password'] = '✗ Passwords do not match';

        // If errors exist, load the form and display errors
        if (!empty($errors)) {
            $errorData = $errors;
            require_once __DIR__ . '/../views/register.php';
            return;
        }

        // Insert user into db
        User::create($username, $email, hash_password($password));
        echo 'success';

    }
}
?>