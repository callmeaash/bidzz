<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=gavel" />
    <title>My Watchlist</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .header {
            background-color: white;
            padding: 20px 40px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .header-content h1 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .header-content p {
            font-size: 14px;
            color: #666;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px;
        }

        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 80px 40px;
            text-align: center;
            margin-bottom: 40px;
        }

        .empty-icon {
            font-size: 70px;
            margin: 0 auto 30px;
            opacity: 0.3;
        }

        .empty-state h2 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .empty-state p {
            color: #666;
            margin-bottom: 30px;
        }

        .browse-btn {
            background: #000;
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            max-width: 1300px;
        }

        .browse-btn:hover {
            background: #333;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .stat-header h3 {
            font-size: 16px;
            font-weight: 500;
            color: #666;
        }

        .stat-icon {
            font-size: 24px;
        }

        .stat-value {
            font-size: 48px;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
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

        .image-wrapper {
            position: relative;
        }

        .listing-image {
            width: 150px;
            height: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        .heart-btn {
            position: absolute;
            top: 10px;
            left: 75%;
            width: 30px;
            height: 30px;
            background: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: background-color 0.2s;
            z-index: 10;
        }

        .fa-heart {
            font-size: 16px;
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

        .bid-actions {
            display: flex;
            gap: 12px;
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


        @media (max-width: 640px) {
            .header {
                padding: 15px 20px;
            }

            .image-wrapper {
                width: 100%;
            }

            .heart-btn {
                left: 80%;
            }

            .container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 36px;
            }

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
                gap: 20px;
                width: 100%;
            }

        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-btn" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></button>
        <div class="header-content">
            <h1>My Watchlist</h1>
            <p id="itemCount"><?= count($items) ?> saved items</p>
        </div>
    </div>

    
    <div class="container">
        <?php if(count($items) === 0): ?>
        <div id="emptyState" class="empty-state">
            <i class="fa-regular fa-heart empty-icon"></i>
            <h2>Your watchlist is empty</h2>
            <p>Start adding items to your watchlist to keep track of auctions you're interested in</p>
            <button class="browse-btn" onclick="window.location.href='/'">Browse Auctions</button>
        </div>
        <?php else: ?>
        <div id="statsGrid" class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3>Total Items</h3>
                    <div class="stat-icon"><i class="fa-regular fa-heart" style="color:red;"></i></div>
                </div>
                <div class="stat-value" id="totalItems"><?= count($items) ?></div>
                <div class="stat-label">In your watchlist</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <h3>Active Auctions</h3>
                    <div class="stat-icon"><i class="fa-regular fa-clock" style="color:blue;"></i></div>
                </div>
                <div class="stat-value" id="activeAuctions">
                    <?= count(array_filter($items, fn($item) => $item->is_active)) ?>
                </div>
                <div class="stat-label">Still available</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <h3>Ending Soon</h3>
                    <div class="stat-icon"><i class="fa-solid fa-gavel" style="color:red;"></i></div>
                </div>
                <div class="stat-value" id="endingSoon"></div>
                <div class="stat-label">In next hour</div>
            </div>
        </div>
        
        <div class="listings-container">
            <?php foreach ($items as $item): ?>
            <div class="listing-card" data-id="<?= $item->id ?>">
                <div class="image-wrapper">
                    <img src="<?= $item->image ?>" class="listing-image">
                    <button class="heart-btn"><i class="fa-solid fa-heart" style="color:red;"></i></button>
                </div>
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
                        <div class="bid-actions">
                            <a href="/items/<?= $item->id ?>" class="btn btn-outline">👁 View Item</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>

        document.querySelectorAll('.listing-card').forEach(item => {
            const heartBtn = item.querySelector('.heart-btn');
            heartBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const itemId = item.dataset.id;
                const isFavorited = true;
                fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: { "Content-Type": "application/json"},
                    body: JSON.stringify({itemId, isFavorited})
                });
                window.location.href = '/watchlist';
            });
        });

        document.querySelectorAll('.listing-card').forEach(item => {
            const id = item.dataset.id;
            item.addEventListener('click', () => {
                window.location.href = `/items/${id}`;
            })
        });

        function countEndingSoon() {
            let count = 0;
            const now = new Date();
            const oneHourFromNow = new Date(now.getTime() + (60 * 60 * 1000));

            document.querySelectorAll('.auction-card').forEach(card => {
                const timeElement = card.querySelector('.time-remaining');
                if (timeElement && !timeElement.textContent.includes('Expired')) {
                    count++;
                }
            });

            document.getElementById('endingSoon').textContent = count;
        }
        countEndingSoon();

        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

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