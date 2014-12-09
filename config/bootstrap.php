<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__."/../vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Entity"), $isDevMode);
$conn = (array)Yaml::parse(__DIR__ . '/parameters.yml');

$entityManager = EntityManager::create($conn['database'], $config);
