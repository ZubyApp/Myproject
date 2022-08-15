<?php

require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = new PhpFile('migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders
$Params = [
    'dbname'    => $_ENV['DB_DATABASE'],
    'user'      => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASS'],
    'host'      => $_ENV['DB_HOST'],
    'driver'    => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];


$entityManager = EntityManager::create(
    $Params,
    ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/app/Entity'])
);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
