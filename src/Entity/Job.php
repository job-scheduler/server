<?php

namespace JobScheduler\Entity;

/**
 * @Entity @Table(name="jobtest")
 **/
class Job
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
}
