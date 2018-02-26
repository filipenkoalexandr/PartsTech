<?php


namespace App\Command;

use App\Service\StylusService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseStylusCommand extends Command
{
    /**
     * @var StylusService
     */
    protected $stylusService;

    public function __construct(StylusService $stylusService)
    {
        parent::__construct();
        $this->stylusService = $stylusService;
    }

    protected function configure()
    {
        $this
            ->setName('app:parse-stylus')
            ->setDescription('Parse website Stylus.ua')
            ->addArgument('pageName', InputArgument::REQUIRED, 'The username of the user.');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->stylusService->run($input->getArgument('pageName'));
    }

}