<?php

namespace App;

class MigrationManager
{
    private string $migrationsPath;

    public function __construct(string $migrationsPath = 'migrations/')
    {
        $this->migrationsPath = $migrationsPath;
    }

    public function createMigration(string $migrationName): void
    {
        $fileName = $this->migrationsPath . date('YmdHis') . "_{$migrationName}.php";
        file_put_contents($fileName, null);
        echo "New migration created in {$this->migrationsPath} : {$fileName}\n";
    }
}