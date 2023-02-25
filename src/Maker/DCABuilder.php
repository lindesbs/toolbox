<?php
declare(strict_types=1);

namespace lindesbs\contaotoolbox\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class DCABuilder extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:dcabuilder:generate';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->addArgument("sourcefile", InputArgument::REQUIRED, "definition file ( .neon)");
        $command->addArgument("destinationfile", InputArgument::REQUIRED, "destination file");

        $command->setHelp(file_get_contents("../Resources/help/MakeDCABuidlerGenerate.txt"));
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // TODO: Implement configureDependencies() method.
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        // TODO: Implement generate() method.
    }

}