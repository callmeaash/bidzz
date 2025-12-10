# Bidz

A real-time online auction platform where users can bid on items, leave comments, and manage their wishlists.

## Features

- **Real-time Bidding**: Place bids on auction items with live updates
- **Item Listings**: Browse and search through available auction items
- **User Authentication**: Secure registration and login system
- **Wishlist Management**: Save favorite items for later viewing
- **Comments System**: Engage with other users through item comments
- **User Dashboard**: Track your bids and favorite items


## Technology Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Real-time Updates**: AJAX

## Database Setup

The database schema includes the following main tables:
- `users` - User accounts and authentication
- `items` - Auction items
- `bids` - Bid history
- `comments` - Item comments
- `watchlist` - User wishlists/favorites

See `database/DESIGN.md` and `database/erdiagram.png` for detailed schema information.

## Usage

1. **Register an account** at `/register.php`
2. **Login** with your credentials
3. **Browse items** on the homepage
4. **Place bids** on active auction items
5. **Add items to wishlist** for quick access
6. **Leave comments** on items to engage with the community

## Key Components

### Controllers
- Handle application logic and user requests
- Process form submissions and API calls
- Manage session and authentication

### Models
- Represent database entities
- Handle data validation and business logic
- Manage database interactions

### Views
- Render HTML pages
- Display dynamic content
- Provide user interface

### AJAX Endpoints
- Enable real-time updates without page refresh
- Handle asynchronous bid submissions
- Update live auction data

## Future Enhancements

- WebSocket integration for true real-time updates
- Payment gateway integration
- Email notifications
- Advanced search and filtering
- Seller dashboard
- Auction scheduling