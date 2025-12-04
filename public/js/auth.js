function showError(fieldId, message) {
    const validationDiv = document.getElementById(fieldId + '-validation');
    const input = document.getElementById(fieldId);
    
    validationDiv.textContent = message;
    validationDiv.className = 'validation-message error show';
    input.classList.add('error');
    input.classList.remove('success');
}

function showSuccess(fieldId, message) {
    const validationDiv = document.getElementById(fieldId + '-validation');
    const input = document.getElementById(fieldId);
    
    validationDiv.textContent = message;
    validationDiv.className = 'validation-message success show';
    input.classList.add('success');
    input.classList.remove('error');
}

function clearValidation(fieldId) {
    const validationDiv = document.getElementById(fieldId + '-validation');
    const input = document.getElementById(fieldId);
    
    validationDiv.textContent = '';
    validationDiv.className = 'validation-message';
    input.classList.remove('error', 'success');
}

function checkUsername() {
    const usernameInput = document.getElementById('username');
    const username = usernameInput ? usernameInput.value.trim() : '';

    fetch(`/check-username?username=${encodeURIComponent(username)}`)
        .then(response => response.json())
        .then(data => {
            if (!data.available) {
                showError('username', data.message);
            } else {
                showSuccess('username', data.message);
            }
        })
        .catch(err => console.error(err));
};


function checkEmail() {
    const email = document.getElementById('email').value.trim();
    if (email === '') {
        clearValidation('email');
        return false;
    }
    // Basic email format validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('email', '✗ Please enter a valid email address');
        return false;
    }
    showSuccess('email', 'Valid email address');
    return true;
}

function checkPassword() {
    const password = document.getElementById('password').value;
    
    if (password === '') {
        clearValidation('password');
        return false;
    }

    const regex = /^(?=.*[0-9]).{8,}$/;

    if (!regex.test(password)) {
        showError('password', '✗ Password must be 8+ chars & include a number');
        return false;

    } else {
        showSuccess('password', '✓ Password meets requirements');
        checkConfirmPassword(); // Re-check confirm password when password changes
        return true;
    }
}

function checkConfirmPassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (confirmPassword === '') {
        clearValidation('confirm-password');
        return false;
    }

    if (password !== confirmPassword) {
        showError('confirm-password', '✗ Passwords do not match');
        return false;
    } else {
        showSuccess('confirm-password', '✓ Passwords match');
        return true;
    }
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}

// Add ajax to check username availability
if (document.body.classList.contains('register-page')){
    const usernameInput = document.getElementById('username');
    usernameInput.addEventListener('input', checkUsername);
}


// Handle form submission
const SignupForm = document.getElementById('signup-form');
if(SignupForm){
    SignupForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
    
        let isValid = true;
    
        // Validate username
        if (!username) {
            showError('username', '✗ Username is required');
            isValid = false;
        } else {
            clearValidation('username');
        }
    
        // Validate email
        if (!email) {
            showError('email', '✗ Email is required');
            isValid = false;
        } else if (!checkEmail()) {
            isValid = false;
        }
    
        // Validate password
        if (!password) {
            showError('password', '✗ Password is required');
            isValid = false;
        } else if (!checkPassword()) {
            isValid = false;
        }
    
        // Validate confirm password
        if (!confirmPassword) {
            showError('confirm-password', '✗ Please confirm your password');
            isValid = false;
        } else if (!checkConfirmPassword()) {
            isValid = false;
        }
    
        // If all validations pass, submit the form
        if (isValid) {
            // Submit the form to /register route
            this.submit();
        }
    });
}

// Handle form submission
const loginForm = document.getElementById('login-form');
if(loginForm){
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;

        let isValid = true;

        // Validate username
        if (!username) {
            showError('username', '✗ Username is required');
            isValid = false;
        } else {
            clearValidation('username');
        }

        // Validate password
        if (!password) {
            showError('password', '✗ Password is required');
            isValid = false;
        } else {
            clearValidation('password');
        }

        // If all validations pass, submit the form
        if (isValid) {
            // Submit the form to /login route
            this.submit();
        }
    });
}
