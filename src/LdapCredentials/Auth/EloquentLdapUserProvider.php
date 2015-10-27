<?php

namespace LdapCredentials\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class EloquentLdapUserProvider extends EloquentUserProvider
{
    use ValidateLdapCredentials;

    /**
     * The LDAP config.
     *
     * @var array
     */
    protected $ldapConfig;

    /**
     * Create a new Eloquent LDAP user provider.
     *
     * @param  array $ldapConfig
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct($ldapConfig, HasherContract $hasher, $model)
    {
        parent::__construct($hasher, $model);
        $this->ldapConfig = $ldapConfig;
    }
}
