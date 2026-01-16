<?php
require __DIR__ . '/../bootstrap.php';

use Infrastructure\Persistence\DatabaseUserRepository;
use Infrastructure\Security\BcryptPasswordHasher;
use Infrastructure\Http\AuthController;
use Infrastructure\Http\AuthGuard;
use Infrastructure\Http\DashboardController;
use Application\AuthService;

$users  = new DatabaseUserRepository($pdo);
$hasher = new BcryptPasswordHasher();

$authService = new AuthService($users, $hasher);

$authController = new AuthController($authService);
$guard          = new AuthGuard($authService);
$dashboard      = new DashboardController();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace('/index.php', '', $uri);
$uri = rtrim($uri, '/');

if ($uri === '' || $uri === '/public') {
    $uri = '/public/login';
}

match ($uri) {
    '/public/login'     => $authController->login(),
    '/public/logout'    => $authController->logout(),
    '/public/dashboard' => (
        $guard->requireAuth() ?? $dashboard->index()
    ),
    default => (
        http_response_code(404) ||
        print json_encode(['error' => 'Not Found'])
    )
};