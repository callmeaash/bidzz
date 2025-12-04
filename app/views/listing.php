<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/listing.css">
    <title>Create New Listing</title>
</head>
<body>
    <div class="header">
        <div><button class="back-button" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></button></div>
        <div>
            <h1>Create New Listing</h1>
            <p class="subtitle">List your item for auction</p>
        </div>
    </div>

    <form action="/listing" id="listing-form" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="main-content">
                <div class="card">
                    <h2>Basic Information</h2>
                    <p class="subtitle">Provide the essential details about your item</p>
                    <br>

                    <div class="form-group">
                        <label>Title<span class="required">*</span></label>
                        <input type="text" id="title" name="title" placeholder="e.g. Mantra Karma Guitar" maxlength="100">
                        <div id="title-validation" class="validation-message <?= isset($errors['title'])? 'error' : '' ?>">
                            <?= $errors['title'] ?? '' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description<span class="required">*</span></label>
                        <textarea id="description" name="description" placeholder="Describe your item in detail, including condition, features, and any relevant history..." maxlength="1000"></textarea>
                        <div id="description-validation" class="validation-message <?= isset($errors['description'])? 'error' : '' ?>">
                            <?= $errors['description'] ?? '' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Category<span class="required">*</span></label>
                        <select id="category" name="category" onchange="updateSummary()">
                            <option value="">Select a category</option>
                            <?php foreach ($itemsCategory as $category): ?>
                                <option value="<?= $category ?>"><?= $category ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div id="category-validation" class="validation-message <?= isset($errors['category'])? 'error' : '' ?>">
                            <?= $errors['category'] ?? '' ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2>Item Image</h2>
                    <p class="subtitle">Add a high-quality image of your item</p>
                    <br>

                    <div class="form-group">
                        <label>Upload Image<span class="required">*</span></label>
                        <input type="file" id="imageInput" name="image" accept="image/*" onchange="handleImageUpload(event)">

                        <div class="image-upload-area" id="imageUploadArea" onclick="document.getElementById('imageInput').click()">
                            <div class="image-icon"><i class="fa-solid fa-image"></i></div>
                            <div style="color:#666;font-size:14px;margin-bottom:8px;">Click to upload</div>
                            <div style="color:#999;font-size:12px;">PNG, JPG up to 10MB</div>
                        </div>

                        <div id="image-validation" class="validation-message <?= isset($errors['image'])? 'error' : '' ?>">
                            <?= $errors['image'] ?? '' ?>
                        </div>

                        <div id="imagePreviewContainer"></div>
                    </div>
                </div>

                <div class="card">
                    <h2>Auction Settings</h2>
                    <p class="subtitle">Configure your auction parameters</p>
                    <br>

                    <div class="grid-2">
                        <div class="form-group">
                            <label>Duration<span class="required">*</span></label>
                            <select id="duration" name="duration" onchange="updateSummary()">
                                <option value="1">1 Day</option>
                                <option value="3">3 Days</option>
                                <option value="5">5 Days</option>
                                <option value="7" selected>7 Days</option>
                                <option value="10">10 Days</option>
                                <option value="14">14 Days</option>
                            </select>
                            <div id="duration-validation" class="validation-message <?= isset($errors['duration'])? 'error' : '' ?>">
                                <?= $errors['duration'] ?? '' ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Starting Bid ($)<span class="required">*</span></label>
                            <input type="number" id="startingBid" name="startingBid" placeholder="0.00" min="0" step="0.01" value="0.00" oninput="updateSummary()">
                            <div id="startingBid-validation" class="validation-message <?= isset($errors['startingBid'])? 'error' : '' ?>">
                                <?= $errors['startingBid'] ?? '' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="card">
                    <h2>Listing Summary</h2>

                    <div class="summary-item">
                        <div class="subtitle">Seller</div>
                        <div class="summary-value"><?= $_SESSION['username'] ?></div>
                    </div>

                    <div class="summary-item">
                        <div class="subtitle">Category</div>
                        <div class="summary-value" id="summary-category">Not selected</div>
                    </div>

                    <div class="summary-item">
                        <div class="subtitle">Duration</div>
                        <div class="summary-value" id="summary-duration">7 Days</div>
                    </div>

                    <div class="summary-item">
                        <div class="subtitle">Starting Bid</div>
                        <div class="summary-value" id="summary-bid">$0.00</div>
                    </div>

                    <br>
                    <button type="submit" class="btn-primary">Create Listing</button>
                    <button type="button" class="btn-secondary" onclick="history.back()">Cancel</button>
                </div>
            </div>
        </div>
    </form>

    <script src="/js/listing.js"></script>
</body>
</html>
