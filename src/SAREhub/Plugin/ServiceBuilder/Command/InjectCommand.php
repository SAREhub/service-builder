<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use SAREhub\Plugin\ServiceBuilder\Recipe\HttpRecipeFactory;
use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistry;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InjectCommand extends BaseCommand
{
    const ARGUMENT_TYPE = "type";
    const ARGUMENT_REPOSITORY_NAME = "name";
    const ARGUMENT_NAMESPACE = "namespace";

    protected function configure()
    {
        $this->setName('inject');
        $this->setDescription('Inject recipe files from SAREhub database to your sources catalog.');
        $this->addArgument(self::ARGUMENT_TYPE, null, "repository type (available: github)");
        $this->addArgument(self::ARGUMENT_REPOSITORY_NAME, null, "repository name (example: testGroup/testProject)");
        $this->addArgument(self::ARGUMENT_NAMESPACE, null, "namespace where source files should be extracted");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \SAREhub\Plugin\ServiceBuilder\Recipe\RecipeException
     * @throws \SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistryException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new HttpRecipeFactory(
            (new RepositoryRegistry())->getRepository($input->getArgument(self::ARGUMENT_TYPE))
        );

        $recipe = $factory->create($input->getArgument(self::ARGUMENT_REPOSITORY_NAME), $input->getArgument(self::ARGUMENT_NAMESPACE));
        $output->writeln(var_dump($recipe->toArray()));
    }
}