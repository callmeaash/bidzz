<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/item.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/6565cff68b.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title></title>
</head>
<body data-id="<?= $item->id ?>" data-active="<?= $item->is_active ?>">
    <div class="header">
        <div><button class="back-button" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></button></div>
        <div>
            <h1>Auction Item Details</h1>
            <p class="subtitle"><?= $item->title ?></p>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="report-btn">
            <i class="fa-regular fa-flag"></i>
        </div>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="dialog-overlay" id="reportDialog">
        <div class="dialog-box" onclick="event.stopPropagation()">
            <div class="dialog-header">
                <button class="close-btn">&times;</button>
                <div class="header-icon">
                    <span class="warning-icon">⚠</span>
                </div>
                <h2 class="dialog-title">Report This Listing</h2>
                <p class="dialog-subtitle">Help us keep the marketplace safe</p>
            </div>

            <div class="dialog-content">
                <div class="reporting-item">
                    <div class="reporting-label">Reporting:</div>
                    <div class="reporting-value">Leica M3 Vintage Film Camera</div>
                </div>

                <form id="reportForm">
                    <div class="form-group">
                        <label class="form-label">Reason for Report <span class="required">*</span></label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="reason" value="counterfeit" required>
                                <div class="radio-label">
                                    <div class="radio-title">Counterfeit or Fake Item</div>
                                    <div class="radio-description">This item appears to be counterfeit or fake</div>
                                </div>
                            </label>

                            <label class="radio-option">
                                <input type="radio" name="reason" value="misleading">
                                <div class="radio-label">
                                    <div class="radio-title">Misleading Description</div>
                                    <div class="radio-description">The description does not match the item or is deceptive</div>
                                </div>
                            </label>

                            <label class="radio-option">
                                <input type="radio" name="reason" value="inappropriate">
                                <div class="radio-label">
                                    <div class="radio-title">Inappropriate Content</div>
                                    <div class="radio-description">Contains offensive or inappropriate content</div>
                                </div>
                            </label>

                            <label class="radio-option">
                                <input type="radio" name="reason" value="stolen">
                                <div class="radio-label">
                                    <div class="radio-title">Stolen Property</div>
                                    <div class="radio-description">This item may be stolen</div>
                                </div>
                            </label>

                            <label class="radio-option">
                                <input type="radio" name="reason" value="spam">
                                <div class="radio-label">
                                    <div class="radio-title">Spam or Scam</div>
                                    <div class="radio-description">This listing appears to be spam or a scam</div>
                                </div>
                            </label>

                            <label class="radio-option">
                                <input type="radio" name="reason" value="other">
                                <div class="radio-label">
                                    <div class="radio-title">Other</div>
                                    <div class="radio-description">Other reason not listed above</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Additional Details (Optional)</label>
                        <textarea 
                            class="textarea-field" 
                            name="details"
                            placeholder="Provide any additional information that might help us review this report..."
                        ></textarea>
                        <p class="form-note">Your report will be reviewed by our team. False reports may result in account restrictions.</p>
                    </div>
                </form>
            </div>

            <div class="dialog-footer">
                <button class="dialog-btn dialog-btn-cancel">Cancel</button>
                <button class="dialog-btn dialog-btn-submit" id="submitBtn" disabled>Submit Report</button>
            </div>
        </div>
    </div>
    <?php endif ?>

    <div class="container">
        <?php if (!$item->is_active): ?>
            <?php if (!$item->winner_id): ?>
            <div class="unsold-container">
                <div class="avatar unsold-avatar">
                    <div><span class="material-symbols-outlined" style="color:red;">close</span></div>
                </div>
                <h2>No Bids, Item Unsold</h2>
            </div>
            <?php else: ?>
            <div class="winner-container">
                <div class="winner-detail">
                    <div class="avatar trophy-avatar">
                        <span class="material-symbols-outlined">trophy</span>
                    </div>

                    <div class="auction-winner">
                        <div class="winner-label">
                            <span class="label-text">Auction Winner</span>
                            <span class="label-icon">Sold</span>
                        </div>

                        <div class="winner-name">
                            <div class="avatar winner-avatar">
                                <?php if($winner && $winner->avatar): ?>
                                    <img src="<?= $winner->avatar ?>">
                                <?php else: ?>
                                    <?= strtoupper(substr($winner->username, 0, 1)) ?>
                                <?php endif; ?>
                            </div>
                            <span class="name-text"><?= $winner->username ?></span>
                        </div>
                    </div>
                </div>
                <div class="bid-detail">
                    <span class="winning-bid-label">Winning Bid</span>
                    <span class="winning-bid-amount">$<?= number_format($item->current_bid) ?></span>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="main-content">
                <div class="item-summary">
                    <div class="item-image">
                        <img src="<?= $item->image ?>" alt="<?= $item->title ?>">
                    </div>

                    <div class="item-info" style="margin-top: 24px;">
                        <div class="item-title">
                            <h2><?= $item->title ?></h2>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button class="favorite-btn <?= $item->is_favorited ? 'active':'' ?>" data-isfavorited="<?= $item->is_favorited ?>">
                                    <i class="<?= $item->is_favorited ? 'fa-solid':'fa-regular' ?> fa-heart heart-icon "></i>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="seller-info">
                            <div class="avatar seller-avatar">
                                <?= $seller->avatar? "<img src='$seller->avatar'>": "<span><i class='fa-regular fa-user'></i></span>" ?>
                            </div>
                            <span>Sold by <?= $seller->username ?></span>
                        </div>
                        <p class="description">
                            <?= $item->description ?>
                        </p>
                    </div>

                    <div class="bid-history-container" style="margin-top: 24px;">
                        <div class="bid-history-title">
                            <i class="fa-solid fa-chart-line" style="color:orange;"></i>
                            <h3>Bid History</h3>
                        </div>
                        <div id="bidHistory">

                        </div>
                    </div>
                </div>
                
                <div class="bid-panel">
                    <div class="time-remaining">
                        <i class="fa-regular fa-clock"></i> Time remaining
                    </div>
                    <div class="countdown" id="countdown" data-end="<?= $item->end_at ?>"></div>

                    <div class="bid-info-item">
                        <div class="bid-label">Current Bid</div>
                        <div class="bid-value" id="currentBid">$<?= number_format($item->current_bid) ?></div>
                        <div class="bid-count"><?= $item->getBidsCount() ?> bids</div>
                    </div>

                    <div class="bid-info-item">
                        <div class="bid-label">Starting Bid</div>
                        <div class="bid-value" style="font-size: 20px;">$<?= number_format($item->starting_bid) ?></div>
                    </div>

                    <?php if (!$item->is_active): ?>
                        <div class="auction-ended">
                            <button class="auction-ended-btn">
                                Auction Ended
                            </button>
                            <p>The auction has concluded</p>
                        </div>
                    <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $item->owner_id): ?>
                    <form action="/items/<?= $item->id ?>/bid" method="post" id="bidForm">
                        <div class="bid-input-container">
                            <div class="bid-label">Your Bid Amount</div>
                            <div class="bid-input">
                                <span>$</span>
                                <input type="number" name="bid-amount" id="bidInput" data-current_bid="<?= $item->current_bid ?>"/>
                            </div>
                            <div class="minimum-bid" style="<?= $invalidBid? 'color:red;': ''?>">Minimum bid: $<?= $item->current_bid+1 ?></div>

                            <button type="submit" class="place-bid-btn">
                                <i class="fa-solid fa-gavel"></i> Place Bid
                            </button>
                        </div>
                    </form>
                    <?php endif; ?>

                    <div class="auction-details">
                        <div class="detail-row">
                            <span class="detail-label">Auction ID:</span>
                            <span class="detail-value">#<?= $item->id ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Category:</span>
                            <span class="detail-value"><?= $item->category ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">End Date:</span>
                            <span class="detail-value"><?= (new DateTime($item->end_at))->format('Y-m-d') ?></span>
                        </div>
                    </div>
                </div>
            
            <div class="comments-section">
                <h3><i class="fa-regular fa-comment"></i> Comments</h3>
                <?php if (isset($_SESSION['user_id'])): ?>
                <form id="commentForm">
                    <textarea class="comment-input" name="comment" placeholder="Ask a question or leave a comment..."></textarea>
                    <button class="post-comment-btn" type="submit">Post Comment</button>
                </form>
                <?php endif; ?>
                <div id="comments">

                </div>
            </div>
        </div>
    </div>

    <script>
        
        function updateCountdown() {
            const timer = document.querySelector('#countdown');
            const text = timer.dataset.end;
            const endAt = new Date(text.replace(' ', 'T'));
            const now = new Date();

            const diff = endAt - now;

            if (diff <= 0) {
                timer.textContent = "Auction Ended";
                timer.style.color = "red";
                return;
            }
        
            const seconds = Math.floor((diff / 1000) % 60);
            const minutes = Math.floor((diff / 1000 / 60) % 60);
            const hours = Math.floor((diff / 1000 / 60 / 60) % 24);
            const days = Math.floor(diff / 1000 / 60 / 60 / 24);
        
            timer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        updateCountdown();

        // Then start interval
        setInterval(updateCountdown, 1000);

        bidForm = document.getElementById('bidForm')
        if (bidForm){
            bidForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const bidInput = document.getElementById('bidInput').value.trim();
                const currentBid = document.getElementById('bidInput').dataset.current_bid;
                const minimumBid = document.querySelector('.minimum-bid');
                if (bidInput <= currentBid) {
                    minimumBid.style.color = 'red';
                    return;
                }
                const formData = new FormData(this);
                const itemId = document.body.dataset.id;
                fetch(`/items/${itemId}/bid`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    window.location.replace(`/items/${itemId}?t=${Date.now()}`);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        }

        function displayBidHistory(bids) {
            const container = document.querySelector("#bidHistory");
            latestBids = bids.slice(0, 3);
            let html = "";
            latestBids.forEach(bid => {
                html += `
                            <div class="bid-item">
                                <div class="bid-user">
                                    <div class="avatar bid-avatar">
                                        ${bid.avatar 
                                            ? `<img src="${bid.avatar}" alt="${bid.username}">` 
                                            : bid.username[0].toUpperCase()}</div>
                                    <div class="bid-details">
                                        <span class="bid-name">${bid.username}</span>
                                        <span class="bid-time">${timeAgo(bid.created_at)}</span>
                                    </div>
                                </div>
                                <div class="bid-amount">$${new Intl.NumberFormat().format(bid.bid)}</div>
                            </div>
                `
            });
            container.innerHTML = html;
        }

        function loadBidHistory() {
            const id = document.querySelector('body').dataset.id;

            fetch(`/items/${id}/bid`)
                .then(res => res.json())
                .then(bids => {
                    displayBidHistory(bids);
                });
        }

        loadBidHistory();
        setInterval(loadBidHistory, 10000);

        
        function updateCurrentBid() {
            const isActive = document.querySelector('body').dataset.active;
            const id = document.querySelector('body').dataset.id;
            if (!isActive) return; 

            fetch(`/items/${id}/get-current-bid`)
            .then(res => res.json())
            .then(data => {
                const currentBid = document.querySelector('#currentBid');
                const formatted = data.newBid.toLocaleString('en-US', { 
                    maximumFractionDigits: 2 
                });
                currentBid.textContent = `$${formatted}`;
            })
        }

        setInterval(updateCurrentBid, 5000);

        function showComments(comments) {
            const container = document.querySelector("#comments");
            let html = "";
            comments.forEach(comment => {
                html += `
                        <div class="comment">
                            <div class="comment-avatar">
                                ${comment.avatar 
                                    ? `<img src="${comment.avatar}" alt="${comment.username}">` 
                                    : comment.username[0].toUpperCase()}</div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">${comment.username}</span>
                                </div>
                                <p class="comment-text">${comment.comment}</p>
                                <span class="comment-time">${timeAgo(comment.created_at)}</span>
                            </div>
                        </div>
                `
            });
            container.innerHTML = html;
        }
        
        commentForm = document.querySelector('#commentForm');
        if (commentForm) {
            commentForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const commentInput = this.querySelector('.comment-input');
                const commentText = commentInput.value.trim();
                if (!commentText) return;

                const itemId = document.body.dataset.id;

                fetch(`/items/${itemId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ comment: commentText })
                })
                .then(res => res.json())
                .then(comments => {
                    this.querySelector('.comment-input').value = '';
                    showComments(comments);
                })
            })
        }

        function loadComments() {
            const id = document.querySelector('body').dataset.id;

            fetch(`/items/${id}/comment`)
                .then(res => res.json())
                .then(comments => {
                    showComments(comments);
                });
        }

        loadComments();
        setInterval(loadComments, 10000);


        function toggleFavorite(button) {
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

        const button = document.querySelector('.favorite-btn');
        
        if(button) {
            button.addEventListener('click', () => {
                const itemId = document.querySelector('body').dataset.id;
                const isFavorited = button.dataset.isfavorited;
                fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: { "Content-Type": "application/json"},
                    body: JSON.stringify({itemId, isFavorited})
                });
                toggleFavorite(button);
            });
        }
        

        const reportBtn = document.querySelector('.report-btn');
        const reportDialog = document.getElementById('reportDialog');
        const closeDialogBtn = document.querySelector('.close-btn');
        const cancelBtn = document.querySelector('.dialog-btn-cancel');
        const submitBtn = document.getElementById('submitBtn');
        const radioButtons = document.querySelectorAll('input[name="reason"]');

        // Show dialog when report button is clicked
        if (reportBtn) {
            reportBtn.addEventListener('click', () => {
                reportDialog.style.display = 'flex';
            });
        }

        // Close dialog function
        function closeDialog() {
            reportDialog.style.display = 'none';
            // Reset form
            document.getElementById('reportForm').reset();
            submitBtn.disabled = true;
        }

        // Close dialog when X button is clicked
        if (closeDialogBtn) {
            closeDialogBtn.addEventListener('click', closeDialog);
        }

        // Close dialog when Cancel button is clicked
        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeDialog);
        }

        // Close dialog when clicking outside the dialog box
        reportDialog.addEventListener('click', (e) => {
            if (e.target === reportDialog) {
                closeDialog();
            }
        });

        // Enable submit button when any radio is selected
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                submitBtn.disabled = false;
            });
        });

        if (submitBtn) {
            submitBtn.addEventListener('click', async function() {
                const form = document.getElementById('reportForm');
                if (!form.checkValidity()) {
                    alert('Please select a reason for the report');
                    return;
                }

                const formData = new FormData(form);
                const reason = formData.get('reason');
                const details = formData.get('details');

                try {
                    const response = await fetch(`/items/<?= $item->id ?>/report`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ reason, details })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        // Server returned an error
                        alert(`Error: ${data.message || 'Failed to submit report'}`);
                        return;
                    }

                    alert('Report submitted successfully!');
                    closeDialog();
                    form.reset();
                } catch (error) {
                    console.error('Error submitting report:', error);
                    alert('An unexpected error occurred. Please try again later.');
                }
            });
        }

        function timeAgo(dateString) {
            const now = new Date();
            const date = new Date(dateString);
                
            const seconds = Math.floor((now - date) / 1000);
                
            if (seconds < 60) return 'just now';
                
            const intervals = {
                year: 31536000,
                month: 2592000,
                day: 86400,
                hour: 3600,
                minute: 60
            };
        
            for (const [unit, value] of Object.entries(intervals)) {
                const count = Math.floor(seconds / value);
                if (count >= 1) {
                    const rtf = new Intl.RelativeTimeFormat('en', { numeric: 'auto' });
                    return rtf.format(-count, unit);
                }
            }
        
            return 'just now';
        }
    </script>
</body>
</html>