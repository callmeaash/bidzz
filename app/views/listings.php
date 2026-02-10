<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=package_2" />
    <title>My Listings - Auction Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #f5f5f7;
            color: #1d1d1f;
        }

        .header {
            background: white;
            padding: 20px 40px;
            border-bottom: 1px solid #e5e5e7;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 5px 10px;
        }

        .back-btn:hover {
            opacity: 0.7;
        }

        .header-text h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header-text p {
            color: #86868b;
            font-size: 14px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 40px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-header h3 {
            font-size: 14px;
            font-weight: 500;
            color: #86868b;
        }

        .stat-icon {
            width: 24px;
            height: 24px;
            opacity: 0.6;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .btn-container {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            margin-top: 20px;

        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-outline {
            background: #fff;
            border: 1px solid #ddd;
            color: #333;
        }

        .btn-outline:hover {
            background: #f5f5f5;
        }

        .stat-subtitle {
            font-size: 13px;
            color: #86868b;
        }

        .listings-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .listing-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            gap: 20px;
            align-items: center;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
        }

        .listing-card:hover {
            cursor: pointer;
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.12);

        }

        .listing-image {
            width: 150px;
            height: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        .listing-content {
            flex: 1;
            overflow: hidden;
        }

        .listing-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .listing-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .listing-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }

        .tag {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .tag.category {
            background: #f5f5f7;
            color: #1d1d1f;
        }

        .tag.status {
            background: #d1f4e0;
            color: #0a6e31;
        }

        .listing-description {
            color: #86868b;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 15px;
        }

        .listing-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 12px;
            color: #86868b;
            margin-bottom: 4px;
        }

        .stat-data {
            font-size: 16px;
            font-weight: 600;
        }

        .confirm-dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .confirm-dialog-overlay.active {
            display: flex;
        }

        .confirm-dialog {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 0;
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .confirm-dialog-header {
            padding: 24px 24px 16px;
            border-bottom: 1px solid #e5e5e7;
        }

        .confirm-dialog-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #1d1d1f;
            margin-bottom: 8px;
        }

        .confirm-dialog-message {
            font-size: 14px;
            color: #86868b;
            line-height: 1.5;
        }

        .confirm-dialog-footer {
            padding: 16px 24px;
            border-top: 1px solid #e5e5e7;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .dialog-btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .dialog-btn-cancel {
            background: #f5f5f7;
            color: #1d1d1f;
        }

        .dialog-btn-cancel:hover {
            background: #e8e8ed;
        }

        .dialog-btn-confirm {
            background: #ef4444;
            color: white;
        }

        .dialog-btn-confirm:hover {
            background: #dc2626;
        }

        .dialog-btn-confirm:active {
            transform: scale(0.98);
        }

        @media (max-width: 749px) {
            .container {
                padding: 20px;
            }

            .listing-card {
                flex-direction: column;
                padding: 15px;
                align-items: flex-start;
            }

            .listing-description {
                margin-bottom: 20px;
                white-space: normal;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }

            .listing-image {
                width: 100%;
                height: 200px;
                margin-bottom: 15px;
            }

            .listing-title {
                font-size: 16px;
            }

            .listing-stats {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                width: 100%;
            }

            .stat-item {
                flex-direction: column;
            }

            .stat-label {
                font-size: 12px;
                margin-bottom: 2px;
            }

            .stat-data {
                font-size: 15px;
                font-weight: 600;
            }

            .btn-container {
                display: flex;
                width: 100%;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .confirm-dialog {
                max-width: calc(100% - 40px);
            }
        }

        .flash-message {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 16px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 300px;
    max-width: 500px;
    z-index: 10000;
    animation: slideIn 0.3s ease-out;
    font-size: 14px;
    font-weight: 500;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.flash-message.hiding {
    animation: slideOut 0.3s ease-out forwards;
}

.flash-success {
    background-color: #10b981;
    color: white;
}

.flash-error {
    background-color: #ef4444;
    color: white;
}

.flash-warning {
    background-color: #f59e0b;
    color: white;
}

.flash-info {
    background-color: #3b82f6;
    color: white;
}

.flash-icon::before {
    font-size: 18px;
}

.flash-success .flash-icon::before {
    content: '✓';
}

.flash-error .flash-icon::before {
    content: '✗';
}

.flash-warning .flash-icon::before {
    content: '⚠';
}

.flash-info .flash-icon::before {
    content: 'ℹ';
}

.flash-text {
    flex: 1;
}

.flash-close {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.8;
    transition: opacity 0.2s;
}

.flash-close:hover {
    opacity: 1;
}

@media (max-width: 768px) {
    .flash-message {
        top: 10px;
        right: 10px;
        left: 10px;
        min-width: auto;
        max-width: none;
    }
}

    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <button class="back-btn" onclick="history.back()"> <i class="fa-solid fa-arrow-left"></i></button>
            <div class="header-text">
                <h1>My Listings</h1>
                <p>Manage and track your auction listings</p>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3>Total Listings</h3>
                    <span class="material-symbols-outlined stat-icon" style="color:blue;">
                        package_2
                    </span>
                </div>
                <div class="stat-value"><?= count($items) ?></div>
                <div class="stat-subtitle"><?= $totalActive ?> active, <?= $totalInactive ?> ended</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3>Total Revenue</h3>
                    <i class="fa-solid fa-arrow-trend-up stat-icon" style="color:red;"></i>
                </div>
                <div class="stat-value">$<?= number_format($totalRevenue) ?></div>
                <div class="stat-subtitle">From ended auctions</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3>Total Bids</h3>
                    <i class="fa-solid fa-arrow-trend-up stat-icon" style="color:red;"></i>
                </div>
                <div class="stat-value"><?= number_format($totalBids) ?></div>
                <div class="stat-subtitle">Across all listings</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3>Active Auctions</h3>
                    <i class="fa-regular fa-clock stat-icon" style="color:blue;"></i>
                </div>
                <div class="stat-value"><?= number_format($totalActive) ?></div>
                <div class="stat-subtitle">Currently running</div>
            </div>
        </div>

        <div class="listings-container">
            <?php foreach ($items as $item): ?>
            <div class="listing-card" data-id="<?= $item->id ?>">
                <img src="<?= $item->image ?>" class="listing-image">
                <div class="listing-content">
                    <div class="listing-header">
                        <div>
                            <h2 class="listing-title"><?= $item->title ?></h2>
                            <div class="listing-tags">
                                <span class="tag category"><?= $item->category ?></span>
                                <span class="tag status"><?= $item->is_active? 'Active' : 'Expired' ?></span>
                            </div>
                        </div>
                    </div>
                    <p class="listing-description"><?= $item->description ?></p>
                    <div class="listing-stats">
                        <div class="stat-item">
                            <span class="stat-label">Current Bid</span>
                            <span class="stat-data">$<?= number_format($item->current_bid) ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Total Bids</span>
                            <span class="stat-data"><?= count($item->getBids()) ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Starting Bid</span>
                            <span class="stat-data">$<?= number_format($item->starting_bid) ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Time Left</span>
                            <span class="stat-data item-time" data-end="<?= $item->end_at ?>">loading...</span>
                        </div>
                    </div>

                    <div class='btn-container'>
                        <div>
                            <a href="/items/<?= $item->id ?>" class="btn btn-outline"><i class="fa-regular fa-eye"></i> View Item</a>
                        </div>
                        <?php if ($item->getBidsCount() == 0): ?>
                        <div>
                            <a data-id="<?= $item->id ?>" class="btn btn-outline deleteBtn" onclick="deleteItem(event, <?= $item->id ?>)"><i class="fa-solid fa-trash" style="color:red;"></i> Delete</a>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $item->owner_id && $item->getBidsCount() === 0 && $item->is_active): ?>
                        <div>
                            <a href="/items/<?= $item->id ?>/edit" class="btn btn-outline">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <div class="confirm-dialog-overlay" id="confirmDialogOverlay">
        <div class="confirm-dialog">
            <div class="confirm-dialog-header">
                <h2 id="confirmDialogTitle">Confirm Action</h2>
                <p class="confirm-dialog-message" id="confirmDialogMessage">Are you sure?</p>
            </div>
            <div class="confirm-dialog-footer">
                <button class="dialog-btn dialog-btn-cancel" id="confirmDialogCancel">Cancel</button>
                <button class="dialog-btn dialog-btn-confirm" id="confirmDialogConfirm">Delete</button>
            </div>
        </div>
    </div>

    <script>
        let confirmCallback = null;

        function showConfirmDialog(title, message, onConfirm) {
            const overlay = document.getElementById('confirmDialogOverlay');
            const titleEl = document.getElementById('confirmDialogTitle');
            const messageEl = document.getElementById('confirmDialogMessage');
            const confirmBtn = document.getElementById('confirmDialogConfirm');
            const cancelBtn = document.getElementById('confirmDialogCancel');

            titleEl.textContent = title;
            messageEl.textContent = message;
            confirmCallback = onConfirm;

            overlay.classList.add('active');

            confirmBtn.onclick = () => {
                overlay.classList.remove('active');
                if (confirmCallback) {
                    confirmCallback();
                }
            };

            cancelBtn.onclick = () => {
                overlay.classList.remove('active');
                confirmCallback = null;
            };

            overlay.onclick = (e) => {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                    confirmCallback = null;
                }
            };
        }

        async function deleteItem(e, itemId) {
            e.preventDefault();
            e.stopPropagation();
            
            showConfirmDialog(
                'Delete Item',
                'Are you sure you want to delete this item? This action cannot be undone.',
                async () => {
                    try {
                        const response = await fetch(`/my-listings/${itemId}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            const card = document.querySelector(`[data-id="${itemId}"]`);
                            if (card) {
                                card.remove();
                            }
                            
                            showNotification('Item deleted successfully', 'success');
                            
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showNotification(data.message || 'Failed to delete item', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('An error occurred while deleting the item', 'error');
                    }
                }
            );
        }

        function showNotification(message, type = 'error') {
            const notification = document.createElement('div');
            notification.className = `flash-message flash-${type}`;
            notification.innerHTML = `
                <span class="flash-icon"></span>
                <span class="flash-text">${message}</span>
                <button class="flash-close" onclick="this.parentElement.remove();">&times;</button>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 3000);
        }

        setInterval(() => {
            document.querySelectorAll('.item-time').forEach(timer => {
                const text = timer.dataset.end;
                const endAt = new Date(text.replace(' ', 'T'));
                const now = new Date();
            
                const diff = endAt - now;
            
                if (diff <= 0) {
                    timer.textContent = "00:00:00";
                    return;
                }

                const seconds = Math.floor((diff / 1000) % 60);
                const minutes = Math.floor((diff / 1000 / 60) % 60);
                const hours = Math.floor((diff / 1000 / 60 / 60) % 24);
                const days = Math.floor(diff / 1000 / 60 / 60 / 24);

                timer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            });
        }, 1000);
    </script>
</body>
</html>