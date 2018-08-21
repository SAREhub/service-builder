<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class HttpRecipeFactory implements RecipeFactory
{
    /**
     * Repository type name(currently available github only).
     * @var string
     */
    private $repositoryUri;

    public function __construct(string $repositoryUri)
    {
        $this->repositoryUri = $repositoryUri;
    }

    /**
     * @param string $repositoryName
     * @param string $namespace
     * @return Recipe
     * @throws RecipeException
     */
    public function create(string $repositoryName, string $namespace): Recipe
    {
        try {
            $recipeConfig = file_get_contents($this->formatRecipeUri($repositoryName));
            $decodedConfig = json_decode($recipeConfig, true);
            $recipe = new Recipe();
            $recipe->setName($repositoryName);
            $recipe->setAdditionalFiles($decodedConfig["additionalFiles"]);
            $recipe->setNamespace($namespace);
            return $recipe;
        }
        catch (\Exception $e)
        {
            throw RecipeException::create($e);
        }
    }

    private function formatRecipeUri(string $repositoryName): string
    {
        return $this->formatRepositoryUri($repositoryName) . "/raw/master/recipe.json";
    }

    private function formatRepositoryUri(string $repositoryName): string
    {
        return sprintf("%s/%s", $this->repositoryUri, $repositoryName);
    }

}