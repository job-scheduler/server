<?php

namespace JobScheduler\Entity;

/**
 * @Entity @Table(name="job")
 **/
class Job
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;

    /**
     * @Column(type="string")
     **/
    protected $dbname;

    /**
     * @Column(type="string")
     **/
    protected $command;

    /**
     * @Column(type="string")
     **/
    protected $identifier;

    /**
     * @Column(type="string")
     **/
    protected $parameters;

    /**
     * @Column(type="string")
     **/
    protected $cronexpression;

    /**
     * @Column(type="integer")
     **/
    protected $scheduledstamp;
    
    /**
     * @Column(type="integer")
     **/
    protected $executionstamp;

    public function getId()
    {
        return $this->id;
    }

    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
        return $this;
    }

    public function getDbname()
    {
        return $this->dbname;
    }

    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
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

    public function setCronExpression($expression)
    {
        $this->cronexpression = $expression;
        return $this;
    }

    public function getCronExpression()
    {
        return $this->cronexpression;
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
}
