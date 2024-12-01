<?php

namespace App;

use App\Exceptions\MigrationPathNotFoundException;

class MigrationManager
{
    private string $migrationsPath;

    public function __construct(string $migrationsPath = 'migrations/')
    {
        $this->migrationsPath = $migrationsPath;
    }

    public function createMigration(string $migrationName): string
    {
        if (! is_dir($this->migrationsPath)) {
            throw new MigrationPathNotFoundException($this->migrationsPath);
        }

        $fileName = $this->migrationsPath . date('YmdHis') . "_{$this->formatMigrationName($migrationName)}.php";
        $templateFolder = dirname(__DIR__) . "/templates";
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
        $database = new Database();
        $database = $database->connect();
        $stmt = $database->prepare("CREATE TABLE users (id int, name varchar(255))");
        $stmt->execute();
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
}
