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

        var_dump(getcwd().$rootDirectory."src");
        var_dump(getcwd().$rootDirectory.$this->recipe->getNamespace()."/src");

        $files = File::getFilesFromDir(getcwd()."/".$rootDirectory."src");

        var_dump(get_class($files));

        File::copyDirRecursively(getcwd()."/".$rootDirectory."src", getcwd()."/".$rootDirectory."/src".$this->recipe->getNamespace());
//        $this->rcopy();
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