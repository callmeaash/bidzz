<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=trophy" />
    <title>My Bids</title>
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
            background-color: #fff;
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
            padding: 5px 10px;
        }

        .header-content h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .header-content p {
            font-size: 14px;
            color: #888;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-description {
            font-size: 14px;
            color: #888;
        }

        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            background: #fff;
            padding: 8px;
            border-radius: 12px;
            width: fit-content;
        }

        .tab {
            padding: 10px 20px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .tab.active {
            background: #f5f5f5;
            color: #333;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .bid-item {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 30px;
            align-items: start;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
        }
        .bid-item:hover {
            cursor: pointer;
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.12);

        }

        .bid-image {
            width: 200px;
            height: 100%;
            border-radius: 12px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .bid-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .bid-details {
            flex: 1;
        }

        .bid-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .bid-category-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .bid-category {
            font-size: 14px;
            color: #888;
        }

        .bid-prices {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 10px;
            align-items: start;
        }

        .price-group label {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 4px;
        }

        .price-value {
            font-size: 24px;
            font-weight: 600;
        }

        .price-value.your-bid {
            color: #4caf50;
        }

        .price-value.current-bid {
            color: #333;
        }

        .bid-meta {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: #888;
            margin-bottom: 10px;
        }

        .bid-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alert {
            background: #fff3cd;
            color: #856404;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
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

        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-winning {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-won {
            background: #e3f2fd;
            color: #1565c0;
        }

        .badge-outbid {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-lost {
            background: #ffebee;
            color: #c62828;
        }

        .placeholder-image {
            width: 100%;
            height: 100%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: #bbb;
        }

        @media (max-width: 1024px) {
            .container {
                padding: 30px 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .bid-item {
                grid-template-columns: 150px 1fr;
                gap: 20px;
                padding: 20px;
            }

            .bid-image {
                width: 150px;
                height: 150px;
            }

            .bid-prices {
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 16px 20px;
            }

            .header-content h1 {
                font-size: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
                margin-bottom: 30px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 28px;
            }

            .tabs {
                overflow-x: auto;
                width: 100%;
                padding: 6px;
            }

            .tab {
                padding: 8px 16px;
                font-size: 13px;
                white-space: nowrap;
            }

            .bid-item {
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 20px;
            }

            .bid-image {
                width: 100%;
                height: 200px;
            }

            .bid-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .bid-category-row {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .bid-title {
                font-size: 18px;
            }

            .bid-prices {
                display: flex;
                justify-content: space-between;
            }

            .price-value {
                font-size: 20px;
            }

            .bid-meta {
                flex-wrap: wrap;
                font-size: 13px;
            }

            .bid-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 12px 16px;
            }

            .header-content h1 {
                font-size: 18px;
            }

            .header-content p {
                font-size: 13px;
            }

            .container {
                padding: 20px 16px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-value {
                font-size: 24px;
            }

            .stat-description {
                font-size: 13px;
            }

            .section-title {
                font-size: 16px;
            }

            .bid-item {
                padding: 16px;
            }

            .bid-title {
                font-size: 16px;
            }

            .bid-category {
                font-size: 13px;
            }

            .price-value {
                font-size: 18px;
            }

            .status-badge {
                font-size: 12px;
                padding: 5px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-btn" onclick="history.back()"> <i class="fa-solid fa-arrow-left"></i></button>
        <div class="header-content">
            <h1>My Bids</h1>
            <p>Track your bidding activity</p>
        </div>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3>Active Bids</h3>
                    <div class="stat-icon"><i class="fa-regular fa-clock" style="color:blue;"></i></div>
                </div>
                <div class="stat-value">3</div>
                <div class="stat-description"><?= $winning ?> winning, <?= $outbid ?> outbid</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3>Auctions Won</h3>
                    <div class="stat-icon">
                        <span class="material-symbols-outlined" style="color:green;">trophy</span>
                    </div>
                </div>
                <div class="stat-value"><?= $won ?></div>
                <div class="stat-description">Congratulations!</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3>Total Spent</h3>
                    <i class="fa-solid fa-arrow-trend-up stat-icon" style="color:red;"></i>
                </div>
                <div class="stat-value">$ <?= number_format($totalSpent) ?></div>
                <div class="stat-description">On won items</div>
            </div>
        </div>

        <div class="tabs">
            <button class="tab active">Active Bids (<?=$totalActive?>)</button>
            <button class="tab">Won (<?=$won?>)</button>
            <button class="tab">Lost (<?=$lost?>)</button>
        </div>

        <div id="activeBids" style="display:block;">
        <?php if ($winning || $outbid): ?>
            <?php if ($winning): ?>
                <h2 class="section-title">Winning (<?= $winning ?>)</h2>
                <?php foreach ($items as $item): ?>
                    <?php if ($item['item']->is_active && $item['is_winning']): ?>
                        <div class="bid-item">
                            <div class="bid-image">
                                <img src="<?= htmlspecialchars($item['item']->image) ?>" alt="">
                            </div>
                            <div class="bid-details">
                                <div class="bid-title"><?= htmlspecialchars($item['item']->title) ?></div>
                                <div class="bid-category-row">
                                    <div class="bid-category"><?= htmlspecialchars($item['item']->category) ?></div>
                                    <div class="status-badge badge-winning">↗ Winning</div>
                                </div>
                                <div class="bid-prices">
                                    <div class="price-group">
                                        <label>Your Bid</label>
                                        <div class="price-value your-bid">$<?= number_format($item['last_bid'], 2) ?></div>
                                    </div>
                                    <div class="price-group">
                                        <label>Current Bid</label>
                                        <div class="price-value current-bid">$<?= number_format($item['item']->current_bid, 2) ?></div>
                                    </div>
                                </div>
                                <div class="bid-meta">
                                    <span>⏱ Ends <?= date('M d, Y H:i', strtotime($item['item']->end_at)) ?></span>
                                </div>
                                <div class="bid-actions">
                                    <a href="/items/<?= $item['item']->id ?>" class="btn btn-outline">👁 View Item</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
                    
            <?php if ($outbid): ?>
                <h2 class="section-title" style="margin-top: 40px;">Outbid (<?= $outbid ?>)</h2>
                <?php foreach ($items as $item): ?>
                    <?php if ($item['item']->is_active && !$item['is_winning']): ?>
                        <div class="bid-item">
                            <div class="bid-image">
                                <img src="<?= htmlspecialchars($item['item']->image) ?>" alt="">
                            </div>
                            <div class="bid-details">
                                <div class="bid-title"><?= htmlspecialchars($item['item']->title) ?></div>
                                <div class="bid-category-row">
                                    <div class="bid-category"><?= htmlspecialchars($item['item']->category) ?></div>
                                    <div class="status-badge badge-outbid">⚠ Outbid</div>
                                </div>
                                <div class="alert">
                                    You've been outbid by $<?= number_format($item['item']->current_bid - $item['last_bid'], 2) ?>
                                </div>
                                <div class="bid-prices">
                                    <div class="price-group">
                                        <label>Your Bid</label>
                                        <div class="price-value your-bid">$<?= number_format($item['last_bid'], 2) ?></div>
                                    </div>
                                    <div class="price-group">
                                        <label>Current Bid</label>
                                        <div class="price-value current-bid">$<?= number_format($item['item']->current_bid, 2) ?></div>
                                    </div>
                                </div>
                                <div class="bid-meta">
                                    <span>⏱ Ends <?= date('M d, Y H:i', strtotime($item['item']->end_at)) ?></span>
                                </div>
                                <div class="bid-actions">
                                    <a href="/items/<?= $item['item']->id ?>" class="btn btn-outline">👁 View Item</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>         
        </div>

                    
        <div id="wonBids" style="display:none;">
        <?php if ($won): ?>
            <h2 class="section-title">Won (<?= $won ?>)</h2>
            <?php foreach ($items as $item): ?>
                <?php if (!$item['item']->is_active && $item['has_won']): ?>
                    <div class="bid-item">
                        <div class="bid-image">
                            <img src="<?= htmlspecialchars($item['item']->image) ?>" alt="">
                        </div>
                        <div class="bid-details">
                            <div class="bid-title"><?= htmlspecialchars($item['item']->title) ?></div>
                            <div class="bid-category-row">
                                <div class="bid-category"><?= htmlspecialchars($item['item']->category) ?></div>
                                <div class="status-badge badge-won">🏆 Won</div>
                            </div>
                            <div class="bid-prices">
                                <div class="price-group">
                                    <label>Your Bid</label>
                                    <div class="price-value your-bid">$<?= number_format($item['last_bid'], 2) ?></div>
                                </div>
                                <div class="price-group">
                                    <label>Current Bid</label>
                                    <div class="price-value current-bid">$<?= number_format($item['item']->current_bid, 2) ?></div>
                                </div>
                            </div>
                            <div class="bid-meta">
                                <span>Ended <?= date('M d, Y', strtotime($item['item']->end_at)) ?></span>
                            </div>
                            <div class="bid-actions">
                                <a href="/items/<?= $item['item']->id ?>" class="btn btn-outline">👁 View Item</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        
        <div id="lostBids" style="display:none;">
        <?php if ($lost): ?>
            <h2 class="section-title">Lost (<?= $lost ?>)</h2>
            <?php foreach ($items as $item): ?>
                <?php if (!$item['item']->is_active && $item['has_lost']): ?>
                    <div class="bid-item">
                        <div class="bid-image">
                            <img src="<?= htmlspecialchars($item['item']->image) ?>" alt="">
                        </div>
                        <div class="bid-details">
                            <div class="bid-title"><?= htmlspecialchars($item['item']->title) ?></div>
                            <div class="bid-category-row">
                                <div class="bid-category"><?= htmlspecialchars($item['item']->category) ?></div>
                                <div class="status-badge badge-lost">⊗ Lost</div>
                            </div>
                            <div class="bid-prices">
                                <div class="price-group">
                                    <label>Your Bid</label>
                                    <div class="price-value your-bid">$<?= number_format($item['last_bid'], 2) ?></div>
                                </div>
                                <div class="price-group">
                                    <label>Current Bid</label>
                                    <div class="price-value current-bid">$<?= number_format($item['item']->current_bid, 2) ?></div>
                                </div>
                            </div>
                            <div class="bid-meta">
                                <span>Ended <?= date('M d, Y', strtotime($item['item']->end_at)) ?></span>
                            </div>
                            <div class="bid-actions">
                                <a href="/item.php?id=<?= $item['item']->id ?>" class="btn btn-outline">👁 View Item</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const activeBids = document.getElementById('activeBids');
        const wonBids = document.getElementById('wonBids');
        const lostBids = document.getElementById('lostBids');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                activeBids.style.display = 'none';
                wonBids.style.display = 'none';
                lostBids.style.display = 'none';

                if (index === 0) activeBids.style.display = 'block';
                if (index === 1) wonBids.style.display = 'block';
                if (index === 2) lostBids.style.display = 'block';
            });
        });
    </script>
</body>
</html>