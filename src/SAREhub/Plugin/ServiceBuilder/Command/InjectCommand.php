<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Command\BaseCommand;
use FilesystemIterator;
use Josantonius\File\File;
use SAREhub\Plugin\ServiceBuilder\Recipe\RecipeManifest;
use SAREhub\Plugin\ServiceBuilder\Recipe\RecipeManifestLoaderFactory;
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
        $consoleOutput =  new SymfonyStyle($input, $output);
        $consoleOutput->title("Service Builder");

        $manifest = $this->loadManifest($input, $consoleOutput);

        $tmpRecipesDir = getcwd() . "/" . self::TMP_RECIPES_DIR;
        $extractedRecipeArchiveDir = $this->downloadRecipeArchive($manifest, $tmpRecipesDir, $consoleOutput);

        $this->runInjectTasks($manifest, $extractedRecipeArchiveDir, $consoleOutput);

        File::deleteDirRecursively($tmpRecipesDir);
        $consoleOutput->success("Recipe injected to project");
    }

    private function loadManifest(InputInterface $input, SymfonyStyle $output): RecipeManifest
    {
        $output->writeln("Loading recipe manifest...");
        $manifestUri = $input->getArgument(self::ARG_RECIPE_MANIFEST_URI);
        $manifestLoaderFactory = new RecipeManifestLoaderFactory();
        $manifestLoader = $manifestLoaderFactory->create($manifestUri);
        $manifest = $manifestLoader->load();
        return $manifest;
    }

    private function downloadRecipeArchive(RecipeManifest $manifest, string $tmpRecipesDir, SymfonyStyle $output): string
    {
        $output->writeln("Creating recipe archive tmp dir...");
        $recipeTmpDir = $tmpRecipesDir . "/" . $manifest->getName();
        @mkdir($recipeTmpDir, 0777, true);

        $output->writeln("Downloading recipe archive...");
        $archiveDownloader = new ArchiveDownloader();
        $archiveDownloader->download($manifest->getArchiveUri() . "?" . time(), $recipeTmpDir);

        $files = iterator_to_array(new FilesystemIterator($recipeTmpDir, FilesystemIterator::SKIP_DOTS));
        return $recipeTmpDir . ((count($files) === 1) ? "/" . current($files)->getFilename() : "");
    }

    private function runInjectTasks(RecipeManifest $manifest, string $extractedRecipeArchiveDir, SymfonyStyle $output): void
    {
        $parser = new TaskParser();
        $parser->addFactory("CopyFiles", new CopyFilesTaskFactory($extractedRecipeArchiveDir . "", getcwd()));
        $task = $parser->parse($manifest->getInjectTasks());
        $task->run();
        $output->writeln("Executed recipe injectTasks...");
    }
}