#!/usr/bin/env php
<?php

require __DIR__ . '/../bootstrap.php';

use Infrastructure\Database\SchemaVersionRepository;
use Infrastructure\Database\SchemaMigrator;
use Infrastructure\Database\Seeder;

$command = $argv[1] ?? null;

if (!$command) {
    echo "Usage: \n";
    echo "  php bin/console.php migrate\n";
    echo "  php bin/console.php seed\n";
    exit(1);
}

$versions = new SchemaVersionRepository($pdo);
$migrator = new SchemaMigrator($pdo, $versions);
$seeder   = new Seeder($pdo);

match($command) {
    'migrate' => $migrator->migrate(),
    'seed'    => $seeder->seed(),
    default   => print "Unknown commant\n",
};