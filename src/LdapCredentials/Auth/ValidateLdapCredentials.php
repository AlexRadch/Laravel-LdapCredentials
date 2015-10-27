<?php

namespace LdapCredentials\Auth;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

/**
 * 
 */
trait ValidateLdapCredentials
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        $ldap_conn = ldap_connect($this->ldapConfig['host'], $this->ldapConfig['port']);
        $ldap_bind = ldap_bind($ldap_conn, $this->ldapConfig['user'], $this->ldapConfig['password']);
        try
        {
            // Find By Email
            $escEmail = ldap_escape($email, '', LDAP_ESCAPE_FILTER);
            $filter = "(&(uid=*)(|(mail=". $escEmail. ")".
                "(gosaMailAlternateAddress=". $escEmail. ")))";
            $sr = ldap_search($ldap_conn, $this->ldapConfig['base'], $filter, []);
            if (!$sr)
                return false;

            $conn = ldap_connect($this->ldapConfig['host'], $this->ldapConfig['port']);

            $entry = ldap_first_entry($ldap_conn, $sr);
            while ($entry)
            {
                $dn = ldap_get_dn($ldap_conn, $entry);

                // Check Credentials
                // remove warnings for incorrect passwords
                $level = error_reporting();
                error_reporting($level & ~E_WARNING);
                try
                {
                    $bind = ldap_bind($conn, $dn, $password);
                    if ($bind)
                    {
                      // successful
                      ldap_unbind($conn);
                      return true;
                    }
                }
                finally
                {
                    // restore warnings
                    error_reporting($level);
                }
                $entry = ldap_next_entry($ldap_conn, $entry);
            }
        }
        finally
        {
          ldap_unbind($ldap_conn);
        }
        return false;
    }
}
