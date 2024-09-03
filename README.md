# Library Management System Documentation

## Overview

This is a basic PHP project for managing a small library. Users can register, log in, and interact with the library by making book reservation, which clerks can confirm as borrowed and returned. The system supports different user roles: guest (implicit), member, clerk, and admin, with different access permissions. Additionally, a banned role for blocking members.

## Features

- **User Roles**: Guests register, members reserve books, clerks manage reservations, admins can add/edit/delete books and edit/ban/delete users.
- **Book Management**: Admins can add, edit and delete books.
- **User Management**: Admins can edit roles, ban users, and delete accounts.
- **Reservations**: Members reserve books; clerks/admins confirm, cancel, or mark as borrowed.
- **Manage Reservations**: Clerks/admins handle reservation approvals, cancellations, and returning books.

## Setup

- **Requirements**: PHP, PostgreSQL, Composer.
- **Environment**: Use `.env` for environment variables.
- **Database**: PostgreSQL with `users`, `books`, and `reservations` tables:

```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    total_copies INT NOT NULL,
    available_copies INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reservations (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    book_id INT REFERENCES books(id) ON DELETE CASCADE,
    reservation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    borrow_date TIMESTAMP NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'reserved'
);
```

## Folder Structure

- **public/**: Entry point `index.php`, styling, assets.
- **src/**: Controllers, views.
- **config/**: Database config.
- **vendor/**: Composer dependencies.

## Pages

- **Home**: Banner, brief introduction to the library.
- **Library**: Browse book selection.
- **Login/Register**: User authentication.
- **Profile**: Shows user’s reservations and borrowed books.
- **Manage Reservations**: Clerks/admins manage reservation statuses.
- **Dashboard**: Admin area for managing books and users.

## Security

- **Password Hashing**: `password_hash`.
- **Session Management**: User sessions.
- **Role-Based Access**: Restricts page access based on roles.

## Notes

- Very basic validation, feature set, no automated tests.

This is a basic project meant for learning and simple library management tasks.
