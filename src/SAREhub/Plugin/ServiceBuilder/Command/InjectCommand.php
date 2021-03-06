<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use SAREhub\Plugin\ServiceBuilder\Recipe\HttpRecipeFactory;
use SAREhub\Plugin\ServiceBuilder\Recipe\RecipeArchiveDownloader;
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
     * @throws \PhpZip\Exception\InvalidArgumentException
     * @throws \PhpZip\Exception\ZipException
     * @throws \SAREhub\Plugin\ServiceBuilder\Recipe\RecipeException
     * @throws \SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistryException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getArgument(self::ARGUMENT_TYPE) === null || $input->getArgument(self::ARGUMENT_NAMESPACE) === null || $input->getArgument(self::ARGUMENT_REPOSITORY_NAME) === null) {
            $output->writeln("composer inject [type] [name] [namespace]");
            $output->writeln("one or many arguments are missing");
            return;
        }

        $repositoryUri = (new RepositoryRegistry())->getRepository($input->getArgument(self::ARGUMENT_TYPE));
        $factory = new HttpRecipeFactory($repositoryUri);

        $this->writeServiceBuilderMessage($output,"Obtaining data about recipe");
        $recipe = $factory->create(
            $input->getArgument(self::ARGUMENT_REPOSITORY_NAME),
            $input->getArgument(self::ARGUMENT_NAMESPACE)
        );

        $this->writeServiceBuilderMessage($output, "Downloading files from recipe");
        $downloader = new RecipeArchiveDownloader($recipe);
        $downloader->download($repositoryUri);
        $this->writeServiceBuilderMessage($output, "Downloading files finished. Check your directory and files inside");
    }

    private function writeServiceBuilderMessage(OutputInterface$output, string $message)
    {
        $output->writeln(sprintf("[Service-Builder] %s.", $message));
    }
}