let uploadedImageFile = null;

function updateSummary() {
    const category = document.getElementById('category').value;
    const duration = document.getElementById('duration').value;
    const startingBid = document.getElementById('startingBid').value;

    document.getElementById('summary-category').textContent = category || 'Not selected';
    document.getElementById('summary-duration').textContent = duration + ' Day' + (duration > 1 ? 's' : '');
    document.getElementById('summary-bid').textContent = '$' + (parseFloat(startingBid) || 0).toFixed(2);
}

function handleImageUpload(event) {
    const file = event.target.files[0];
    if(!file) return;

    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    const maxSize = 10 * 1024 * 1024; // 10MB

    if (!allowedTypes.includes(file.type)) {
        showError('image', '✗ Only JPG or PNG files are allowed');
        event.target.value = '';
        return;
    }

    if (file.size > 10 * 1024 * 1024) {
        showError('image', 'Image must be under 10MB')
        return;
    }

    clearValidation('image');
    displayImage(file);
}

function displayImage(file) {

    uploadedImageFile = file;
    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('imageUploadArea').style.display = 'none';
        document.getElementById('imagePreviewContainer').innerHTML = `
            <img src="${e.target.result}" class="preview-image">
            <button class="remove-image" onclick="removeImage()">Remove Image</button>
        `;
    };

    reader.readAsDataURL(file);
}

function showError(fieldId, message) {
    const validationDiv = document.getElementById(fieldId + '-validation');
    const input = document.getElementById(fieldId);
                
    validationDiv.textContent = message;
    validationDiv.className = 'validation-message error';
    input.classList.add('error');
}

function clearValidation(fieldId) {
    const validationDiv = document.getElementById(fieldId + '-validation');
    const input = document.getElementById(fieldId);

    validationDiv.textContent = '';
    validationDiv.className = 'validation-message';
    input.classList.remove('error');
}

function removeImage() {
    uploadedImageFile = null;
    document.getElementById('imageInput').value = '';
    document.getElementById('imageUploadArea').style.display = 'block';
    document.getElementById('imagePreviewContainer').innerHTML = '';
}

document.getElementById('listing-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const category = document.getElementById('category').value;
    const startingBid = document.getElementById('startingBid').value.trim();
    const duration = document.getElementById('duration').value;

    let isValid = true;

    if (!title) {
        showError('title', '✗ Title is required');
        isValid = false;
    } else {
        clearValidation('title');
    }

    if (description.length < 100) {
        showError('description', '✗ Description must be at least 20 characters');
        isValid = false;
    } else {
        clearValidation('description');
    }

    if (!category) {
        showError('category', '✗ Category is required');
        isValid = false;
    } else {
        clearValidation('category');
    }

    if (!duration) {
        showError('duration', '✗ Duration is required');
        isValid = false;
    } else {
        clearValidation('duration');
    }

    if (!startingBid || startingBid <= 0) {
        showError('startingBid', '✗ Starting bid cannot be zero');
        isValid = false;
    } else {
        clearValidation('startingBid');
    }

    if (!uploadedImageFile) {
        showError('image', '✗ Please upload an image');
        isValid = false;
    }

    if(isValid) this.submit();
});