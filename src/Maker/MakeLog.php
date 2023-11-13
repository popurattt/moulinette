<?php

namespace App\Maker; // src/Maker

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Util\UseStatementGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

final class MakeLog extends AbstractMaker {

    public function __construct() { }

    public static function getCommandName(): string {
        return 'make:my-log';
    }

    public static function getCommandDescription(): string {
        return 'Generate a log class boilerplate';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig) {
        $command
            ->addArgument(
                'log-classname', 
                InputArgument::REQUIRED, 
                sprintf('Choose a name for your controller class (e.g. <fg=yellow>%sLog</>)', Str::asClassName(Str::getRandomTerm()))
            )
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeLog.txt'));
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator) {
        $logClassDetails = $generator->createClassNameDetails(...);

        // $useStatements = new UseStatementGenerator([...]);

        // $logPath = $generator->generateClass(
        //     $logClassDetails->getFullName(),
        //     '',
        //     [
        //         'use_statements' => $useStatements
        //     ]
        // );
        $logPath = $generator->generateClass(
            $logClassDetails->getFullName(),
            '<PATH-TO-TEMPLATE>', 
            []
        );
        $generator->writeChanges();
        $this->writeSuccessMessage($io);
        $io->text('Next: Open your new log class!');
    }


    public function configureDependencies(DependencyBuilder $dependencies) {}
}