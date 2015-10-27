<?php

namespace LdapCredentials\Auth;

use Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::extend('databaseLdap', self::createDatabaseLdapProvider);

        Auth::extend('eloquentLdap', self::createEloquentLdapProvider);
    }

    /**
     * Create an instance of the database LDAP user provider.
     *
     * @param  $app
     * @return \LdapCredentials\Auth\DatabaseLdapUserProvider
     */
    private static function createDatabaseLdapProvider($app)
    {
        $connection = $app['db']->connection();

        $config = $this->app['config'];

        // When using the basic database user provider, we need to inject the table we
        // want to use, since this is not an Eloquent model we will have no way to
        // know without telling the provider, so we'll inject the config value.
        $table = $config['auth.table'];

        $ldap = $config['auth.ldap'];

        return new DatabaseLdapUserProvider($connection, $ldap, $app['hash'], $table);
    }

    /**
     * Create an instance of the Eloquent LDAP user provider.
     *
     * @param  $app
     * @return \LdapCredentials\Auth\EloquentLdapUserProvider
     */
    private static function createEloquentLdapProvider($app)
    {
        $config = $app['config'];

        $ldap = $config['auth.ldap'];
        $model = $config['auth.model'];

        return new EloquentLdapUserProvider($ldap, $app['hash'], $model);
    }
}
