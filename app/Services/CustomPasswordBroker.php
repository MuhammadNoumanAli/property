<?php

namespace App\Services;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;

class CustomPasswordBroker extends PasswordBrokerManager
{
    /**
     * Create a token repository instance based on the given configuration.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected function createTokenRepository(array $config)
    {
        $connection = $config['connection'] ?? null;

        return new CustomTokenRepository(
            $this->app['db']->connection($connection),
            $config['table'],
            $this->app['hash'],
            $config['expire']
        );
    }
}
