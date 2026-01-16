<?php
namespace Application;

use Domain\Contract\UserRepositoryInterface;
use Domain\Contract\PasswordHasherInterface;
use Domain\Exception\AuthenticationException;

final class AuthService
{
    public function __construct(
        private UserRepositoryInterface $users,
        private PasswordHasherInterface $hasher
    ) {}

    public function login(string $email, string $password): void
    {
        $user = $this->users->findByEmail($email);

        if (!$user || !$user->isActive()) {
            throw new AuthenticationException('Invalid credentials');
        }

        if (!$this->hasher->verify($password, $user->passwordHash())) {
            throw new AuthenticationException('Invalid credentials');
        }

        $_SESSION['user_id'] = $user->id();
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
}