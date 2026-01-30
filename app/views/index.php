<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <title>Bidz</title>

    <style>
        /* Notification Styles */
        .notification-icon {
            position: relative;
            width: 40px;
            height: 40px;
            background-color: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .notification-icon:hover {
            background-color: #e5e5e5;
        }

        .notification-icon i {
            font-size: 18px;
            color: #333;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: #ef4444;
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .notification-panel {
            position: absolute;
            top: 100%;
            right: 50px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            width: 400px;
            max-height: 600px;
            display: none;
            z-index: 1000;
            overflow: hidden;
            margin-top: 10px;
        }

        .notification-panel.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {          
            .notification-panel {
                right: -40px;
                width: calc(100vw - 50px);
                max-width: 400px;
            }
        }

        .notification-header {
            padding: 20px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .notification-actions {
            display: flex;
            gap: 15px;
        }

        .notification-action-btn {
            background: none;
            border: none;
            color: #666;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.2s;
        }

        .notification-action-btn:hover {
            color: #000;
        }

        .notification-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            gap: 12px;
            transition: background-color 0.2s;
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            background-color: #f8f8f8;
        }

        .notification-item.unread {
            background-color: #f0f7ff;
        }

        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background-color: #3b82f6;
            border-radius: 0 4px 4px 0;
        }

        .notification-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-icon-wrapper.bid {
            background-color: #d1fae5;
        }

        .notification-icon-wrapper.comment {
            background-color: #dbeafe;
        }

        .notification-icon-wrapper.outbid {
            background-color: #fee2e2;
        }

        .notification-icon-wrapper.ending {
            background-color: #fef3c7;
        }

        .notification-icon-wrapper.won {
            background-color: #b8eba2;;
        }

        .notification-icon-wrapper.ended {
            background-color: #e5e7eb;
        }

        .notification-icon-wrapper i {
            font-size: 16px;
        }

        .notification-icon-wrapper.bid i {
            color: #059669;
        }

        .notification-icon-wrapper.comment i {
            color: #3b82f6;
        }

        .notification-icon-wrapper.outbid i {
            color: #dc2626;
        }

        .notification-icon-wrapper.ending i {
            color: #f59e0b;
        }

        .notification-icon-wrapper.won i {
            color: #dba719;
        }

        .notification-icon-wrapper.ended i {
            color: #374151;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .notification-message {
            font-size: 13px;
            color: #666;
            margin-bottom: 4px;
        }

        .notification-item-name {
            font-size: 12px;
            color: #999;
            margin-bottom: 6px;
        }

        .notification-time {
            font-size: 12px;
            color: #999;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .unread-indicator {
            width: 8px;
            height: 8px;
            background-color: #3b82f6;
            border-radius: 50%;
        }

        .notification-close {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .notification-close:hover {
            color: #333;
        }

        .notification-empty {
            padding: 60px 20px;
            text-align: center;
            color: #999;
        }

        .notification-empty i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        .notification-empty p {
            font-size: 14px;
        }

        .tabs {
          display: inline-flex;
          background: #e3e0e0;
          padding: 4px;
          border-radius: 999px;
          margin-bottom: 20px;
        }

        .tab {
          border: none;
          background: transparent;
          padding: 8px 16px;
          border-radius: 999px;
          font-size: 14px;
          font-weight: 500;
          cursor: pointer;
          color: #333;
          transition: all 0.2s ease;
        }

        .tab:hover {
          background: #e6e6e6;
        }

        .tab.active {
          background: #ffffff;
          box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        .no-items {
            width: 100%;
            text-align: center;
            padding: 60px 20px;
            color: #232222;
        }

        .no-items i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.6;
        }

        .no-items p {
            font-size: 16px;
            font-weight: 500;
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
    <div class="navbar">
        <div class="logo-section">
            <div class="logo"><img src="images/logo.png" alt="Logo"></div>
            <div class="logo-text">
                <h1>Bidz</h1>
            </div>
        </div>
        <div class="navbar-actions">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="/listing"><button class="start-selling-btn">Start Selling</button></a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="notification-icon" id="notificationIcon">
                <i class="fa-regular fa-bell"></i>
                <span class="notification-badge" id="notificationBadge">2</span>
                
                <!-- Notification Panel -->
                <div class="notification-panel" id="notificationPanel">
                    <div class="notification-header">
                        <h3>Notifications</h3>
                        <div class="notification-actions">
                            <button class="notification-action-btn" id="markAllRead">
                                <i class="fa-solid fa-check"></i>
                                Mark all read
                            </button>
                            <button class="notification-action-btn" id="clearAll">
                                Clear all
                            </button>
                        </div>
                    </div>
                    <div class="notification-list" id="notificationList">
                        
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="user-icon" id="userIcon">
                <?php if (isset($_SESSION['user_id']) && $user->avatar): ?>
                    <img src="<?= $user->avatar ?>">
                <?php else: ?>
                    <i class="fa-regular fa-user"></i>
                <?php endif; ?>

                <div class="user-menu" id="userMenu">
                    <?php if (!isset($_SESSION['username'])): ?>
                        <a href="/login" class="user-menu-item">Login</a>
                        <a href="/register" class="user-menu-item">Register</a>
                    <?php else: ?>
                    <div class="user-menu-header">
                        <h3><?= $_SESSION['username'] ?></h3>
                        <p><?= $_SESSION['email'] ?></p>
                    </div>
                    <a href="/my-bids" class="user-menu-item">My Bids</a>
                    <a href="/my-listing" class="user-menu-item">My Listings</a>
                    <a href="/watchlist" class="user-menu-item">Watchlists</a>
                    <a href="/me" class="user-menu-item">Settings</a>
                    <a href="/logout" class="user-menu-item">
                        <i class="fa-solid fa-arrow-right-from-bracket logout-icon"></i>
                        Logout
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="search-filter-section">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" placeholder="Search auctions..." id="searchInput">
            </div>
            <div class="filter-dropdown">
                <div class="filter-btn" onclick="toggleDropdown('category')">
                    <i class="fa-solid fa-filter filter-icon"></i>
                    <span class="filter-label" id="categoryLabel">All Categories</span>
                </div>
                <div class="dropdown-menu" id="categoryDropdown">
                    <div class="dropdown-item selected" onclick="selectCategory('All Categories')">
                        <span>All Categories</span>
                    </div>
                    <?php foreach ($uniqueCategories as $category): ?>
                    <div class="dropdown-item" onclick="selectCategory('<?= $category ?>')"><?= $category ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="filter-dropdown">
                <div class="filter-btn" onclick="toggleDropdown('sort')">
                    <i class="fa-solid fa-arrow-down-wide-short filter-icon"></i>
                    <span class="filter-label" id="sortLabel">Ending Soon</span>
                </div>
                <div class="dropdown-menu" id="sortDropdown">
                    <div class="dropdown-item selected" onclick="selectSort('Ending Soon')">
                        <span>Ending Soon</span>
                    </div>
                    <div class="dropdown-item" onclick="selectSort('Highest Bid')">Highest Bid</div>
                    <div class="dropdown-item" onclick="selectSort('Newest')">Newest</div>
                </div>
            </div>
        </div>

        <div class="tabs">
          <button class="tab active">Active Auctions</button>
          <button class="tab">Ended Auctions</button>
        </div>
        <div id="noItemsMessage" class="no-items">
            <i class="fa-regular fa-box-open"></i>
            <p>No items found</p>
        </div>

        <div class="auction-grid" id="activeAuctions">

            <?php foreach($items as $item): ?>
            <div class="auction-card"
                data-category="<?= $item->category ?>"
                data-title="<?= $item->title ?>"
                data-end="<?= $item->end_at ?>"
                data-start="<?= $item->created_at ?>"
                data-currentbid="<?= $item->current_bid ?>"
                data-item_id="<?= $item->id ?>"
                data-item-status="<?= $item->is_active ?>"
            >
                <div class="image-container">
                    <img src="<?= $item->image ?>" alt="<?= $item->title ?>" class="auction-image">
                    
                    <?php if (isset($_SESSION['username'])): ?>
                        <button class="favorite-btn <?= $item->is_favorited ? 'active':'' ?>" data-item="<?= $item->id ?>" data-isfavorited="<?= $item->is_favorited ?>">
                            <i class="<?= $item->is_favorited ? 'fa-solid':'fa-regular' ?> fa-heart heart-icon "></i>
                        </button>
                    <?php endif; ?>
                    <span class="category-badge"><?= $item->category ?></span>
                </div>
                <div class="auction-content">
                    <h3 class="auction-title"><?= $item->title ?></h3>
                    <p class="auction-description"><?= $item->description ?></p>
                    <div class="auction-info">
                        <div class="info-item">
                            <span class="info-label">Current bid</span>
                            <div>
                                <span class="current-bid">$<?= number_format($item->current_bid) ?></span>
                                <span class="bid-count">(<?= $item->getBidsCount() ?>)</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ends in</span>
                            <div class="info-time">
                                <i class="fa-regular fa-clock clock-icon"></i>
                                <span class="info-value" data-end="<?= $item->end_at ?>">
                                    loading...
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="auction-actions">
                        <a href="/items/<?=$item->id?>" class="view-btn">
                            <i class="fa-solid fa-eye eye-icon"></i>
                            <span>View</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="/js/index.js"></script>
<?php
require_once __DIR__ . '/../../includes/flash.php';
echo renderFlash();
?>
</body>
</html>