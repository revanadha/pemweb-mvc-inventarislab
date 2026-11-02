<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $pdo = null;
    private static bool $connectionAttempted = false;
    private static ?string $lastError = null;

    private static string $host = '127.0.0.1';
    private static string $port = '3306';
    private static string $dbname = 'inventaris_lab';
    private static string $username = 'root';
    private static string $password = '';

    public static function getConnection(): ?PDO {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        if (self::$connectionAttempted) {
            return null;
        }

        self::$connectionAttempted = true;

        try {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', self::$host, self::$port, self::$dbname);
            self::$pdo = new PDO($dsn, self::$username, self::$password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return self::$pdo;
        } catch (PDOException $e) {
            self::$lastError = $e->getMessage();
            return null;
        }
    }

    public static function isConnected(): bool {
        return self::getConnection() !== null;
    }

    public static function getLastError(): ?string {
        return self::$lastError;
    }
}

