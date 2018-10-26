<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use FilesystemIterator;
use Josantonius\File\File;
use SAREhub\Plugin\ServiceBuilder\Recipe\FileRecipeManifestLoader;
use SAREhub\Plugin\ServiceBuilder\Recipe\HttpRecipeFactory;
use SAREhub\Plugin\ServiceBuilder\Recipe\RecipeArchiveDownloader;
use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistry;
use SAREhub\Plugin\ServiceBuilder\Util\ArchiveDownloader;
use SAREhub\Plugin\ServiceBuilder\Util\Task\CopyFiles\CopyFilesTaskFactory;
use SAREhub\Plugin\ServiceBuilder\Util\Task\TaskParser;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InjectCommand extends BaseCommand
{
    const TMP_RECIPES_DIR = "__tmprecipes";

    const ARG_RECIPE_MANIFEST_URI = "recipeManifestUri";

    protected function configure()
    {
        $this->setName('inject');
        $this->setDescription('Inject recipe to current project');
        $this->addArgument(self::ARG_RECIPE_MANIFEST_URI, InputArgument::REQUIRED, "uri for recipe.json file");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consoleOutput = new SymfonyStyle($input, $output);
        $consoleOutput->title("Service Builder");

        $consoleOutput->writeln("Loading recipe manifest...");
        $manifestLoader = new FileRecipeManifestLoader();
        $manifest = $manifestLoader->load($input->getArgument(self::ARG_RECIPE_MANIFEST_URI) . "?" . time());

        $consoleOutput->writeln("Creating recipe archive tmp dir...");
        $tmpRecipesDir = getcwd() . "/".self::TMP_RECIPES_DIR;
        $recipeTmpDir = $tmpRecipesDir ."/". $manifest->getName();
        @mkdir($recipeTmpDir, 0777, true);

        $consoleOutput->writeln("Downloading recipe archive...");
        $archiveDownloader = new ArchiveDownloader();
        $archiveDownloader->download($manifest->getArchiveUri() . "?" . time(), $recipeTmpDir);
        $files = iterator_to_array(new FilesystemIterator($recipeTmpDir, FilesystemIterator::SKIP_DOTS));
        if (count($files) === 1) {
            $recipeTmpDir .= "/".current($files)->getFilename();
        }

        $parser = new TaskParser();
        $parser->addFactory("CopyFiles", new CopyFilesTaskFactory($recipeTmpDir . "", getcwd()));
        $task = $parser->parse($manifest->getInjectTasks());
        $task->run();
        $consoleOutput->writeln("Executed recipe injectTasks...");

        File::deleteDirRecursively($tmpRecipesDir);
        $consoleOutput->success("Recipe injected to project");
    }
}