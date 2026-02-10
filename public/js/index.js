document.querySelector('.logo-section').addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

window.addEventListener('scroll', () => {
    const header = document.querySelector('.navbar');
    const scrollY = window.scrollY;
    const maxScroll = 300;
    let opacity = 1 - (scrollY / maxScroll) * 0.3;
    if (opacity < 0.9) opacity = 0.9;

    header.style.backgroundColor = `rgba(255, 255, 255, ${opacity})`;
});

const tabs = document.querySelectorAll('.tab');
let currentStatusFilter = 'active';
let isInitialLoad = true;
applyFilters();
isInitialLoad = false;

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
    
    applyFilters();
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
    
    sortItems();
}

function applyFilters() {
    const category = document.getElementById('categoryLabel').textContent.trim();
    const query = document.getElementById('searchInput').value.toLowerCase();

    const items = document.querySelectorAll('.auction-card');
    let visibleCount = 0;

    items.forEach(item => {
        const itemCategory = item.dataset.category;
        const itemTitle = item.dataset.title.toLowerCase();
        const isActive = item.dataset.itemstatus === "1";

        const statusMatch =
            (currentStatusFilter === 'active' && isActive) ||
            (currentStatusFilter === 'ended' && !isActive);

        const categoryMatch =
            category === 'All Categories' || itemCategory === category;

        const searchMatch = itemTitle.includes(query);

        if (statusMatch && categoryMatch && searchMatch) {
            visibleCount++;
            if (isInitialLoad) {
                // On initial load, just show items without animation
                item.style.display = 'block';
                item.classList.remove('hide');
            } else {
                // After initial load, use animation
                item.style.display = 'block';
                void item.offsetWidth;
                item.classList.remove('hide');
            }
        } else {
            if (isInitialLoad) {
                // On initial load, just hide items without animation
                item.style.display = 'none';
                item.classList.add('hide');
            } else {
                // After initial load, use animation
                item.classList.add('hide');
                item.addEventListener('transitionend', () => {
                    if (item.classList.contains('hide')) {
                        item.style.display = 'none';
                    }
                }, { once: true });
            }
        }
    });

    document.getElementById('noItemsMessage').style.display =
        visibleCount === 0 ? 'block' : 'none';
}

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        currentStatusFilter = tab.textContent.includes('Active')
            ? 'active'
            : 'ended';

        applyFilters();
    });
});

document.getElementById('searchInput').addEventListener('input', applyFilters);

function sortItems() {
    const sort = document.getElementById('sortLabel').textContent;
    const auctionContainer = document.getElementById('activeAuctions');
    const items = Array.from(auctionContainer.querySelectorAll('.auction-card'));
    console.log(items);

    items.sort((a, b) => {
        switch(sort) {
            case 'Highest Bid':
                console.log(a.dataset.currentbid);
                return b.dataset.currentbid - a.dataset.currentbid;

            case 'Ending Soon':
                return new Date(a.dataset.end) - new Date(b.dataset.end);
            
            case 'Newest':
                return new Date(b.dataset.start) - new Date(a.dataset.start);
            
            default:
                return 0;
        }
    });

    items.forEach(item => auctionContainer.appendChild(item));

    console.log(items);
}


// Close dropdowns and menu when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.filter-dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('active');
        });
    }
    if (!event.target.closest('.user-icon')) {
        document.getElementById('userMenu').classList.remove('active');
    }
});

// Update countdown timers
function countdownTimer() {
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
}
countdownTimer();
setInterval(1000, countdownTimer);

document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', () => {
        const itemId = button.dataset.item;
        const isFavorited = button.dataset.isfavorited
        fetch('/favorites/toggle', {
            method: 'POST',
            headers: { "Content-Type": "application/json"},
            body: JSON.stringify({itemId, isFavorited})
        })
    })
});

document.getElementById('userIcon').addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('userMenu').classList.toggle('active');
    document.getElementById('notificationPanel').classList.remove('active');
});


document.querySelectorAll('.auction-card').forEach((item) => {
    item.addEventListener('click', function() {
        const id = this.dataset.item_id;
        window.location = `/items/${id}`;
    });
});

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

async function renderNotifications() {
    const notificationList = document.getElementById('notificationList');
    
    const res = await fetch('/notifications/get-notifications');
    let notificationsData = await res.json();

    if (notificationsData.length === 0) {
        document.getElementById('notificationBadge').style.display = 'none';
        notificationList.innerHTML = `
            <div class="notification-empty">
                <i class="fa-regular fa-bell"></i>
                <p>No notifications yet</p>
            </div>
        `;
        return;
    }

    notificationsData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    notificationList.innerHTML = notificationsData.map(notif => {
        const iconClass = notif.type === 'bid' ? 'fa-gavel' : 
                         notif.type === 'comment' ? 'fa-comment' : 
                         notif.type === 'ending' ? 'fa-clock' :
                         notif.type === 'won' ? 'fa-trophy' :
                         notif.type === 'ended' ? 'fa-flag-checkered':
                         'fa-triangle-exclamation';
        
        return `
            <div class="notification-item ${notif.is_read ? '' : 'unread'}" data-itemid="${notif.item_id}" data-id="${notif.id}">
                <div class="notification-icon-wrapper ${notif.type}">
                    <i class="fa-solid ${iconClass}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${notif.title}</div>
                    <div class="notification-message">${notif.message}</div>
                    <div class="notification-item-name">${notif.item_name}</div>
                    <div class="notification-time">
                        ${timeAgo(notif.created_at)}
                        ${!notif.is_read ? '<span class="unread-indicator"></span>' : ''}
                    </div>
                </div>
                <button class="notification-close" onclick="removeNotification(event, ${notif.id})">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
        `;
    }).join('');

    updateBadge(notificationsData);
}

function updateBadge(notificationsData) {
    const unreadCount = notificationsData.filter(n => !n.is_read).length;
    const badge = document.getElementById('notificationBadge');
    
    if (unreadCount > 0) {
        badge.textContent = unreadCount;
        badge.style.display = 'block';
    } else {
        badge.style.display = 'none';
    }
}

function toggleNotificationPanel() {
    const panel = document.getElementById('notificationPanel');
    panel.classList.toggle('active');
}

async function markAllAsRead() {
    await fetch('/notifications/read-all', {
        method: 'POST'
    });
    await renderNotifications();
}

async function clearAllNotifications() {

    await fetch('/notifications/delete-all', {
        method: 'DELETE'
    });
    await renderNotifications();
}


function removeNotification(event, notifyID) {
    event.stopPropagation();
    const item = document.querySelector(`.notification-item[data-id="${notifyID}"]`);
    if (item) item.remove();
    const index = notificationsData.findIndex(n => n.id == notifyID);
    if (index !== -1) {
        notificationsData.splice(index, 1);
        updateBadge(notificationsData);
    }

    fetch(`/notifications/delete/${notifyID}`, {
        method: 'DELETE'
    });

}

document.getElementById('notificationIcon').addEventListener('click', (e) => {
    e.stopPropagation();
    toggleNotificationPanel();
    document.getElementById('userMenu').classList.remove('active');
});

document.getElementById('markAllRead').addEventListener('click', (e) => {
    e.stopPropagation();
    markAllAsRead();
});

document.getElementById('clearAll').addEventListener('click', (e) => {
    e.stopPropagation();
    clearAllNotifications();
});


document.addEventListener('click', (e) => {
    const panel = document.getElementById('notificationPanel');
    const icon = document.getElementById('notificationIcon');
    
    if (!icon.contains(e.target) && !panel.contains(e.target)) {
        panel.classList.remove('active');
    }
});

renderNotifications();
setInterval(() => {
    renderNotifications();
}, 5000);

document.getElementById('notificationList').addEventListener('click', e => {
    const item = e.target.closest('.notification-item');
    if (!item) return;

    if (e.target.closest('.notification-close')) return;

    const notifId = item.dataset.id;
    item.classList.remove('unread');
    const unreadIndicator = item.querySelector('.unread-indicator');
    if (unreadIndicator) unreadIndicator.remove();

    fetch(`/notifications/mark-read/${notifId}`, {
            method: 'POST'
    });

    const itemId = item.dataset.itemid;
    window.location.href = `/items/${itemId}`;
});

function closeFlash() {
    const flash = document.getElementById('flashMessage');
    if (flash) {
        flash.classList.add('hiding');
        setTimeout(() => flash.remove(), 300);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const flash = document.getElementById('flashMessage');
    if (flash) {
        setTimeout(() => closeFlash(), 2000);
    }
});