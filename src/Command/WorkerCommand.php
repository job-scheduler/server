<?php

namespace JobScheduler\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            switch ($job->getCommand()) {
                case 'CalendarNotification':
                    $event = Record::createById($job->getDatabaseName().'.cal_entry', $job->getIdentifier());
                    if (!$event->isNull()) {
                        $output->writeln(
                            '<comment>Sending notification: '.$job->getCommand().' - '.$job->getIdentifier().' ...</comment>'
                        );

                        $success = $event->notify();

                        if ($success) {
                            $job->setExecutionStamp(time());
                            $job->save();
                            $output->writeln('<info>Notification sent.</info>');
                        } else {
                            $output->writeln('<error>Notification not sent - maybe the client db notification not enabled or notification expired.</error>');
                        }
                    }
                    break;
                default:
                    break;
            }
        }

        // $output->writeln('<info>Job scheduled:</info> Execute <fg=cyan>'.$jobcommand.'</fg=cyan> at <comment>'. date('l jS \of F Y h:i:s A', $stamp).'</comment>');
    }
}
