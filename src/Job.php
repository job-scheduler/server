<?php

namespace JobScheduler;

class Job
{
    private $dbname;
    private $command;
    private $identifier;
    private $parameters;
    private $cronexpression;
    private $scheduledstamp;
    private $executionstamp;
    private $key;

    public function __construct($dbname, $command, $identifier)
    {
        $this->dbname = $dbname;
        $this->command = $command;
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setScheduleStamp($stamp)
    {
        $this->scheduledstamp = $stamp;
        return $this;
    }

    public function getScheduleStamp()
    {
        return $this->scheduledstamp;
    }

    public function setExecutionStamp($stamp)
    {
        $this->executionstamp = $stamp;
        return $this;
    }

    public function getExecutionStamp()
    {
        return $this->executionstamp;
    }

    public function setCronExpression($expression)
    {
        $this->cronexpression = $expression;
        return $this;
    }

    public function getCronExpression()
    {
        return $this->cronexpression;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function save()
    {
        $db = Utils::getDatabase();
        
        $job = Utils::get($this->dbname, $this->command, $this->identifier);
        if ($job) {
            $job = Record::createByUuid($db->getName().'.job', $this->key);
        } else {
            $job = Record::createNew($db->getName().'.job');
        }

        $job->dbname = $this->dbname;
        $job->command = $this->command;
        $job->identifier = $this->identifier;
        $job->parameters = $this->parameters;
        $job->cronexpression = $this->cronexpression;
        $job->scheduledstamp = $this->scheduledstamp;
        $job->executionstamp = $this->executionstamp;
        $job->save();
        return $job;
    }
}
