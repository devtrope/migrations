#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\MigrationManager;

$migrationManager = new MigrationManager();
$command = $argv[1] ?? null;

switch ($command) {
    case 'create':
        $migrationName = $argv[2] ?? null;
        if (! $migrationName) {
            echo "Please provide a migration name.\n";
            exit(1);
        }

        $migrationManager->createMigration($migrationName);
        break;

    case '--help':
        echo "Commands:\n";
        echo " create <name> Create a new migration\n";
        break;
    
    default:
        echo "No command provided.\n";
        echo "You can use --help to list all the commands.\n";
        break;
}