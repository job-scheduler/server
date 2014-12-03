<?php

namespace JobScheduler;

class Job
{
    protected $command;
    protected $identifier;
    protected $parameters;
    protected $cronexpression;
    protected $scheduledstamp;
    protected $executionstamp;
    protected $key;

    public function __construct($command, $identifier)
    {
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
}
