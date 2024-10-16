<?php

require './bootstrap.php';

use Symfony\Component\Console\Application;

// Create a new Console Application
$application = new Application();

// Register your command
$application->add(new \Egretos\GamepointTestTask\Console\ImportPHPCommand());
$application->add(new \Egretos\GamepointTestTask\Console\MigrateCommand());
$application->add(new \Egretos\GamepointTestTask\Console\ImportCurrencyRates());

// Run the application
$application->run();
