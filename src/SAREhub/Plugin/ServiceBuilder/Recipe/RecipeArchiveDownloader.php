<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistry;

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

    public function download(string $repositoryUri)
    {
        $file = file_get_contents($this->formatRepositoryArchiveUri($repositoryUri, $this->recipe->getName()));
        var_dump($file);
    }

    private function formatRepositoryArchiveUri(string $repositoryUri, string $recipeName): string
    {
        return sprintf("%s/%s/archive/master.zip", $repositoryUri, $recipeName);
    }
}