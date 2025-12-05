UITS Lost & Found — Reconnect with What You've Lost

## Overview
UITS Lost & Found is a simple, responsive PHP/MySQL web app for managing lost and found items across the University of Information Technology & Sciences (UITS) campus. Students and staff can browse items, search quickly, and post new entries so belongings can find their way back home.

## Features
- Post items: Add a title, description, image, category, and author.
- Browse by category: Quick navigation via the header Categories dropdown.
- Fast search: Live suggestions powered by JavaScript with debounce.
- Item details: Dedicated page per item with author, date, and category.
- Recent items: Sidebar shows the latest posts for quick access.
- Pagination: Clean Bootstrap pagination across listings.
- Admin tools: Create categories, users, and posts via the admin panel.

## Tech Stack
- PHP (procedural) + MySQL
- Bootstrap 5 for UI components
- Font Awesome for icons
- Vanilla JavaScript (live search)

## Folder Structure (high level)
- `index.php`: Home page with hero, featured items, and item grid.
- `header.php` / `footer.php`: Navbar, categories dropdown, and global scripts.
- `sidebar.php`: Search box and recent posts.
- `category.php`, `author.php`, `search.php`, `single.php`: Listing and detail views.
- `admin/`: Admin panel (config, CRUD for posts, categories, users, uploads).
- `css/`: Styles (`bootstrap.min.css`, `font-awesome.css`, `style.css`).
- `images/`: Static assets.
- `database/`: SQL dump(s) to import.
- `js/search.js`: Live-search logic (suggestions, keyboard navigation, clear).

## Setup
1. Requirements:
	- PHP 7.4+ and MySQL 5.7+
	- A local server (XAMPP/LAMP) or any PHP-capable host
2. Clone the repo into your web root.
3. Create a MySQL database (e.g., `lost_and_found`).
4. Import SQL:
	- Use `database/lost.sql` (or `lost/lost.sql` if mirrored) to seed tables.
5. Configure DB connection:
	- Edit `admin/config.php` with your host, username, password, and database.
6. Start the app:
	- Open `http://localhost/path-to-repo/index.php` in your browser.

## Usage
- Browse items on the home page, use the hero search, or filter by category.
- Click a card to view the item details page (`single.php`).
- Use “Post an Item” (top right) from the header to add new items (admin flow).
- Use the sidebar search for quick lookup; suggestions appear as you type.

## Screens (key pages)
- Home (`index.php`): Hero + featured 3 cards + grid + pagination.
- Category (`category.php`): Filtered listing per category.
- Author (`author.php`): Items posted by a specific author.
- Search (`search.php`): Results with pagination.
- Single (`single.php`): Item details with image and metadata.
- Admin (`admin/index.php`): Dashboard for managing content.

## Notes
- Images are stored under `admin/upload/`.
- Categories and users are required for item attribution and filtering.
- Live search suggestions come from `search_suggest.php`.

## Contributing
Pull requests are welcome. Please keep changes focused and consistent with the existing code style. For larger features, open an issue first to discuss your idea.

## License
This project is for educational purposes within UITS. If you plan to reuse it, please credit the original author and contributors.
