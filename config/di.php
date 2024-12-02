<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        App\Migrations\MigrationManager::class => DI\autowire(),
    ]);
};