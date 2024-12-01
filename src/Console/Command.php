<?php

namespace App\Console;

use App\MigrationManager;

class Command
{
    public function run(array $arguments): never
    {
        $command = $arguments[1] ?? null;

        if (! $command) {
            echo "No command provided.\n";
            echo "You can use --help to list all the commands available.\n";
            exit();
        }

        if ($command === '--help') {
            echo "Commands:\n";
            echo " create <name> Create a new migration\n";
            exit();
        }

        if ($command === 'create') {
            $migrationManager = new MigrationManager();
            $migrationName = $arguments[2] ?? null;
            if (! $migrationName) {
                echo "Please provide a migration name.\n";
                exit(1);
            }
    
            if (! ctype_alpha($migrationName)) {
                echo "The migration name should be in camel case.\n";
                exit(1);
            }
    
            $migrationManager->createMigration($migrationName);
            exit();
        }

        echo "This command does not exist.\n";
        exit(1);
    }
}
