<?php

namespace App\Migrations;

use App\Database;

class Migration implements MigrationInterface
{
    public string $tableName;
    public array $columns;
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function change(): void
    {
    }

    public function table(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function addColumn(string $columnName, string $columnType): self
    {
        $this->columns[$columnName] = $columnType;
        return $this;
    }

    public function create(): void
    {
        $columns = [];

        foreach ($this->columns as $key => $value) {
            $columns[] = "{$key} {$value}";
        }

        $columns = join(', ', $columns);

        $database = $this->database->getInstance();
        $stmt = $database->prepare("CREATE TABLE {$this->tableName} ({$columns})");
        $stmt->execute();
    }
}
