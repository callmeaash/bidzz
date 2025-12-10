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

            <div class="user-icon" onclick="toggleUserMenu()">
                <i class="fa-regular fa-user"></i>
                <div class="user-menu" id="userMenu">
                    <?php if (!isset($_SESSION['username'])): ?>
                        <a href="/login"><div class="user-menu-item">Login</div></a>
                        <a href="/register"><div class="user-menu-item">Register</div></a>
                    <?php else: ?>
                    <div class="user-menu-header">
                        <h3><?= $_SESSION['username'] ?></h3>
                        <p><?= $_SESSION['email'] ?></p>
                    </div>
                    <div class="user-menu-item">My Bids</div>
                    <div class="user-menu-item">My Listings</div>
                    <div class="user-menu-item">Watchlists</div>
                    <a href="/logout">
                        <div class="user-menu-item">
                            <i class="fa-solid fa-arrow-right-from-bracket logout-icon"></i>
                            Logout
                        </div>
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

        <div class="auction-grid" id="activeAuctions">
            <?php foreach($items as $item): ?>
            <div class="auction-card"
                data-category="<?= $item->category ?>"
                data-title="<?= $item->title ?>"
                data-end="<?= $item->end_at ?>"
                data-start="<?= $item->created_at ?>"
                data-currentbid="<?= $item->current_bid ?>"
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
                                <span class="current-bid">$<?= $item->current_bid ?></span>
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
                        <button class="view-btn">
                            <i class="fa-solid fa-eye eye-icon"></i>
                            <span>View</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="/js/index.js"></script>
</body>
</html>