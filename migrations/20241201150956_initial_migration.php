<?php

use App\Migrations\MigrationInterface;

class initialMigration implements MigrationInterface
{
    public function change(): string
    {
        return "CREATE TABLE users (id int, name varchar(255))";
    }
}