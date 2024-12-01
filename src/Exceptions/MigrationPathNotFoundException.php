<?php

namespace App\Exceptions;

class MigrationPathNotFoundException extends \Exception
{
    public function __construct(string $migrationPath)
    {
        parent::__construct("The migrations folder '{$migrationPath}' does not exist.");
    }
}
