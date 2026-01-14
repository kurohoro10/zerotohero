<?php
require __DIR__ . '/../bootstrap.php';

use Infrastructure\Persistence\DatabaseUserRepository;
use Infrastructure\Security\BcryptPasswordHasher;
use Infrastructure\Security\SimpleTokenGenerator;
use Infrastructure\Http\AuthController;
use Application\AuthService;

$users = new DatabaseUserRepository($pdo);
$hasher = new BcryptPasswordHasher();
$tokens = new SimpleTokenGenerator();

$authService = new AuthService($users, $hasher, $tokens);
$controller = new AuthController($authService);

$controller->login();