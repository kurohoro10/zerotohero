<?php
namespace Application;

use Domain\Contract\UserRepositoryInterface;
use Domain\Contract\PasswordHasherInterface;
use Domain\Contract\TokenGeneratorInterface;
use Domain\Exception\AuthenticationException;

final class AuthService
{
    public function __construct(
        private UserRepositoryInterface $users,
        private PasswordHasherInterface $hasher,
        private TokenGeneratorInterface $tokens
    ) {}

    public function login(string $email, string $password): string
    {
        $user = $this->users->findByEmail($email);

        if (!$user || !$user->isActive()) {
            throw new AuthenticationException('Invalid credentials');
        }

        if (!$this->hasher->verify($password, $user->passwordHash())) {
            throw new AuthenticationException('Invalid credentials');
        }

        return $this->tokens->generate($user);
    }
}