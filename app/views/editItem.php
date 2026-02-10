<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/listing.css">
    <title>Edit Listing</title>
</head>
<body>
    <div class="header">
        <div><button class="back-button" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></button></div>
        <div>
            <h1>Edit Listing</h1>
            <p class="subtitle">Update your item details</p>
        </div>
    </div>

    <form action="/items/<?= $item->id ?>/update" id="listing-form" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="main-content">
                <div class="card">
                    <h2>Basic Information</h2>
                    <p class="subtitle">Update the details about your item</p>
                    <br>

                    <div class="form-group">
                        <label>Title<span class="required">*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($item->title) ?>" maxlength="100">
                        <div id="title-validation" class="validation-message <?= isset($errors['title'])? 'error' : '' ?>">
                            <?= $errors['title'] ?? '' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description<span class="required">*</span></label>
                        <textarea id="description" name="description" maxlength="1000"><?= htmlspecialchars($item->description) ?></textarea>
                        <div id="description-validation" class="validation-message <?= isset($errors['description'])? 'error' : '' ?>">
                            <?= $errors['description'] ?? '' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Category<span class="required">*</span></label>
                        <select id="category" name="category" onchange="updateSummary()">
                            <option value="">Select a category</option>
                            <?php foreach ($itemsCategory as $category): ?>
                                <option value="<?= $category ?>" <?= $item->category === $category ? 'selected' : '' ?>>
                                    <?= $category ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="category-validation" class="validation-message <?= isset($errors['category'])? 'error' : '' ?>">
                            <?= $errors['category'] ?? '' ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2>Item Image</h2>
                    <p class="subtitle">Update your item image (optional)</p>
                    <br>

                    <div class="form-group">
                        <label>Current Image</label>
                        <img src="<?= $item->image ?>" style="max-width: 300px; border-radius: 8px; margin-bottom: 16px;">
                        
                        <label>Upload New Image (optional)</label>
                        <input type="file" id="imageInput" name="image" accept="image/*" data-has-existing-image="1" onchange="handleImageUpload(event)">

                        <div class="image-upload-area" id="imageUploadArea" onclick="document.getElementById('imageInput').click()">
                            <div class="image-icon"><i class="fa-solid fa-image"></i></div>
                            <div style="color:#666;font-size:14px;margin-bottom:8px;">Click to upload new image</div>
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
                    <p class="subtitle">Update auction parameters</p>
                    <br>

                    <div class="grid-2">
                        <div class="form-group">
                            <label>Duration<span class="required">*</span></label>
                            <select id="duration" name="duration" onchange="updateSummary()">
                                <option selected disable>Select</option>
                                <option value="1">1 Day</option>
                                <option value="3">3 Days</option>
                                <option value="5">5 Days</option>
                                <option value="7">7 Days</option>
                                <option value="10">10 Days</option>
                                <option value="14">14 Days</option>
                            </select>
                            <div id="duration-validation" class="validation-message <?= isset($errors['duration'])? 'error' : '' ?>">
                                <?= $errors['duration'] ?? '' ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Starting Bid ($)<span class="required">*</span></label>
                            <input type="number" id="startingBid" name="startingBid" placeholder="0.00" value="<?= $item->starting_bid ?>" min="0" step="0.01" oninput="updateSummary()">
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
                        <div class="summary-value" id="summary-category"><?= $item->category ?></div>
                    </div>

                    <div class="summary-item">
                        <div class="subtitle">Duration</div>
                        <div class="summary-value" id="summary-duration">7 Days</div>
                    </div>

                    <div class="summary-item">
                        <div class="subtitle">Starting Bid</div>
                        <div class="summary-value" id="summary-bid">$<?= number_format($item->starting_bid, 2) ?></div>
                    </div>

                    <br>
                    <button type="submit" class="btn-primary">Update Listing</button>
                    <button type="button" class="btn-secondary" onclick="history.back()">Cancel</button>
                </div>
            </div>
        </div>
    </form>

    <script src="/js/listing.js"></script>
</body>
</html>