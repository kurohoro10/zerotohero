<?php
namespace Domain\Entity;

final class User 
{
    public function __construct(
        private int $id,
        private string $email,
        private string $passwordHash,
        private bool $isActive
    ) {}

    public function id(): int { return $this->id; }
    public function email(): string { return $this->email; }
    public function passwordHash(): string { return $this->passwordHash; }
    public function isActive(): bool { return $this->isActive; }
}