<?php
/**
 * Authentication Service
 * ----------------------
 * Handles login state.
 * No HTML.
 */

namespace App\Core;

class Auth
{
    public static function login(int $userId): void
    {
        Session::set("user_id", $userId);
    }

    public static function logout(): void
    {
        Session::destroy();
    }

    public static function check():bool
    {
        return Session::get('user_id') !== null;
    } 

    public static function id(): ?int
    {
        return $session::get('user_id');
    }
}