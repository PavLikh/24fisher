<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager;
use Laminas\ServiceManager\ServiceManager;

// Load configuration
$config = require __DIR__ . '/config.php';

$dependencies                       = $config['dependencies'];
$dependencies['services']['config'] = $config;

$capsule = new Manager();
$capsuleContainer = $capsule->getContainer();
$capsule->addConnection($config['database']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Build container
return new ServiceManager($dependencies);
