<?php
namespace Domain\Contract;

use Domain\Entity\User;

interface TokenGeneratorInterface
{
    public function generate(User $user): string;
}