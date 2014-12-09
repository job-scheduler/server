<?php

namespace JobScheduler\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use JobScheduler\Entity\Job;
use JobScheduler\Utils;

class ScheduleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('job:schedule')
            ->setDescription('Schedule a job')
            ->addArgument(
                'jobcommand',
                InputArgument::REQUIRED,
                'Job command'
            )
            ->addArgument(
                'identifier',
                InputArgument::REQUIRED,
                'Identifier'
            )
            ->addArgument(
                'stamp',
                InputArgument::REQUIRED,
                'Scheduled time stamp'
            )
            ->addOption(
                'parameters',
                null,
                InputOption::VALUE_REQUIRED,
                'Parameters'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jobcommand = $input->getArgument('jobcommand');
        $identifier = $input->getArgument('identifier');
        $stamp = $input->getArgument('stamp');
        $parameters = $input->getOption('parameters');

        $job = Utils::getJobByCommandAndIdentifier($jobcommand, $identifier);
        if (!$job) {
            $job = new Job();
        }
        $job->setCommand($jobcommand)
            ->setIdentifier($identifier)
            ->setScheduledStamp($stamp)
            ->setParameters($parameters)
        ;

        $em = Utils::getEntityManager();
        $em->persist($job);
        $em->flush();

        $output->writeln('<info>Job scheduled:</info> Execute <fg=cyan>'.$jobcommand.'</fg=cyan> at <comment>'. date('l jS \of F Y h:i:s A', $stamp).'</comment>');
    }
}
