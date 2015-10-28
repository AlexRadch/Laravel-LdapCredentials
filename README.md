# Laravel-LdapCredentials

Extends Database and Eloquent User Authentication Drivers (Laravel framework) 
to validate credentials (email and password) in LDAP.

Password field should be removed from Users table and model.

It does not support to reset password by email and new user registration.

## Installation

1. Run `composer require "alex-rad/laravel-ldap-credentials"` to install package.

2. Add LdapCredentials Service Provider to the `config/app.php` configuration file.

        'providers' => [
            ...
            LdapCredentials\Auth\AuthServiceProvider::class,
            ...
        ],

3. Add LDAP settings to the `config/auth.php` configuration file.

        /*
        |--------------------------------------------------------------------------
        | LDAP Settings
        |--------------------------------------------------------------------------
        |
        | For "databaseLdapCredentials" or "eloquentLdapCredentials" user 
        | authentication drivers.
        |
        */

        'ldap' => [
            'host' => env('LDAP_HOST', 'ldap.server.com'),
            'port' => env('LDAP_PORT', 389),
            'user' => env('LDAP_USER', NULL),
            'password' => env('LDAP_PASSWORD', NULL),
            'base' => env('LDAP_BASE', ''),
        ],

4. Add LDAP settings to the environment `.ENV` configuration file (optional).

        LDAP_HOST=ldap.company.com

5. Switch User Authentication Driver to `databaseLdapCredentials` or 
    `eloquentLdapCredentials` driver in `config/auth.php` configuration file.

        'driver' => 'eloquentLdapCredentials',

6. Remove reset password by email and new user registration functions from 
    application.
