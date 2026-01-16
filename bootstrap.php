<?php
use Infrastructure\Config\Env;

spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/src/';
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

Env::load(__DIR__ . '/.env');

require __DIR__ . '/config/database.php';

session_name(Env::get('SESSION_NAME', 'app_session'));
session_start();