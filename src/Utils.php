<?php

namespace JobScheduler;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;

class Utils
{
    public static $entityManager = null;

    public static function getEntityManager()
    {
        if (self::$entityManager === null) {
            $isDevMode = true;
            $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/Entity"), $isDevMode);
            $conn = (array)Yaml::parse(__DIR__ . '/../config/parameters.yml');
            self::$entityManager = EntityManager::create($conn['database'], $config);
        }
        return self::$entityManager;
    }
}
