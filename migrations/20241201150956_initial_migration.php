<?php

use App\Migrations\Migration;

class initialMigration extends Migration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('name', 'varchar(255)')->create();
        
        $table = $this->table('reset_password');
        $table->addColumn('user_id', 'int')->create();
        
        $table = $this->table('reset_password'); 
        $table->addColumn('active', 'int')->alter();
    }
}