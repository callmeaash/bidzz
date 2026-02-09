<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <title>Profile Settings</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            background-color: #f9fafb;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
        }

        .back-btn:hover {
            color: #111827;
        }

        .header-title h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .header-title p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background-color: #000;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1f2937;
        }

        .btn-secondary {
            background-color: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
        }

        .btn svg {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            vertical-align: middle;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            margin-bottom: 1.5rem;
        }

        .card-header h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .card-header p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .profile-picture-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .avatar {
            width: 6rem;
            height: 6rem;
            background-color: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            color: #374151;
            overflow: hidden;
            position: relative;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-letter {
            display: block;
        }

        .avatar.has-image .avatar-letter {
            display: none;
        }

        .change-photo-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            color: #374151;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .change-photo-btn:hover {
            color: #111827;
        }

        .change-photo-info {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        #profileImageInput {
            display: none;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 1.25rem;
            height: 1.25rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 0.625rem 0.625rem 0.625rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-family: inherit;
            transition: all 0.2s;
        }

        textarea {
            resize: none;
            min-height: 100px;
        }

        input:disabled,
        textarea:disabled {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }

        input:not(:disabled):hover,
        textarea:not(:disabled):hover {
            border-color: #d1d5db;
        }

        input:not(:disabled):focus,
        textarea:not(:disabled):focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-note {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .account-info-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .account-info-item:last-child {
            border-bottom: none;
        }

        .account-info-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }

        .account-info-label svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .account-info-value {
            color: #111827;
            font-weight: 500;
        }

        .status-active {
            color: #10b981;
            font-weight: 600;
        }

        .hidden {
            display: none !important;
        }

        /* Notification Popup */
        #notification {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            color: white;
            background-color: #ef4444; /* default red for error */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 9999;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s, transform 0.3s;
        }

        #notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <button class="back-btn" onclick="history.back()">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <div class="header-title">
                    <h1>Profile Settings</h1>
                    <p>Manage your account information</p>
                </div>
            </div>
            <div class="header-actions">
                <button id="editBtn" class="btn btn-primary">Edit Profile</button>
                <button id="cancelBtn" class="btn btn-secondary hidden">Cancel</button>
                <button id="saveBtn" class="btn btn-primary hidden">
                    <i class="fa-solid fa-check"></i>
                    Save Changes
                </button>
            </div>
        </div>

        <form id="profileForm">
            <div class="card">
                <div class="card-header">
                    <h2>Profile Picture</h2>
                    <p>Update your profile picture</p>
                </div>
                <div class="profile-picture-content">
                    <div class="avatar" id="avatarContainer">
                        <img
                            id="avatarImage"
                            src="<?= $user->avatar ?? '' ?>"
                            alt="Profile"
                            style="<?= $user->avatar ? '' : 'display:none;' ?>"
                        >

                        <span class="avatar-letter">
                            <?= strtoupper(substr($user->username, 0, 1)) ?>
                        </span>
                    </div>
                    <div id="changePhotoSection" class="hidden">
                        <input type="file" id="profileImageInput" name="profileImageInput" accept="image/png, image/jpeg, image/jpg" />
                        <button type="button" class="change-photo-btn" id="changePhotoBtn">
                            <i class="fa-solid fa-camera"></i>
                            Change Photo
                        </button>
                        <p class="change-photo-info">JPG, PNG or GIF. Max size 5MB.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Personal Information</h2>
                    <p>Update your personal details</p>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input type="text" id="username" name="username" value="<?= $user->username ?>" disabled>
                        </div>
                        <!-- <p class="form-note">Username cannot be changed</p> -->
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input type="email" id="email" name="email" value="a<?= $user->email ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input type="text" id="fullName" name="fullName" value="<?= $user->fullname? $user->fullname:''?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <input type="tel" id="phone" name="phone" value="<?= $user->phone? $user->phone: ''?>" disabled>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="country">Country</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="text" id="country" name="country" value="<?= $user->country? $user->country: ''?>" disabled>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="bio">Bio</label>
                        <textarea id="bio" name="bio" placeholder="Tell us a bit about yourself..." disabled><?= $user->bio? $user->bio: ''?></textarea>
                    </div>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                <h2>Account Information</h2>
                <p>View your account details</p>
            </div>
            <div class="account-info-item">
                <div class="account-info-label">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Member Since</span>
                </div>
                <div class="account-info-value"><?= date('F, Y', strtotime($user->created_at)) ?></div>
            </div>
            <div class="account-info-item">
                <div class="account-info-label">
                    <span>Account Status</span>
                </div>
                <div class="account-info-value status-active"><?= $user->is_active? 'Active': 'Inactive' ?></div>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div id="notification" class="hidden"></div>

    <script>
        const editBtn = document.getElementById('editBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const profileForm = document.getElementById('profileForm');
        const profileImageInput = document.getElementById('profileImageInput');
        const changePhotoBtn = document.getElementById('changePhotoBtn');
        const changePhotoSection = document.getElementById('changePhotoSection');
        const avatarImage = document.getElementById('avatarImage');
        const avatarContainer = document.getElementById('avatarContainer');

        if (avatarImage.src && avatarImage.style.display !== 'none') {
            avatarContainer.classList.add('has-image');
        }

        const editableFields = ['email', 'fullName', 'phone', 'country', 'bio'];
        const readonlyFields = ['username', 'email'];
        let originalValues = {};
        let currentProfileImage = null;
        let originalProfileImage = null;

        function storeOriginalValues() {
            editableFields.forEach(field => {
                const input = document.getElementById(field);
                originalValues[field] = input.value;
            });
            originalProfileImage = currentProfileImage;
        }

        function showNotification(message, type='error', duration=3000){
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.backgroundColor = type==='success' ? '#10b981' : '#ef4444';
            notification.classList.add('show');
            notification.classList.remove('hidden');
            setTimeout(() => {
                notification.classList.remove('show');
                notification.classList.add('hidden');
            }, duration);
        }

        editBtn.addEventListener('click', () => {
            editableFields.forEach(field => {
                if (!readonlyFields.includes(field)) {
                    document.getElementById(field).disabled = false;
                }
            });
            changePhotoSection.classList.remove('hidden');
            editBtn.classList.add('hidden');
            cancelBtn.classList.remove('hidden');
            saveBtn.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            editableFields.forEach(field => {
                const input = document.getElementById(field);
                input.value = originalValues[field];
                input.disabled = true;
            });
            changePhotoSection.classList.add('hidden');
            editBtn.classList.remove('hidden');
            cancelBtn.classList.add('hidden');
            saveBtn.classList.add('hidden');

            currentProfileImage = originalProfileImage;
            if (currentProfileImage) {
                avatarImage.src = currentProfileImage;
                avatarImage.style.display = 'block';
                avatarContainer.classList.add('has-image');
            } else {
                avatarImage.style.display = 'none';
                avatarImage.src = '';
                avatarContainer.classList.remove('has-image');
            }
        });

        changePhotoBtn.addEventListener('click', () => profileImageInput.click());

        profileImageInput.addEventListener('change', () => {
            const file = profileImageInput.files[0];
            if(!file) return;

            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if(!validTypes.includes(file.type)){
                showNotification('Please select a JPG, PNG, or GIF image', 'error');
                profileImageInput.value = '';
                return;
            }

            if(file.size > 5 * 1024 * 1024){
                showNotification('File size must be less than 5MB', 'error');
                profileImageInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e){
                avatarImage.src = e.target.result;
                avatarImage.style.display = 'block';
                avatarContainer.classList.add('has-image');
                currentProfileImage = e.target.result;
            }
            reader.readAsDataURL(file);
        });

        function saveChanges() {
            if (profileImageInput.files.length > 0) {
                const file = profileImageInput.files[0];
                const maxSize = 5 * 1024 * 1024;
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if (!allowedTypes.includes(file.type)) {
                    showNotification('Please select a JPG, PNG or GIF image', 'error');
                    return;
                }

                if (file.size > maxSize) {
                    showNotification('File size must be less than 5MB', 'error');
                    return;
                }
            }

            const formData = new FormData();
            editableFields.forEach(field => {
                const input = document.getElementById(field);
                formData.append(field, input.value);
            });

            if (profileImageInput.files.length > 0) {
                formData.append('profileImage', profileImageInput.files[0]);
            }

            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';

            fetch('/me/', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                storeOriginalValues();

                editableFields.forEach(field => document.getElementById(field).disabled = true);
                editBtn.classList.remove('hidden');
                cancelBtn.classList.add('hidden');
                saveBtn.classList.add('hidden');
                changePhotoSection.classList.add('hidden');

                saveBtn.disabled = false;
                saveBtn.innerHTML = `
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                    Save Changes
                `;

                showNotification('Profile updated successfully!', 'success');
            })
            .catch(error => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = `
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                    Save Changes
                `;
                showNotification('Failed to update profile. Please try again.', 'error');
            });
        }

        saveBtn.addEventListener('click', saveChanges);

        storeOriginalValues();


    </script>
</body>
</html>
