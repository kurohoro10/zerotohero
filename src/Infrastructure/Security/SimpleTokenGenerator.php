<?php
namespace Infrastructure\Security;

use Domain\Entity\User;
use Domain\Contract\TokenGeneratorInterface;

final class SimpleTokenGenerator implements TokenGeneratorInterface
{
    public function generate(User $user): string
    {
        return base64_encode(
            $user->id() . '|' . $user->email() . '|' . time()
        );
    }
}