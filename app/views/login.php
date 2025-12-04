<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/auth.css">
    <title>Auction House - Sign In</title>
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <div class="logo">
                <div class="logo-icon">
                    <img src="images/logo.png" alt="logo">
                </div>
                <span class="logo-text">Bidz</span>
            </div>
        </div>

        <h1>Welcome Back</h1>
        <p class="subtitle">Enter your details to sign in to your account</p>

        <form id="login-form" method="POST" action="/login">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="aashish" autocomplete="off" class="<?= isset($errors['username']) ? 'error': ''?>">
                <div id="username-validation" class="validation-message <?= isset($errors['username'])? 'error show': '' ?>">
                    <?= $errors['username'] ?? '' ?>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="off" class="<?= isset($errors['passsword'])? 'error' : ''?>">
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <div id="password-validation" class="validation-message <?= isset($errors['password'])? 'error show' : '' ?>">
                    <?= $errors['password'] ?? '' ?>
                </div>
            </div>

            <button type="submit" class="submit-btn">Sign in</button>

            <p class="signin-link">Don't have an account? <a href="/register">Sign up</a></p>
        </form>
    </div>

    <script src="js/auth.js"></script>
</body>
</html>