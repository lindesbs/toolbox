<?php
declare(strict_types=1);

namespace lindesbs\toolbox\Command;


use lindesbs\toolbox\Service\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'toolbox:repository')]
class RepositoryCommand extends Command
{
    public function __construct(private readonly Config $config)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return Command::SUCCESS;
    }


}