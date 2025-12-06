<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
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
                    <div class="user-menu-item">Settings</div>
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
                <input type="text" placeholder="Search auctions...">
            </div>
            <div class="filter-dropdown">
                <div class="filter-btn" onclick="toggleDropdown('category')">
                    <i class="fa-solid fa-filter filter-icon"></i>
                    <span class="filter-label" id="categoryLabel">All Categories</span>
                </div>
                <div class="dropdown-menu" id="categoryDropdown">
                    <div class="dropdown-item selected" onclick="selectCategory('All Categories')">
                        <span>All Categories</span>
                        <span><i class="fa-solid fa-check"></i></span>
                    </div>
                    <div class="dropdown-item" onclick="selectCategory('Watches')">Watches</div>
                    <div class="dropdown-item" onclick="selectCategory('Photography')">Photography</div>
                    <div class="dropdown-item" onclick="selectCategory('Art')">Art</div>
                    <div class="dropdown-item" onclick="selectCategory('Vehicles')">Vehicles</div>
                    <div class="dropdown-item" onclick="selectCategory('Furniture')">Furniture</div>
                    <div class="dropdown-item" onclick="selectCategory('Jewelry')">Jewelry</div>
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
                        <span><i class="fa-solid fa-check"></i></span>
                    </div>
                    <div class="dropdown-item" onclick="selectSort('Highest Bid')">Highest Bid</div>
                    <div class="dropdown-item" onclick="selectSort('Most Bids')">Most Bids</div>
                    <div class="dropdown-item" onclick="selectSort('Newest')">Newest</div>
                </div>
            </div>
        </div>

        <div class="auction-grid" id="activeAuctions">
            <?php foreach($items as $item): ?>
            <div class="auction-card">
                <div class="image-container">
                    <img src="<?= $item->image ?>" alt="<?= $item->title ?>" class="auction-image">
                    <button class="favorite-btn">
                        <i class="fa-regular fa-heart heart-icon"></i>
                    </button>
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

    <script>

        window.addEventListener('scroll', () => {
            const header = document.querySelector('.navbar');
            const scrollY = window.scrollY;
            const maxScroll = 300;
            let opacity = 1 - (scrollY / maxScroll) * 0.3;
            if (opacity < 0.9) opacity = 0.9;

            header.style.backgroundColor = `rgba(255, 255, 255, ${opacity})`;
        });

        function toggleFavorite(event, button) {
            event.stopPropagation();
            const isActive = button.classList.toggle('active');

            const heart = button.querySelector('i');

            if (isActive) {
                heart.classList.remove('fa-regular');
                heart.classList.add('fa-solid');
            } else {
                heart.classList.remove('fa-solid');
                heart.classList.add('fa-regular');
            }
        }

        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', (event) => {
                toggleFavorite(event, button);
            });
        });

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('active');
        }

        function toggleDropdown(type) {
            const dropdown = document.getElementById(type + 'Dropdown');
            dropdown.classList.toggle('active');
            
            // Close other dropdown
            const otherType = type === 'category' ? 'sort' : 'category';
            document.getElementById(otherType + 'Dropdown').classList.remove('active');
        }

        function selectCategory(category) {
            document.getElementById('categoryLabel').textContent = category;
            
            // Update selected state
            const items = document.querySelectorAll('#categoryDropdown .dropdown-item');
            items.forEach(item => {
                item.classList.remove('selected');
                if (item.textContent.includes(category)) {
                    item.classList.add('selected');
                }
            });
            
            document.getElementById('categoryDropdown').classList.remove('active');
        }

        function selectSort(sort) {
            document.getElementById('sortLabel').textContent = sort;
            
            // Update selected state
            const items = document.querySelectorAll('#sortDropdown .dropdown-item');
            items.forEach(item => {
                item.classList.remove('selected');
                if (item.textContent.includes(sort)) {
                    item.classList.add('selected');
                }
            });
            
            document.getElementById('sortDropdown').classList.remove('active');
        }

        // Close dropdowns and menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.filter-dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('active');
                });
            }
            if (!event.target.closest('.user-icon') && !event.target.closest('.user-menu')) {
                document.getElementById('userMenu').classList.remove('active');
            }
        });

        // Update countdown timers
        setInterval(() => {
            document.querySelectorAll('.info-value').forEach(timer => {
        
                const text = timer.dataset.end;
                const endAt = new Date(text.replace(' ', 'T'));
                const now = new Date();

                const diff = endAt - now;

                if (diff <= 0) {
                    timer.textContent = "Expired";
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