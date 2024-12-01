<?php

use App\Migrations\Migration;

class initialMigration extends Migration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('id', 'int')->addColumn('name', 'varchar(255)')->create();
    }
}