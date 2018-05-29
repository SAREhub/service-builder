<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use SAREhub\Plugin\ServiceBuilder\Recipe\HttpRecipeFactory;
use SAREhub\Plugin\ServiceBuilder\Recipe\RecipeConfigFormat;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InjectCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('inject');
        $this->setDescription('Inject recipe files from SAREhub database to your sources catalog.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new HttpRecipeFactory("https://github.com/myclabs/php-enum", "composer", RecipeConfigFormat::JSON_FORMAT);
        $factory->create();
        $output->writeln('Executing');
    }
}