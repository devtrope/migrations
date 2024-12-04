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
        $this->columns = [];
        return $this;
    }

    public function addColumn(string $columnName, string $columnType): self
    {
        $this->columns[$columnName] = $columnType;
        return $this;
    }

    public function create(): void
    {
        $database = $this->database->getInstance();
        $stmt = $database->prepare(
            "CREATE TABLE {$this->tableName} (`id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`))
            ENGINE = InnoDB;"
        );
        $stmt->execute();

        $this->alter();
    }

    public function alter(): void
    {
        foreach ($this->columns as $key => $value) {
            $database = $this->database->getInstance();
            $stmt = $database->prepare("ALTER TABLE {$this->tableName} ADD {$key} {$value};");
            $stmt->execute();
        }
    }

    public function migrationExecuted(string $migrationDate): void
    {
        $database = $this->database->getInstance();
        $stmt = $database->prepare("CREATE TABLE IF NOT EXISTS migrations (version VARCHAR(255)) ENGINE = InnoDB;");
        $stmt->execute();

        $stmt = $database->prepare("TRUNCATE TABLE migrations;");
        $stmt->execute();

        $stmt = $database->prepare("INSERT INTO migrations (version) VALUES ('{$migrationDate}');");
        $stmt->execute();
    }
}
