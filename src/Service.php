<?php

namespace JobScheduler\Server;

class Service
{
    private $jobrepository;
    private $em;
    private $baseurl;
    private $apibaseurl;
    
    public function __construct($em, $baseurl)
    {
        $this->em = $em;
        $this->baseurl = $baseurl;
        $this->apibaseurl = $baseurl . '/api/v1';
        $this->jobrepository = $em->getRepository('JobScheduler\Server\Entity\Job');
    }
    
    public function getBaseUrl()
    {
        return $this->baseurl;
    }
    
    public function getApiBaseUrl()
    {
        return $this->apibaseurl;
    }
    
    public function getJobs()
    {
        $jobs = $this->jobrepository->findAll();
        return $jobs;
    }
    
    public function getJobById($jobid)
    {
        $job = $this->jobrepository->findOneById($jobid);
        return $job;
    }
    
    public function serializeJob($job)
    {
        $data = array();
        $data['id'] = $job->getId();
        $data['href'] = $this->apibaseurl . '/jobs/' . $job->getId();
        $data['command'] = $job->getCommand();
        $data['scheduledStamp'] = $job->getScheduledStamp();
        $data['reference'] = $job->getReference();
        $data['parameters'] = json_decode($job->getParameters());
        $data['queue'] = $job->getQueue();
        $data['state'] = $job->getState();
        return $data;
    }
}
