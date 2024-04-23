<?php

declare(strict_types=1);

namespace Code;

class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'driver' => 'mysql',
                'host' => $env['DB_HOST'],
                'database' => $env['DB_DATABASE'],
                'username' => $env['DB_USER'],
                'password' => $env['DB_PASS'],
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]
        ];
    }

    public function __get($name)
    {
        return $this->config[$name] ?? null;
    }
}
