<?php

use Illuminate\Database\Capsule\Manager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Dotenv\Dotenv;

require 'vendor/autoload.php';
require 'helpers.php';

// ENV
$dotenv = Dotenv::createImmutable(__DIR__); // Load the .env file in the root directory
$dotenv->load();

// DATABASE
$manager = new Manager;

$manager->addConnection([
	'driver'    => 'mysql',
	'host'      => env('DB_HOST'),
	'database'  => env('DB_DATABASE'),
	'username'  => env('DB_USERNAME'),
	'password'  => env('DB_PASSWORD'),
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => '',
]);

$manager->setAsGlobal();

$manager->bootEloquent();

// TWIG
$loader = new FilesystemLoader(__DIR__ . '/twig');
$twig = new Environment($loader, [
	'cache' => false,
]);

$GLOBALS['twig'] = $twig;