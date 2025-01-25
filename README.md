# Task Management System

This is a Laravel-based task management system designed to help manage tasks, projects, and team assignments with role-based access control. 

## Features

- Task creation and assignment
- Role-based access control using Spatie Laravel Permissions
- Authentication using Sanctum API middleware
- CRUD operations for projects, tasks, and users
- Database seeding

## Installation

To set up the project locally, follow these steps:

### 1. Clone the repository

Clone the repository from GitHub:
git clone https://github.com/muskuVenkatesh/task_management.git

Steps to setup the project:

cd task_manage_system
composer install
cp .env.example .env
php artisan migrate
php artisan db:seed
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

other commands:

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan config:cache























