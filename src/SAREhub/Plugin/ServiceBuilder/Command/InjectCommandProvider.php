<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;

class InjectCommandProvider implements CommandProviderCapability
{
    public function getCommands(): array
    {
        return [
            new InjectCommand()
        ];
    }
}

class InjectCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('inject');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing');
    }
}