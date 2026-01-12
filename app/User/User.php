<?php
/**
 * User Entity
 * -----------
 * Represents a user record.
 */
namespace App\User;

class User
{
    public function __construct(
        public int $id,
        public string $email,
        public string $passworddHash
    ){}
}