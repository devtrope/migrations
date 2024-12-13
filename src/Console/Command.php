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
        $output = new Output;
        $command = $arguments[1] ?? null;

        if (! $command) {
            $output->write("No command provided.");
            $output->write("You can use --help to list all the commands available.");
            $output->read();
            exit();
        }

        if ($command === '--help') {
            $output->write("Commands:");
            $output->write(" create <name> Create a new migration");
            $output->write(" migrate Migrate all your migrations");
            $output->read();
            exit();
        }

        if ($command === 'create') {
            /**
             * @var MigrationManager $migrationManager
             */
            $migrationManager = $this->container->get(MigrationManager::class);
            $migrationName = $arguments[2] ?? null;

            if (! $migrationName) {
                $output->write("Please provide a migration name.");
                $output->read();
                exit(1);
            }
    
            if (! ctype_alpha($migrationName)) {
                $output->write("The migration name should be in camel case.");
                $output->read();
                exit(1);
            }
    
            try {
                $output->write($migrationManager->createMigration($migrationName));
                $output->read();
                exit();
            } catch (MigrationPathNotFoundException $e) {
                $output->write($e->getMessage());
                $output->read();
                exit(1);
            }
        }

        if ($command === 'migrate') {
            /**
             * @var MigrationManager $migrationManager
             */
            $migrationManager = $this->container->get(MigrationManager::class);
            $migrationManager->execute();
            $output->write("Migration successfully executed.");
            $output->read();
            exit();
        }

        $output->write("This command does not exist.");
        $output->read();
        exit(1);
    }
}
