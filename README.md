# Bidz - Online Auction Platform

A full-featured online auction platform built with PHP, MySQL, and vanilla JavaScript. Users can list items, place bids, track auctions, and receive real-time notifications.

## Features

### User Features
- **User Authentication**: Secure registration and login system with password hashing
- **Auction Listings**: Create and manage auction listings with images, descriptions, and categories
- **Bidding System**: Place bids on active auctions with real-time updates
- **Watchlist**: Save favorite items and receive notifications when they're ending soon
- **Notifications**: Real-time notifications for bids, outbids, comments, and auction endings
- **User Profiles**: Customizable profiles with avatars and personal information
- **My Bids**: Track all active, won, and lost bids
- **My Listings**: Manage your auction listings and track performance
- **Comments**: Engage with sellers through item comments
- **Reporting**: Report suspicious or inappropriate listings

### Admin Features
- **Dashboard**: Comprehensive overview of platform statistics
- **User Management**: View, activate/deactivate, and delete user accounts
- **Auction Management**: Monitor and remove auction listings
- **Report Handling**: Review and resolve user reports
- **Analytics**: Track total auctions, bids, and platform activity

### Technical Features
- **Responsive Design**: Mobile-friendly interface that works on all devices
- **Real-time Updates**: Countdown timers and bid updates without page refresh
- **Image Upload**: Secure image handling with validation
- **Search & Filter**: Search auctions by title and filter by category
- **Session Management**: Secure user sessions and authentication
- **Error Logging**: Comprehensive error tracking and logging
- **Cron Jobs**: Automated auction ending and notification system

## Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Icons**: Font Awesome 6.x, Material Symbols
- **Authentication**: Session-based with bcrypt password hashing

## Project Structure
```
bidz/
├── app/
│   ├── controllers/        # Application controllers
│   ├── models/            # Database models
│   ├── views/             # HTML templates
│   └── scripts/           # Cron job scripts
├── includes/
│   ├── auth.php           # Authentication helpers
│   ├── db.php             # Database connection
│   └── utils.php          # Utility functions
├── public/
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   ├── images/            # Static images
│   ├── .htaccess          # Apache rewrite rules
│   └── index.php          # Application entry point
├── logs/                  # Application logs
└── .env                   # Environment configuration
```

## Installation

### Steps

1. **Clone the repository**
```bash
   git clone https://github.com/yourusername/bidz.git
   cd bidz
```

2. **Create the database**
```sql
   CREATE DATABASE bidz;
```

3. **Import the database schema**
```bash
   mysql -u username -p bidz < database/schema.sql
```

4. **Configure environment variables**
   
   Create a `.env` file in the root directory:
```ini
   DB_HOST=localhost
   DB_USER=your_username
   DB_PASSWORD=your_password
   DB_NAME=bidz
```

6. **Configure Apache**
   
   Point your document root to the `public/` directory and ensure mod_rewrite is enabled.

7. **Set up cron jobs** (optional, for automated auction endings)
```bash
   # Run every minute to check ending auctions
   * * * * * php /path/to/bidz/app/scripts/script.php
   
   # Run every 5 minutes to send ending soon notifications
   */5 * * * * php /path/to/bidz/app/scripts/check_ending_auctions.php
```

## Database Schema

### Main Tables
- **users**: User accounts and profiles
- **items**: Auction listings
- **bids**: Bid history
- **comments**: Item comments
- **wishlists**: User watchlists
- **notifications**: User notifications
- **reports**: Item reports

## Usage

### For Users

1. **Register**: Create an account at `/register`
2. **Login**: Sign in at `/login`
3. **Browse Auctions**: View active auctions on the homepage
4. **Place Bids**: Click on an item and place your bid
5. **Create Listing**: Click "Start Selling" to list an item
6. **Track Activity**: Use "My Bids" and "My Listings" to monitor your auctions

### For Admins

1. **Access Admin Panel**: Login with admin credentials and navigate to `/admin`
2. **Monitor Platform**: View statistics and recent activity
3. **Manage Users**: Activate/deactivate or delete user accounts
4. **Handle Reports**: Review and resolve user reports
5. **Moderate Content**: Remove inappropriate auction listings

## API Endpoints

While this is primarily a server-rendered application, it includes several AJAX endpoints:

- `POST /favorites/toggle` - Toggle watchlist status
- `GET /notifications/get-notifications` - Fetch user notifications
- `POST /notifications/mark-read/{id}` - Mark notification as read
- `POST /items/{id}/bid` - Place a bid
- `POST /items/{id}/comment` - Add a comment
- `GET /items/{id}/get-current-bid` - Get current bid amount

## Roadmap

- [ ] Payment gateway integration
- [ ] Email notifications
- [ ] Advanced search filters
- [ ] Auction categories with subcategories
- [ ] Live bidding with WebSockets
- [ ] Multi-language support

