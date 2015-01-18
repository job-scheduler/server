<?php

namespace JobScheduler\Server\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DashboardController
{
    public function indexAction(Application $app, Request $request)
    {
        $data = array();
        $html =  $app['twig']->render('@Dashboard/index.html.twig', $data);
        return $html;
    }

    public function loginAction(Application $app, Request $request)
    {
        $data = array(
            'error' => $app['security.last_error']($request)
        );
        $html =  $app['twig']->render('@Dashboard/login.html.twig', $data);
        return $html;
    }

    public function jobsAction(Application $app, Request $request)
    {
        $service = $app['jobscheduler.service'];
        
        $jobs = $service->getJobs();
        
        $data = array(
            'jobs' => $jobs
        );
        
        $html =  $app['twig']->render('@Dashboard/jobs.html.twig', $data);
        return $html;
    }

    public function jobsViewAction(Application $app, Request $request, $jobid)
    {
        $service = $app['jobscheduler.service'];
        $job = $service->getJobById($jobid);

        $data = array(
            'job' => $job
        );
        $html =  $app['twig']->render('@Dashboard/jobs_view.html.twig', $data);
        return $html;
    }
}
