<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use SAREhub\Plugin\ServiceBuilder\Recipe\HttpRecipeFactory;
use SAREhub\Plugin\ServiceBuilder\Recipe\RecipeConfigFormat;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InjectCommand extends BaseCommand
{
    const ARGUMENT_URL = "url";
    const ARGUMENT_CONFIG = "config";
    const ARGUMENT_FORMAT = "format";

    protected function configure()
    {
        $this->setName('inject');
        $this->setDescription('Inject recipe files from SAREhub database to your sources catalog.');
        $this->addArgument(self::ARGUMENT_URL, null, "repository url where the recipe source files are stored.");
        $this->addArgument(self::ARGUMENT_CONFIG, null, "config file name");
        $this->addArgument(self::ARGUMENT_FORMAT, null, "config file format, available: yml, xml, json");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

//        $factory = new HttpRecipeFactory("https://github.com/myclabs/php-enum", "composer", RecipeConfigFormat::JSON_FORMAT);
        $factory = new HttpRecipeFactory(
            $input->getArgument(self::ARGUMENT_URL),
            $input->getArgument(self::ARGUMENT_CONFIG),
            $input->getArgument(self::ARGUMENT_FORMAT)
        );

        $factory->create();
        $output->writeln('Executing');
    }
}