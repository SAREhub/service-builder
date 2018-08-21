<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


use PhpZip\ZipFile;

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
     */
    public function download(string $repositoryUri)
    {
        $file = file_get_contents($this->formatRepositoryArchiveUri($repositoryUri, $this->recipe->getName()));
        $zipFile = (new ZipFile())->openFromString($file);
//        $zipFile->extractTo(getcwd()."/src/".$this->recipe->getNamespace());
        $rootDirectory = $zipFile->getListFiles()[0];

        $sourceFiles = [];
        foreach($zipFile->getListFiles() as $filePath) {
            if(strpos($filePath, $rootDirectory."src")) {
                $sourceFiles[] = $filePath;
            }
            continue;
        }

        $additionalFiles = $this->recipe->getAdditionalFiles();
        foreach ($additionalFiles as $key=>$path) {
            $additionalFiles[$key] = $rootDirectory.$path;
        }

        $zipFile->extractTo(getcwd(), $additionalFiles);
        $zipFile->extractTo(getcwd(), $sourceFiles);
    }

    private function formatRepositoryArchiveUri(string $repositoryUri, string $recipeName): string
    {
        return sprintf("%s/%s/archive/master.zip", $repositoryUri, $recipeName);
    }
}