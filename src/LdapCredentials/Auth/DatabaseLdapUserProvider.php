<?php

namespace LdapCredentials\Auth;

use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class DatabaseLdapUserProvider extends DatabaseUserProvider
{
    use ValidateLdapCredentials;

    /**
     * The LDAP config.
     *
     * @var array
     */
    protected $ldapConfig;

    /**
     * Create a new database LDAP user provider.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $conn
     * @param  array $ldapConfig
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $table
     * @return void
     */
    public function __construct(ConnectionInterface $conn, $ldapConfig, HasherContract $hasher, $table)
    {
        parent::__construct($conn, $hasher, $model);
        $this->ldapConfig = $ldapConfig;
    }
}
