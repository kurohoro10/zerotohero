<?php
namespace Infrastructure\Database;

use PDO;

final class Seeder
{
    public function __construct(private PDO $db) {}

    public function seed(): void
    {
        $this->seedAdminUser();
    }

    private function seedAdminUser(): void
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM users WHERE email = :email"
        );
        $stmt->execute(['email' => 'admin@example.com']);

        if ($stmt->fetchColumn() > 0) {
            echo "ℹ Admin user already exists\n";
            return;
        }

        $this->db->prepare(
            "INSERT INTO users (email, password, is_active)
            VALUES (:email, :password, 1)"
        )->execute([
            'email'    => 'admin@example.com',
            'password' => password_hash('admin123', PASSWORD_BCRYPT),
        ]);

        echo "✔ Admin user seeded (admin@example.com / admin123)\n";
    }
}