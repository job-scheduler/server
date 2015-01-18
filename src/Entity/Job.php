<?php

namespace JobScheduler\Server\Entity;

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
    protected $command;

    /**
    * @Column(type="string")
    **/
    protected $queue;
    
    /**
     * @Column(type="string")
     **/
    protected $reference;

    /**
     * @Column(type="string", nullable=true)
     **/
    protected $parameters;

    /**
     * @Column(type="string", nullable=true)
     **/
    protected $cronexpression;

    /**
     * @Column(type="integer")
     **/
    protected $scheduledstamp;
    
    /**
     * @Column(type="integer", nullable=true)
     **/
    protected $executionstamp;

    public function getKey()
    {
        $hashids = new \Hashids\Hashids('somesalt');
        
        $key = $hashids->encode($this->id + 20000);
        return $key;
        
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }
    
    public function getReference()
    {
        return $this->reference;
    }

    public function setQueue($queue)
    {
        $this->queue = $queue;
        return $this;
    }
    
    public function getQueue()
    {
        return $this->queue;
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

    public function setScheduledStamp($stamp)
    {
        $this->scheduledstamp = $stamp;
        return $this;
    }

    public function getScheduledStamp()
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
    
    public function getState()
    {
        return 'Runnable';
    }
}
