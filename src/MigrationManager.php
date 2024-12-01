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
        $fileName = $this->migrationsPath . date('YmdHis') . "_{$this->formatMigrationName($migrationName)}.php";
        $templateFolder = dirname(__DIR__) . "/templates";
        /**
         * @var string $migrationContent
         */
        $migrationContent = file_get_contents("{$templateFolder}/Template.php");
        $migrationContent = str_replace("migrationName", $migrationName, $migrationContent);
        file_put_contents($fileName, $migrationContent);
        echo "New migration created in {$this->migrationsPath} : {$fileName}\n";
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
