<?php
/**
 * Database Connection Utility
 * ---------------------------
 * Provides a shared PDO connection
 * Safe defaults.
 */

namespace App\Core;

use PDO;

class Database
{
    public static function connect(): PDO
    {
        static $pdo;

        if ($pdo === null) {
            $pdo = new PDO(
                "mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME . ";charset=utf8mb4",
                Config::DB_USER,
                Config::DB_PASS,
                [
                    PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                    PDO::AFTER_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return $pdo;
    }
}