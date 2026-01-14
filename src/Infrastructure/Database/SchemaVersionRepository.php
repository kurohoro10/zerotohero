<?php
namespace Infrastructure\Database;

use PDO;

final class SchemaVersionRepository
{
    public function __construct(private PDO $db) {}
    
    public function ensureTable(): void
    {
        $this->db->exec(
            "CREATE TABLE IF NOT EXISTS schema_versions (
                `version` INT PRIMARY KEY,
                applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB"
        );
    }

    public function getCurrentVersion(): int
    {
        $stmt = $this->db->query(
            "SELECT MAX(version) as version FROM schema_versions"
        );

        return (int) ($stmt->fetchColumn() ?: 0);
    }

    public function markApplied(int $version): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO schema_versions (version) VALUES (:version)"
        );
        $stmt->execute(['version' => $version]);
    }
}