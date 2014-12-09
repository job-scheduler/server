<?php

namespace JobScheduler\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use JobScheduler\Utils;

class WorkerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('job:worker')
            ->setDescription('Work on a job')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $jobs = Utils::getToExecuteJobs();
        
        foreach ($jobs as $job) {
            Utils::executeJob($job);
            $output->writeln(
                '<info>Job executed:</info> <fg=cyan>'.$job->getCommand().' - '.$job->getIdentifier().'</fg=cyan> at <comment>'. date('l jS \of F Y h:i:s A', time()).'</comment>'
            );
        }
    }
}
