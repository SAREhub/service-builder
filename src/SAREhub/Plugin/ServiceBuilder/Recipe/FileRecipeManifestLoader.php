<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class FileRecipeManifestLoader
{
    public function load(string $uri): RecipeManifest
    {
        $manifest = new RecipeManifest();
        $data = json_decode(file_get_contents($uri), true);
        $manifest->setInjectSteps($data["injectSteps"]);
        return $manifest;
    }
}