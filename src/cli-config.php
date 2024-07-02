<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__); 
$dotenv->load();

$config = new PhpFile('migrations.php'); 

$params = [
'driver' => $_ENV[ 'DB_DRIVER'] ?? 'pdo_mysql',
'host' => $_ENV['DB_HOST'],
'user' => $_ENV["DB_USER"],
'password' => $_ENV[ 'DB_PASS'],
'dbname' => $_ENV['DB_DATABASE']
];

$entityManager = new EntityManager(
DriverManager::getConnection($params),
ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/code/Entity'])
);
return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));