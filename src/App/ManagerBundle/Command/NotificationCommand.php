<?php

namespace App\ManagerBundle\Command;

use App\SourceBundle\Helpers\Arr;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;

class NotificationCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('notification:check')
			->setDescription('Checking for notifications')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
        $this->getContainer()->enterScope('request');
        $this->getContainer()->set('request', new Request(), 'request');

        $output->writeln('Process Done');
    }
}