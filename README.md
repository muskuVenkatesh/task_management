# Task Management System Overview

This is a **Task Management System** built with **Laravel** that helps teams manage tasks and projects efficiently. It allows you to:

- Create and assign tasks.
- Organize tasks under projects.
- Control access using **roles** (like Admin, Manager, Team Member).

## How the System Works

1. **Task Creation & Assignment**:
   - **Admins and Managers** can create tasks and assign them to team members.
   - **Team Members** can only see the tasks assigned to them and update their progress.

2. **Projects**:
   - A **Project** can have multiple tasks. Managers and Admins can create and manage projects.

3. **Role-Based Access Control**:
   - The system uses **roles** to control what users can do. The key roles are:
     - **Admin**: Full access to everything.
     - **Manager**: Can create and assign tasks, but can't manage users.
     - **Team Member**: Can only see and update tasks assigned to them.

4. **Sanctum API Authentication**:
   - The system uses **Sanctum** for user authentication, allowing users to log in and interact with the system using tokens (especially useful for mobile apps or frontend apps).

5. **Spatie Role-Based Permissions**:
   - The **Spatie Laravel Permission** package is used to manage user roles and permissions.
   - Each role is given certain **permissions** (like creating tasks, assigning tasks, viewing projects, etc.).
   - The system checks if a user has the right permissions to perform actions.

## Role-Based Access

- **Admins**: Can do everything (create tasks, assign tasks, manage users, etc.).
- **Managers**: Can create and assign tasks, but can't modify user roles.
- **Team Members**: Can only see tasks assigned to them and update their progress.

## Database Relationships

Here are the main relationships between the tables in the Task Management System:

1. **User and Role**:
   - Users can have a role, and roles define what permissions a user has (e.g., Admin, Manager, Team Member).
   - **User** `belongsToMany` **Role** (through the `role_user` pivot table).

2. **Projects and Tasks**:
   - A **Project** can have multiple **Tasks**.
   - **Task** `belongsTo` **Project** (each task is associated with a project).

3. **Tasks and Users (Team Members)**:
   - A **Task** can be assigned to a **User** (Team Member).
   - **Task** `belongsTo` **User** (each task has one assigned team member).

4. **Users and Tasks**:
   - A **User** can have many **Tasks**.
   - **User** `hasMany` **Task** (a team member can be assigned multiple tasks).

5. **Sanctum Authentication**:
   - Users authenticate using **Sanctum** to interact with the system. This provides API token-based authentication for secure access.

6. **Role-Based Permissions**:
   - The system uses **Spatie Laravel Permission** to manage different permissions for roles. For example, an Admin can have full permissions, while a Manager can only assign tasks.

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























