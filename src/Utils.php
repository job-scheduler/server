<?php

namespace JobScheduler;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;
use JobScheduler\Entity\Job;

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

    public static function getJobByCommandAndIdentifier($command, $identifier)
    {
        $em = self::getEntityManager();
        $job = $em->getRepository('JobScheduler\Entity\Job')->findOneBy(
            array('command' => $command, 'identifier' => $identifier, 'executionstamp' => null)
        );
        return $job;
    }

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

    public static function executeJob(Job $job)
    {
        $em = self::getEntityManager();
        
        // TODO: perform the real exection command

        $job->setExecutionStamp(time());
        $em->persist($job);
        $em->flush();
    }
}
