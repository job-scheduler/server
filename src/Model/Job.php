<?php

namespace JobScheduler\Model;

use JobScheduler\Entity\Job as JobEntity;
use JobScheduler\Utils;

class Job extends JobEntity
{
    private $jobEntity;

    public function __construct($command, $identifier)
    {
        $this->jobEntity = new JobEntity();
        $this->jobEntity->setCommand($command)->setIdentifier($identifier);
    }

    public function setScheduledStamp($stamp)
    {
        $this->jobEntity->setScheduledStamp($stamp);
        return $this;
    }

    public function setParameters($parameters)
    {
        $this->jobEntity->setParameters($parameters);
        return $this;
    }

    public function save()
    {
        $em = Utils::getEntityManager();
        $em->persist($this->jobEntity);
        $em->flush();
    }
}
