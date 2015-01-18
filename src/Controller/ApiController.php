<?php

namespace JobScheduler\Server\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JobScheduler\Server\Entity\Job;

class ApiController
{
    private $baseurl;
    
    public function rootAction(Application $app, Request $request)
    {
        $service = $app['jobscheduler.service'];
        $data = array();
        $data['jobs']['href'] = $service->getApiBaseUrl() . '/jobs';
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }
    
    public function jobsGetAction(Application $app, Request $request)
    {
        $service = $app['jobscheduler.service'];

        $offset = 0;
        $limit = 10;
        
        $jobs = $service->getJobs();
        
        $data = array();
        $data['count'] = count($jobs);
        $data['offset'] = $offset;
        $data['limit'] = $limit;
        $data['href'] = $this->baseurl . '/jobs';
        $data['items'] = array();
        $expand_jobs = true;
        foreach ($jobs as $job) {
            $itemdata = array();
            
            if ($expand_jobs) {
                $itemdata = $service->serializeJob($job);
                
            } else {
                $itemdata['id'] = $job->getId();
                $itemdata['href'] = $this->baseurl . '/jobs/' . $job->getId();
            }
            $data['items'][] = $itemdata;
        }
        //print_r($jobs);
        
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }
    

    public function jobsItemGetAction(Application $app, Request $request, $jobid)
    {
        $service = $app['jobscheduler.service'];

        $offset = 0;
        $limit = 10;

        $job = $service->getJobById($jobid);
        $data = $service->serializeJob($job);
        
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

    public function actionAddJobAction(Application $app, Request $request)
    {
        
        $entityManager = $app['orm.em'];
        $jobrepo = $entityManager->getRepository('JobScheduler\Entity\Job');
        
        $command = $request->query->get('command');
        $reference = $request->query->get('reference');
        $stamp = $request->query->get('stamp');
        $parameters = $request->query->get('parameters');
        $queue = $request->query->get('queue');
        
        if (!$stamp) {
            $stamp = time();
        }
        
        // TODO: Support upsert by reference?
        $job = new Job();
        $job->setCommand($command)
            ->setReference($reference)
            ->setScheduledStamp($stamp)
            ->setParameters($parameters)
            ->setQueue($queue)
            ;

        $entityManager->persist($job);
        $entityManager->flush();
        $newid = (int)$job->getId();
        
        
        $data = $service->serializeJob($job);
        
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
        
    }
}
