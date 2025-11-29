<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/auth.css">
    <title>Auction House - Create Account</title>
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

        <h1>Create an account</h1>
        <p class="subtitle">Enter your details to get started with Bidz</p>

        <form id="signup-form" method="POST" action="/register">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="aashish">
                <div id="username-validation" class="validation-message"></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="aashish@example.com" oninput="checkEmail()">
                <div id="email-validation" class="validation-message"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Create a password (min. 8 characters)" oninput="checkPassword()">
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <div id="password-validation" class="validation-message"></div>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" oninput="checkConfirmPassword()">
                    <button type="button" class="toggle-password" onclick="togglePassword('confirm-password')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <div id="confirm-password-validation" class="validation-message"></div>
            </div>

            <button type="submit" class="submit-btn">Create account</button>

            <p class="signin-link">Already have an account? <a href="login">Sign in</a></p>
        </form>
    </div>

    <script src="js/auth.js"></script>
</body>
</html>