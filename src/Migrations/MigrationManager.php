<?php

namespace App\Migrations;

use App\Database;
use App\Exceptions\MigrationPathNotFoundException;

class MigrationManager
{
    private string $migrationsPath;
    private Database $database;

    public function __construct(string $migrationsPath = 'migrations/')
    {
        $this->migrationsPath = $migrationsPath;
        $this->database = new Database();
    }

    public function createMigration(string $migrationName): string
    {
        if (! is_dir($this->migrationsPath)) {
            throw new MigrationPathNotFoundException($this->migrationsPath);
        }

        $fileName = $this->migrationsPath . date('YmdHis') . "_{$this->formatMigrationName($migrationName)}.php";
        $templateFolder = "./templates";
        
        /**
         * @var string $migrationContent
         */
        $migrationContent = file_get_contents("{$templateFolder}/Template.php");
        $migrationContent = str_replace("migrationName", $migrationName, $migrationContent);
        file_put_contents($fileName, $migrationContent);
        return "New migration created in {$this->migrationsPath} : {$fileName}\n";
    }

    public function execute(): void
    {
         /**
         * @var list<string> $scannedDirectory
         */
        $scannedDirectory = scandir($this->migrationsPath);
        $migrations = array_diff($scannedDirectory, ['..', '.']);
        
        foreach ($migrations as $migration) {
            require $this->migrationsPath . $migration;

            $className = $this->extractClassName(pathinfo($migration, PATHINFO_FILENAME));
            $className = $this->formatClassName($className);
            
            if (class_exists($className) && is_subclass_of($className, MigrationInterface::class)) {
                $migrationInstance = new $className();
                $database = $this->database->getInstance();
                $stmt = $database->prepare($migrationInstance->change());
                $stmt->execute();
            }
        }
    }

    private function formatMigrationName(string $migrationName): string
    {
        /**
         * @var list<string> $splittedName
         */
        $splittedName = preg_split('/(?=[A-Z])/', $migrationName, -1, PREG_SPLIT_NO_EMPTY);
        $formatted = implode('_', $splittedName);

        return strtolower($formatted);
    }

    private function formatClassName(string $fileName): string
    {
        $className = ucwords(strtr($fileName, ['_' => ' ']));
        $className = str_replace(' ', '', $className);

        return lcfirst($className);
    }

    private function extractClassName(string $fileName): string
    {
        $parts = explode('_', $fileName, 2);
        return $parts[1];
    }
}
