<?php

namespace Robso\PDO\Infrastructure\Persistence;

use PDO;

class ConnectionDatabase
{
    public static function createConnection(): PDO
    {
        $databasePath = __DIR__ . '/../../../database.sqlite';
        return new PDO('sqlite:' . $databasePath);
    }
}