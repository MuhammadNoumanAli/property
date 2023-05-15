<?php

namespace App\Services;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class CustomTokenRepository extends DatabaseTokenRepository implements TokenRepositoryInterface
{
    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $connection
     * @param  string  $table
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  int  $expires
     * @return void
     */
    public function __construct($connection, $table, HasherContract $hasher, $expires = 60)
    {
        parent::__construct($connection, $hasher, $table, $expires);
    }
}
