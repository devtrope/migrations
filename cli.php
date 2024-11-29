#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\MigrationManager;

$migrationManager = new MigrationManager();

$migrationManager->createMigration($argv[1]);