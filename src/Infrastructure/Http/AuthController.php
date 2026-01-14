<?php
namespace Infrastructure\Http;

use Application\AuthService;
use Domain\Exception\AuthenticationException;

final class AuthController
{
    public function __construct(private AuthService $auth) {}

    public function login(): void
    {
        try {
            $token = $this->auth->login(
                $_POST['email'] ?? '',
                $_POST['password'] ?? ''
            );

            echo json_encode(['token' => $token]);
        } catch (AuthenticationException) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
        }
    }
}