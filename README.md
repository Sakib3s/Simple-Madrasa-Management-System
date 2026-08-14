# Simple Madrasa Management System

A beginner-friendly PHP 8 + MySQL CRUD application for managing a small madrasa. It uses PDO prepared statements, PHP sessions, Tailwind CSS via CDN, Font Awesome, and vanilla JavaScript.

## Requirements

- PHP 8+
- MySQL 5.7+ or MySQL 8+
- Apache, XAMPP, or Laragon

## Installation

1. Copy the project into your Apache `htdocs` directory.
2. Start Apache and MySQL.
3. Import `database.sql` into MySQL (it creates the `madrasa_management` database and sample data).
4. Open `config/database.php` and set the host, database, username, and password for your local MySQL installation.
5. Open `http://localhost/Simple-Madrasa-Management-System/login.php`.
6. Log in with **username:** `admin` and **password:** `password`.

The default password in `database.sql` is a bcrypt hash created for the demo account. Change it before using this application in production.

## Features

- Session-protected admin login and logout
- Dashboard with live student, teacher, class, attendance, and fee totals
- Student, teacher, and class CRUD
- Search for students and teachers
- Attendance by class and date with duplicate prevention
- Fee payment recording with automatic due amount and status
- Responsive sidebar layout with empty states and flash messages

## Project structure

- `config/database.php`: creates the PDO MySQL connection.
- `includes/auth.php`: redirects guests to the login page.
- `includes/functions.php`: small reusable escaping, redirect, and flash-message helpers.
- `includes/header.php`, `sidebar.php`, `footer.php`: shared page layout.
- `students.php`, `teachers.php`, and `classes.php`: list records and link to forms.
- `*-add.php`, `*-edit.php`, and `*-delete.php`: easy-to-follow CRUD actions.
- `attendance.php` and `attendance-save.php`: attendance form and save operation.
- `fees.php` and `fee-add.php`: fee list and payment form.
- `database.sql`: schema, indexes, relationships, and sample records.

Each feature follows the teaching-friendly flow: HTML form → PHP validation → PDO prepared statement → redirect with a flash message.
