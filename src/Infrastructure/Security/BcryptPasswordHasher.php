<?php
namespace Infrastructure\Security;

use Domain\Contract\PasswordHasherInterface;

final class BcryptPasswordHasher implements PasswordHasherInterface
{
    public function verify(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }
}