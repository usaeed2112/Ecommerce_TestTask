# E-Commerce Order Flow (Laravel)

## Project Overview

This project is a simplified E-Commerce system built using Laravel.

The application allows users to view products, add them to a cart, place orders using Cash on Delivery, and allows an admin to manage orders and process refunds.

---

## Implemented Features

### Product & Cart
- View product list
- Add products to cart with quantity
- View cart items
- Cart stored using session

### Checkout (Cash on Delivery)
- Customer enters:
  - Name
  - Email
  - Address
- Product stock is validated before checkout
- Order is created successfully
- Product stock is reduced after order placement

### Admin Order Management
- Admin login using Laravel Breeze
- View all orders
- Mark order as **Completed**
- Mark order as **Refunded**
- Refunded orders automatically restore product stock

---

## Technical Implementation

- Laravel Framework
- Laravel Breeze Authentication
- MVC Architecture
- Object Oriented Design
- Database Relationships:
  - Users
  - Products
  - Orders
  - Order Items

---

## Assumptions

- Cash on Delivery only
- No partial refunds
- Refund applies to full order
- No payment gateway integration
- Basic admin panel for order management

---

## Setup Instructions

### 1. Install Dependencies
```bash
composer install
npm install
npm run build

Copy environment file:

cp .env.example .env

php artisan migrate --seed

php artisan key:generate

php artisan serve

---

## Open in browser:

http://127.0.0.1:8000


## Admin Login
Email: admin@gmail.com
Password: 12345678
