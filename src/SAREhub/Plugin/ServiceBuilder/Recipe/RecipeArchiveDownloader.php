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
        var_dump($zipFile->getListFiles());
    }

    private function formatRepositoryArchiveUri(string $repositoryUri, string $recipeName): string
    {
        return sprintf("%s/%s/archive/master.zip", $repositoryUri, $recipeName);
    }
}