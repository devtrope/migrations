<?php

namespace App\Console;

use App\Migrations\MigrationManager;
use App\Exceptions\MigrationPathNotFoundException;
use Psr\Container\ContainerInterface;

class Command
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function execute(array $arguments): never
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
            /**
             * @var MigrationManager $migrationManager
             */
            $migrationManager = $this->container->get(MigrationManager::class);
            $migrationName = $arguments[2] ?? null;

            if (! $migrationName) {
                echo "Please provide a migration name.\n";
                exit(1);
            }
    
            if (! ctype_alpha($migrationName)) {
                echo "The migration name should be in camel case.\n";
                exit(1);
            }
    
            try {
                echo $migrationManager->createMigration($migrationName);
                exit();
            } catch (MigrationPathNotFoundException $e) {
                echo "{$e->getMessage()}\n";
                exit(1);
            }
        }

        if ($command === 'migrate') {
            /**
             * @var MigrationManager $migrationManager
             */
            $migrationManager = $this->container->get(MigrationManager::class);
            $migrationManager->execute();
            echo "Migration successfully executed.\n";
            exit();
        }

        echo "This command does not exist.\n";
        exit(1);
    }
}
