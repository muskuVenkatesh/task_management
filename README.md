Task Management System Overview
This is a Task Management System built with Laravel that helps teams manage tasks and projects efficiently. It allows you to:

Create and assign tasks.
Organize tasks under projects.
Control access using roles (like Admin, Manager, Team Member).
How the System Works
Task Creation & Assignment:

Admins and Managers can create tasks and assign them to team members.
Team Members can only see the tasks assigned to them and update their progress.
Projects:

A Project can have multiple tasks. Managers and Admins can create and manage projects.
Role-Based Access Control:

The system uses roles to control what users can do. The key roles are:
Admin: Full access to everything.
Manager: Can create and assign tasks, but can't manage users.
Team Member: Can only see and update tasks assigned to them.
Sanctum API Authentication:

The system uses Sanctum for user authentication, allowing users to log in and interact with the system using tokens (especially useful for mobile apps or frontend apps).
Spatie Role-Based Permissions:

The Spatie Laravel Permission package is used to manage user roles and permissions.
Each role is given certain permissions (like creating tasks, assigning tasks, viewing projects, etc.).
The system checks if a user has the right permissions to perform actions.
Role-Based Access
Admins: Can do everything (create tasks, assign tasks, manage users, etc.).
Managers: Can create and assign tasks, but can't modify user roles.
Team Members: Can only see tasks assigned to them and update their progress.

## Installation

To set up the project locally, follow these steps:

### 1. Clone the repository
- git clone https://github.com/muskuVenkatesh/task_management.git

## Steps to setup the project:

- cd task_manage_system
- composer install
- cp .env.example .env
- php artisan migrate
- php artisan db:seed
- composer require laravel/sanctum
- php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
- php artisan migrate
- composer require spatie/laravel-permission
- php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
- php artisan migrate

## other commands:

- php artisan cache:clear
- php artisan config:clear
- php artisan route:clear
- php artisan config:cache























