<?php

namespace App;

class Database
{
    private array $configuration;
    private \PDO $database;

    public function __construct(string $configurationFile = 'nelly.php')
    {
        $this->configuration = require $configurationFile;
    }

    public function connect(): \PDO
    {
        try {
            if (! isset($this->database)) {
                $this->database = new \PDO(
                    "mysql:host={$this->configuration['host']};
                    dbname={$this->configuration['name']};
                    charset={$this->configuration['charset']};
                    port={$this->configuration['port']}",
                    $this->configuration['user'], 
                    $this->configuration['pass']
                );
            }

            return $this->database;
        } catch (\PDOException $e) {
            echo "{$e->getMessage()}\n";
            exit(1);
        }
    }
}
