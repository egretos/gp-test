<?php

use Illuminate\Database\Capsule\Manager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';
require 'helpers.php';

// DATABASE
$manager = new Manager;

$manager->addConnection([
	'driver'    => 'mysql',
	'host'      => 'mysql',
	'database'  => 'test',
	'username'  => 'root',
	'password'  => 'root',
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