<?php
namespace Infrastructure\Http;

use Application\AuthService;

final class AuthGuard
{
    public function __construct(private AuthService $auth) {}

    public function requireAuth(): void
    {
        if (!$this->auth->check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }
}