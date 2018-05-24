<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InjectCommand extends BaseCommand
{
    protected function configure()
    {
        var_dump("asdf");
        $this->setName('inject');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing');
    }
}