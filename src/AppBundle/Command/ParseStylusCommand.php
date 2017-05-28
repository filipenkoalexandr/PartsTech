<?php


namespace AppBundle\Command;

use AppBundle\Service\StylusService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseStylusCommand extends ContainerAwareCommand
{
    /**
     * @var StylusService
     */
    protected $service;

    protected function configure()
    {
        $this
            ->setName('app:parse-stylus')
            ->setDescription('Parse website Stylus.ua')
            ->addArgument('pageName', InputArgument::REQUIRED, 'The username of the user.');

    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $this->service = $container->get('stylus');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->service->run($input->getArgument('pageName'));
    }

}