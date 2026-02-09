<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <title>Bidz</title>
</head>
<body>
    <?php
        require_once __DIR__ . '/../../includes/flash.php';
        echo renderFlash();
    ?>
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
                <span class="notification-badge" id="notificationBadge" style="display: none;"></span>
                
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
                    <a href="/my-listings" class="user-menu-item">My Listings</a>
                    <a href="/watchlists" class="user-menu-item">Watchlists</a>
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
                data-itemstatus="<?= $item->is_active ?>"
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
</body>
</html>