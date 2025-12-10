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

    items.forEach(item => {
        const itemCategory = item.dataset.category;
        const itemTitle = item.dataset.title.toLowerCase();
        // Check all filters
        const categoryMatch = category === 'All Categories' || itemCategory === category;
        const searchMatch = itemTitle.includes(query);
    
        if (categoryMatch && searchMatch) {
            // Show item with animation
            item.style.display = 'block';
            void item.offsetWidth;
            item.classList.remove('hide');
        } else {
            // Hide item with animation
            item.classList.add('hide');
            item.addEventListener('transitionend', () => {
                if (item.classList.contains('hide')) {
                    item.style.display = 'none';
                }
            }, { once: true });
        }
    });
}

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