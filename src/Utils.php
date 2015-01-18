<?php

namespace JobScheduler;

use Symfony\Component\Yaml\Yaml;
use JobScheduler\Entity\Job;
use LinkORB\Component\DatabaseManager\DatabaseManager;
use Doctrine\ORM\Tools\Setup as DoctrineSetup;
use Doctrine\ORM\EntityManager;

class Utils
{
    public static $entityManager = null;

    // TODO: Refactor this out
    public static function getEntityManager()
    {
        if (self::$entityManager === null) {
            $isDevMode = true;
            /*
            $config = DoctrineSetup::createAnnotationMetadataConfiguration(array(__DIR__."/Entity"), $isDevMode);
            $conn = (array)Yaml::parse(__DIR__ . '/../config/parameters.yml');
            self::$entityManager = EntityManager::create($conn['database'], $config);
            */
            $databasemanager = new DatabaseManager();
            $dbal = $databasemanager->getDbalConnection('jobscheduler', 'default');
            $isDevMode = true;
            $ormconfig = DoctrineSetup::createAnnotationMetadataConfiguration(array(__DIR__."/Entity"), $isDevMode);
            self::$entityManager =  EntityManager::create($dbal, $ormconfig);
            
        }
        return self::$entityManager;
    }
    
    // TODO: Extract into service / repository
    public static function getJobByCommandAndIdentifier($command, $identifier)
    {
        $em = self::getEntityManager();
        $job = $em->getRepository('JobScheduler\Entity\Job')->findOneBy(
            array('command' => $command, 'identifier' => $identifier, 'executionstamp' => null)
        );
        return $job;
    }

    // TODO: Extract into service
    public static function getToExecuteJobs()
    {
        $now = time();
        $searchFrom = $now - 60;
        $searchTill = $now + 2;

        $em = self::getEntityManager();
        $jobs = $em->createQueryBuilder()
            ->select('j')
            ->from('JobScheduler\Entity\Job', 'j')
            ->where('j.executionstamp IS NULL AND j.scheduledstamp BETWEEN :start AND :end')
            ->setParameter('start', $searchFrom)
            ->setParameter('end', $searchTill)
            ->getQuery()
            ->getResult();
        return $jobs;
    }

    // TODO: Extract into service and worker
    public static function executeJob(Job $job)
    {
        $em = self::getEntityManager();
        
        // TODO: perform the real exection command

        $job->setExecutionStamp(time());
        $em->persist($job);
        $em->flush();
    }
}
