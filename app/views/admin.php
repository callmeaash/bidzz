<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
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
            background: white;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e0e0e0;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }

        .header-title h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .header-title p {
            font-size: 14px;
            color: #666;
        }

        .admin-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .admin-btn:hover {
            background: #b91c1c;
        }

        .tabs {
            background: white;
            padding: 20px 30px 0;
            display: flex;
            gap: 30px;
            border-bottom: 1px solid #e0e0e0;
        }

        .tab {
            background: none;
            border: none;
            padding: 12px 0;
            font-size: 15px;
            cursor: pointer;
            position: relative;
            color: #666;
            font-weight: 500;
        }

        .tab.active {
            color: #333;
            font-weight: 600;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: #333;
        }

        .content {
            padding: 30px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-header h3 {
            font-size: 16px;
            font-weight: 500;
            color: #666;
        }

        .stat-icon {
            color: #999;
            font-size: 20px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stat-detail {
            font-size: 14px;
            color: #666;
        }

        .section {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .section-icon {
            font-size: 20px;
            color: #666;
        }

        .auction-item, .report-item, .user-item {
            display: flex;
            align-items: center;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 12px;
            gap: 16px;
        }

        .auction-item:last-child, .report-item:last-child, .user-item:last-child {
            margin-bottom: 0;
        }

        .item-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-content {
            flex: 1;
        }

        .item-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .item-details {
            font-size: 14px;
            color: #666;
        }

        .item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #666;
            padding: 8px;
            transition: all 0.2s;
            border-radius: 6px;
        }

        .icon-btn:hover {
            color: #333;
            background-color: #f0f0f0;
        }

        .icon-btn.end-item {
            opacity: 1;
        }

        .icon-btn.end-item:hover:not(:disabled) {
            color: #f59e0b;
            background-color: #fffbeb;
        }

        .icon-btn.end-item:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            color: #999;
        }

        .icon-btn.end-item:disabled:hover {
            background-color: transparent;
            color: #999;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge.active {
            background: #1f2937;
            color: white;
        }

        .badge.pending {
            background: #dc2626;
            color: white;
        }

        .badge.resolved {
            background: green;
            color: white;
        }

        .category-badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            background: #f3f4f6;
            color: #333;
            display: inline-block;
        }

        .search-box {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .report-details {
            margin-top: 20px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .detail-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 600;
        }

        .detail-reason {
            font-size: 14px;
            color: #333;
            margin-top: 8px;
        }

        .report-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .btn-primary {
            background: #1f2937;
            color: white;
            flex: 1;
        }

        .btn-outline {
            background: white;
            color: #333;
            border: 1px solid #e0e0e0;
            flex: 1;
        }

        .btn-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 8px;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 600;
            color: #666;
            flex-shrink: 0;
        }

        .user-actions {
            display: flex;
            gap: 12px;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .deactivate-btn {
            background: #fef3c7;
            color: #92400e;
        }

        .activate-btn {
            background: #fef3c7;
            color: green;
        }

        .delete-btn {
            background: #fee2e2;
            color: #991b1b;
        }

        .hidden {
            display: none;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        a {
            text-decoration: none;
            color: inherit;

        }

        @media (max-width: 1024px) {
            .two-column {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 16px 20px;
            }

            .header-title h1 {
                font-size: 20px;
            }

            .header-title p {
                font-size: 13px;
            }

            .admin-btn {
                padding: 8px 16px;
                font-size: 13px;
            }

            .tabs {
                padding: 16px 20px 0;
                gap: 16px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .tab {
                font-size: 14px;
                padding: 10px 0;
                white-space: nowrap;
            }

            .content {
                padding: 20px 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 32px;
            }

            .section {
                padding: 20px 16px;
            }

            .auction-item, .report-item, .user-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 16px;
            }

            .item-image {
                width: 100%;
                height: 120px;
            }

            .item-content {
                width: 100%;
            }

            .item-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .user-actions {
                width: 100%;
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .report-details {
                padding: 16px;
            }

            .detail-row {
                flex-direction: column;
                gap: 12px;
            }

            .detail-row > div:last-child {
                text-align: left !important;
            }

            .report-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .help-btn {
                bottom: 16px;
                right: 16px;
                width: 44px;
                height: 44px;
            }
        }

        
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <div class="header-title">
                <h1>Admin Dashboard</h1>
                <p>Manage auctions, reports, and monitor activity</p>
            </div>
        </div>
        <a href="/admin/logout" class="admin-btn" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: white;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            Logout
        </a>
    </header>

    <nav class="tabs">
        <button class="tab active" data-view="overview">Overview</button>
        <button class="tab" data-view="auctions">All Auctions</button>
        <button class="tab" data-view="reports">Reports</button>
        <button class="tab" data-view="users">Users</button>
    </nav>

    <div class="content">
        <div id="overviewView" class="view">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <h3>Total Auctions</h3>
                        <i class="fa-regular fa-box stat-icon"></i>
                    </div>
                    <div class="stat-value"><?= $totalActive + $totalInactive ?></div>
                    <div class="stat-detail"><?= $totalActive ?> active, <?= $totalInactive ?> ended</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <h3>Total Bids</h3>
                        <i class="fas fa-chart-line stat-icon"></i>
                    </div>
                    <div class="stat-value"><?= $totalBids ?></div>
                    <div class="stat-detail">Avg $<?= number_format($averageSpend, 2) ?> per auction</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <h3>Pending Reports</h3>
                        <i class="fa-regular fa-flag stat-icon"></i>
                    </div>
                    <div class="stat-value"><?= $totalPendingReport ?></div>
                    <div class="stat-detail"><?= $totalReport ?> total reports</div>
                </div>
            </div>

            <div class="two-column">
                <div class="section">
                    <div class="section-header">
                        <i class="fa-regular fa-clock section-icon"></i>
                        <h2>Active Auctions</h2>
                    </div>
                    <?php 
                        $activeItems = array_filter($items, fn($item) => $item->is_active);
                        $activeItemsSlice = array_slice($activeItems, 0, 2);
                    ?>
                    <?php foreach ($activeItemsSlice as $item): ?>
                    <?php if ($item->is_active): ?>
                    <div class="auction-item">
                        <div class="item-image">
                            <img src="<?= $item->image ?>">
                        </div>
                        <div class="item-content">
                            <div class="item-title"><?= $item->title ?></div>
                            <div class="item-details">$<?= number_format($item->current_bid) ?> • <?= count($item->getBids()) ?>  bids</div>
                        </div>
                        <button class="icon-btn"><a href="/items/<?= $item->id ?>"><i class="fa-regular fa-eye"></a></i></button>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="section">
                    <div class="section-header">
                        <i class="fa-regular fa-flag section-icon"></i>
                        <h2>Recent Reports</h2>
                    </div>

                    <?php
                        $reportsSlice = array_slice($reports ?? [], 0, 2);
                    ?>
                    <?php foreach($reportsSlice as $report): ?>
                    <div class="report-item" onclick="showReportDetail()">
                        <div class="user-avatar" style="width: 48px; height: 48px; font-size: 16px;">  
                            <?= strtoupper(substr($report['reporter_username'], 0, 1)) ?>
                        </div>
                        <div class="item-content">
                            <div class="item-title"><?= $report['item_title'] ?></div>
                            <div class="item-details"><?= $report['reporter_username'] ?> • 3h ago</div>
                        </div>
                        <span class="badge <?= $report['status']=='pending'? 'pending':'resolved'?>"><?= $report['status'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div id="auctionsView" class="view hidden">
            <div class="section">
                <h2 style="margin-bottom: 16px;">All Auctions</h2>
                <input type="text" class="search-box" id="itemSearch" placeholder="Search auctions...">
                
                <?php foreach($items as $item): ?>
                <div class="auction-item" data-id="<?= $item->id ?>" data-title="<?= $item->title ?>">
                    <div class="item-image">
                        <img src="<?= $item->image ?>" alt="">
                    </div>
                    <div class="item-content">
                        <div style="margin-bottom: 8px;">
                            <span class="item-title"><?= $item->title ?></span>
                            <span class="badge active" style="margin-left: 8px;"><?= $item->is_active? 'Active':'Inactive'?></span>
                            <span class="category-badge" style="margin-left: 8px;"><?= $item->category ?></span>
                        </div>
                        <div class="item-details">Current Bid: $<?= $item->current_bid ?> • <?= count($item->getBids()) ?> bids</div>
                        <div class="item-details">End Date: <?= $item->end_at ?></div>
                    </div>
                    <div class="item-actions">
                        <button class="icon-btn"><a href="/items/<?= $item->id ?>"><i class="fa-regular fa-eye"> </a></i></button>
                        <button class="icon-btn delete-item" data-itemid="<?= $item->id ?>"><i class="fa-solid fa-trash" style="color:red;"></i></button>
                        <button class="icon-btn end-item <?= !$item->is_active ? 'disabled' : '' ?>" data-itemid="<?= $item->id ?>" <?= !$item->is_active ? 'disabled' : '' ?> title="<?= !$item->is_active ? 'Auction already ended' : 'End auction' ?>"><i class="fa-solid fa-stop" style="color:#f59e0b;"></i></button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="reportsView" class="view hidden">
            <div class="section">
                <h2 style="margin-bottom: 20px;">Reported Auctions</h2>
                
                <?php foreach($reports as $report): ?>
                <div class="report-container" style="margin-bottom: 20px;">
                <div class="report-item" style="cursor: pointer; background: #f9fafb;"">
                    <i class="fas fa-flag" style="font-size: 20px; color: #dc2626;"></i>
                    <div class="item-content">
                        <div class="item-title"><?= $report['item_title'] ?></div>
                        <div class="item-details">Report ID: #report-<?= $report['id'] ?></div>
                    </div>
                    <span class="badge <?= $report['status']=='pending'? 'pending':'resolved'?>"><?= $report['status'] ?></span>
                </div>

                <div class="report-details hidden">
                    <div class="detail-row">
                        <div>
                            <div class="detail-label">Reported By</div>
                            <div class="detail-value">
                                <span class="user-avatar" style="width: 24px; height: 24px; font-size: 12px; display: inline-flex; vertical-align: middle; margin-right: 8px;"><?= strtoupper(substr($report['reporter_username'], 0, 1)) ?></span>
                                <?= $report['reporter_username'] ?>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div class="detail-label">Reported At</div>
                            <div class="detail-value"><?= $report['created_at'] ?></div>
                        </div>
                    </div>

                    <div style="margin-top: 16px;">
                        <div class="detail-label">Reason</div>
                        <div class="detail-reason">
                            <?= htmlspecialchars($report['reason']) ?>
                            <?= !empty($report['message']) ? ' - ' . htmlspecialchars($report['message']) : '' ?>
                        </div>
                    </div>

                    <div style="margin-top: 20px; padding: 16px; background: white; border-radius: 8px;">
                        <div class="auction-item" style="border: none; padding: 0; margin: 0;">
                            <div class="item-image">
                                <img src="<?= $report['item_image'] ?>" style="width=100%; height=100%; object-fit='cover';">
                            </div>
                            <div class="item-content">
                                <div class="item-title"><?= $report['item_title'] ?></div>
                                <div class="item-details">$<?= number_format($report['item_current_bid']) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="report-actions <?= $report['status'] == 'resolved'? 'hidden': '' ?>">
                        <button class="btn btn-outline">
                            <i class="fas fa-eye"></i>
                            View Auction
                        </button>
                        <button class="btn btn-primary resolve-btn" data-reportid="<?= $report['id'] ?>">
                            <i class="fas fa-check"></i>
                            Resolve
                        </button>
                    </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Users View -->
        <div id="usersView" class="view hidden">
            <div class="section">
                <h2 style="margin-bottom: 16px;">All Users</h2>
                <input type="text" class="search-box" id="userSearch" placeholder="Search users by username">
                
                <?php foreach ($users as $user): ?>
                <div class="user-item" data-username="<?= $user->username ?>">
                    <div class="user-avatar"><?= strtoupper(substr($user->username, 0, 1)) ?></div>
                    <div class="item-content">
                        <div style="margin-bottom: 4px;">
                            <span class="item-title"><?= $user->username ?></span>
                            <span class="badge active" style="margin-left: 8px;"><?= $user->is_active? 'Active': 'Inactive' ?></span>
                        </div>
                        <div class="item-details"><?= $user->email ?></div>
                        <div class="item-details">
                            Joined: <?= $user->created_at ?> &nbsp;&nbsp;
                            Total Bids: <?= $user->getTotalBids() ?> &nbsp;&nbsp;
                            Total Listings: <?= $user->getTotalListings() ?>
                        </div>
                    </div>
                    <div class="user-actions">
                        <button class="action-btn userStatusBtn <?= $user->is_active? 'deactivate-btn': 'activate-btn' ?>" data-userid="<?= $user->id ?>">
                            <?php if ($user->is_active): ?>
                                <i class="fas fa-user-slash"></i>
                                Deactivate
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                                Activate
                            <?php endif; ?>
                        </button>
                        <button class="action-btn delete-btn" data-userid="<?= $user->id ?>">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const view = tab.dataset.view;
                document.querySelectorAll('.view').forEach(v => v.classList.add('hidden'));
                document.getElementById(view + 'View').classList.remove('hidden');
            });
        });

        document.querySelectorAll('.report-item').forEach(item => {
            item.addEventListener('click', () => {
                const details = item.nextElementSibling;
                if (!details || !details.classList.contains('report-details')) return;
                                    
                document.querySelectorAll('.report-details').forEach(detail => {
                    if (detail !== details) {
                        detail.classList.add('hidden');
                    }
                });
                                    
                details.classList.toggle('hidden');
            });
        });
        
        function resolveReport() {
            if (confirm('Are you sure you want to resolve this report?')) {
                alert('Report resolved successfully!');
                const reportCountSpan = document.getElementById('reportCount');
                reportCountSpan.textContent = '(1)';
                document.querySelector('[data-view="reports"]').innerHTML = 'Reports <span id="reportCount">(1)</span>';
                
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelector('[data-view="overview"]').classList.add('active');
                document.querySelectorAll('.view').forEach(v => v.classList.add('hidden'));
                document.getElementById('overviewView').classList.remove('hidden');
            }
        }

        document.getElementById('usersView').addEventListener('click', function (e) {
            const btn = e.target.closest('.userStatusBtn');
            if (!btn) return;
            if (!confirm('Are you sure you want to change user active status?')) return;
            const userId = btn.dataset.userid;
            const formData = new FormData();
            formData.append('user_id', userId);
            
            fetch('/admin/toggle-user-status', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                const userItem = btn.closest('.user-item');
                const badge = userItem.querySelector('.badge');

                badge.textContent = data.is_active ? 'Active' : 'Inactive';
                if (data.is_active) {
                    btn.classList.remove('activate-btn');
                    btn.classList.add('deactivate-btn');
                } else {
                    btn.classList.remove('deactivate-btn');
                    btn.classList.add('activate-btn');
                }
                btn.innerHTML = data.is_active 
                    ? "<i class='fa-solid fa-user-slash'></i> Deactivate" 
                    : "<i class='fa-solid fa-user'></i> Activate";
            })
            .catch(() => alert("Failed to deactive the user"));
        });


        document.getElementById('usersView').addEventListener('click', function (e) {
            const deleteBtn = e.target.closest('.delete-btn');
            if (!deleteBtn) return;
            if (!confirm('Are you sure you want to delete this user?')) return;

            const userItem = deleteBtn.closest('.user-item');
            const userId = deleteBtn.dataset.userid;
            fetch(`/admin/delete-user/${userId}`, {
                method: 'DELETE'
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    userItem.remove();
                }
                else {
                    alert(data.message || 'Failed to delete the user');
                }
            })
            .catch(() => {
                alert("Failed to delete the user");
            });
        });

        document.getElementById('auctionsView').addEventListener('click', function (e) {
            const deleteBtn = e.target.closest('.delete-item');
            if (deleteBtn) {;
            if (!confirm('Are you sure you want to delete this auction?')) return; 
                const item = deleteBtn.closest('.auction-item');
                const itemId = deleteBtn.dataset.itemid;

                fetch(`/admin/delete-item/${itemId}`, {
                    method: 'DELETE',
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        item.remove();
                    }
                    else {
                        alert(data.message || 'Failed to delete the item');
                    }
                })
                .catch(() => {
                    alert("Failed to delete the item");
                });
            }
            const endBtn = e.target.closest('.end-item');
            if (endBtn && !endBtn.disabled) {
                const item = endBtn.closest('.auction-item');
                const itemId = endBtn.dataset.itemid;

                if (confirm('Are you sure you want to end this auction immediately?')) {
                    fetch(`/admin/end-auction/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            const badge = item.querySelector('.badge');
                            badge.textContent = 'Inactive';
                            endBtn.disabled = true;
                            endBtn.classList.add('disabled');
                            endBtn.title = 'Auction already ended';
                            alert('Auction ended successfully!');
                        } else {
                            alert(data.message || 'Failed to end the auction');
                        }
                    })
                    .catch(() => {
                        alert("Failed to end the auction");
                    });
                }
            }
        });

        document.getElementById('reportsView').addEventListener('click', function (e) {
            const resolveBtn = e.target.closest('.resolve-btn');
            if (!resolveBtn) return;
                
                const reportActions = resolveBtn.closest('.report-actions');
                const reportId = resolveBtn.dataset.reportid;
                
                const reportDetails = resolveBtn.closest('.report-details');
                const reportItem = reportDetails.previousElementSibling;
                const badge = reportItem.querySelector('.badge');

                const formData = new FormData();
                formData.append('report_id', reportId);
                formData.append('status', 'resolved');

                fetch(`/admin/resolve-report/`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        reportActions.classList.add('hidden');
                        badge.textContent = 'resolved';
                        badge.classList.add('resolved')

                    }
                    else {
                        alert(data.message || 'Failed to resolve the error');
                    }
                })
                .catch(() => {
                    alert("Failed to resolve the error");
                });
        });


        function applyUserFilter() {
            const query = document.getElementById('userSearch').value.toLowerCase();
            const users = document.querySelectorAll('#usersView .user-item');

            users.forEach(user => {
                const username = user.dataset.username.toLowerCase();
                const searchMatch = username.includes(query);

                user.classList.toggle('hidden', !searchMatch);
            });
        }

        function applyItemFilter() {
            const query = document.getElementById('itemSearch').value.toLowerCase();

            const items = document.querySelectorAll('#auctionsView .auction-item');
            
            items.forEach(item => {
                const itemTitle = item.dataset.title.toLowerCase();
                const searchMatch = itemTitle.includes(query);

                item.classList.toggle('hidden', !searchMatch);
            });

        }

        document.getElementById('userSearch').addEventListener('input', applyUserFilter)
        document.getElementById('itemSearch').addEventListener('input', applyItemFilter);
    </script>
</body>
</html>