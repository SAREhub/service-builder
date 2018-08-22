<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


use Josantonius\File\File;
use PhpZip\ZipFile;
use PhpZip\ZipFileInterface;

class RecipeArchiveDownloader
{
    /**
     * @var Recipe
     */
    private $recipe;

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @param string $repositoryUri
     * @throws \PhpZip\Exception\InvalidArgumentException
     * @throws \PhpZip\Exception\ZipException
     * @return string Root directory of created project
     */
    public function download(string $repositoryUri): string
    {
        $file = file_get_contents($this->formatRepositoryArchiveUri($repositoryUri, $this->recipe->getName()));
        $zipFile = (new ZipFile())->openFromString($file);
        $rootDirectory = $zipFile->getListFiles()[0];

        $zipFile->extractTo(getcwd(), $this->getAdditionalFilesFromArchive($rootDirectory));
        $zipFile->extractTo(getcwd(), $this->getSourceFilesFromArchive($zipFile, $rootDirectory));

        $workingDirRootDirectory = getcwd() . "/" . $rootDirectory;

        File::copyDirRecursively($workingDirRootDirectory ."src", $workingDirRootDirectory ."/src2/".$this->recipe->getNamespace());
        File::deleteDirRecursively($workingDirRootDirectory ."src");

        File::copyDirRecursively($workingDirRootDirectory ."src2", $workingDirRootDirectory ."/src");
        File::deleteDirRecursively($workingDirRootDirectory ."src2");

        File::copyDirRecursively($workingDirRootDirectory, getcwd());
        File::deleteDirRecursively($workingDirRootDirectory);
        return $rootDirectory;
    }

    private function formatRepositoryArchiveUri(string $repositoryUri, string $recipeName): string
    {
        return sprintf("%s/%s/archive/master.zip", $repositoryUri, $recipeName);
    }

    private function getAdditionalFilesFromArchive($rootDirectory): array
    {
        $additionalFiles = $this->recipe->getAdditionalFiles();
        foreach ($additionalFiles as $key => $path) {
            $additionalFiles[$key] = $rootDirectory . $path;
        }
        return $additionalFiles;
    }

    private function getSourceFilesFromArchive(ZipFileInterface $zipFile, $rootDirectory): array
    {
        $sourceFiles = [];
        foreach ($zipFile->getListFiles() as $filePath) {
            if (strpos($filePath, $rootDirectory . "src")) {
                $sourceFiles[] = $filePath;
            }
            continue;
        }
        return $sourceFiles;
    }
}