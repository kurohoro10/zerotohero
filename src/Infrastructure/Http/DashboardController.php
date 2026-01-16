<?php
namespace Infrastructure\Http;

final class DashboardController
{
    public function index(): void
    {
        echo json_encode(['message' => 'Welcome, authenticated user']);
    }
}