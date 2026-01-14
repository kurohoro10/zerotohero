<?php
namespace Infrastructure\Database;

use PDO;

final class SchemaMigrator
{
    public function __construct(
        private PDO $db,
        private SchemaVersionRepository $versions
    ) {}

    public function migrate(): void
    {
        $this->versions->ensureTable();
        $current = $this->versions->getCurrentVersion();

        $migrations = [
            1 => fn() => $this->createUsersTable(),
        ];

        foreach ($migrations as $version => $migration) {
            if ($version > $current) {
                $this->db->beginTransaction();

                try {
                    $migration();
                    $this->versions->markApplied($version);
                    $this->db->commit();

                    echo "✔ Applied migration v{$version}\n";
                } catch (\Throwable $e) {
                    $this->db->rollBack();
                    throw $e;
                }
            }
        }
    }

    private function createUsersTable(): void
    {
        $this->db->exec(
            "CREATE TABLE users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }
}