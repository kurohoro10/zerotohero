<?php
/**
 * User Settings
 * -------------
 * Key-value user preferences.
 * Works for themes, layout, notifications, etc.
 */

namespace App\User;

use PDO;

class UserSettings 
{
    public function __construct(
        private PDO $db,
        private int $userId
    ){}

    public function get(string $key, mixed $default = null) 
    {
        $stmt = $this->db_prepare(
            "SELECT value FROM user_settings WHERE user_id = :uid AND `key` = :key"
        );

        $stmt->execute([
            'uid' => $this->userId,
            'key' => $key
        ]);

        return $stmt->fetchColumn() ?: $default;
    }

    public function set(string $key, mixed $value): void
    {
        $stmt = $this->db_prepare(
            "REPLACE INTO user_settings (user_id, `key`, value)
            VALUES (:uid, :key, :value)"
        );

        $stmt->execute([
            'uid'   => $this->userId,
            'key'   => $key,
            'value' => (string)$value
        ]);
    }
}