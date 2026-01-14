<?php
namespace Domain\Contract;

interface PasswordHasherInterface
{
    public function verify(string $plain, string $hash): bool;
}