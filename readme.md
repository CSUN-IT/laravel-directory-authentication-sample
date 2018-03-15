## Laravel Directory Auth Sample Application

This application exists to provide sample usage for the Composer package located here: https://github.com/csun-metalab/laravel-directory-authentication

This repository implements both the LDAP and local directory authentication functionality in the package. Take a look at the following files:

### General Functionality

* `app/Http/Controllers/AuthController.php`
* `app/Http/Controllers/HomeController.php`
* `app/LocalUser.php` (used by the local database functionality)
* `app/User.php` (used by the LDAP functionality)

### Configuration

* `config/app.php`
* `config/auth.php` (configuration for LDAP-specific authentication)
* `config/dbauth.php` (configuration for database-specific authentication)

### Database Stuff

* `database/migrations/2014_10_12_000000_create_local_users_table.php` (`local_users` table for the local DB functionality)

You can just create a database table called `users` to leverage the LDAP functionality.

* `database/seeds/LocalUsersTableSeeder.php` (creates two local user accounts in the `local_users` table)

### Views

* `resources/views/auth/passwords/reset.blade.php` (LDAP password reset functionality)
* `resources/views/auth/login.blade.php` (login functionality)
* `resources/views/auth/register.blade.php` (LDAP account creation functionality)
* `resources/views/layouts/app.blade.php` (master template)
* `resources/views/home.blade.php` (post-authentication Home screen)

### Routes

* `routes/web.php` (all of the routes are here)