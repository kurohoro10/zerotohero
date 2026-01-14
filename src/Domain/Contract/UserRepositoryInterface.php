<?php
namespace Domain\Contract;

use Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
}