<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class RecipeManifestLoaderFactory
{
    public function create(string $uri): RecipeManifestLoader
    {
        list($loaderType, $uri) = explode(":", $uri);
        switch ($loaderType) {
            case "http":
            case "https":
                return new FileRecipeManifestLoader($loaderType."://$uri");
            case "github":
                return new FileRecipeManifestLoader("https://github.com/$uri/raw/master/recipe.json");
            default: throw new \InvalidArgumentException("Unsupported Recipe Manifest loader");
        }
    }
}