<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class FileRecipeManifestLoader implements RecipeManifestLoader
{
    /**
     * @var string
     */
    private $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    public function load(): RecipeManifest
    {
        return RecipeManifest::createFromJson(file_get_contents($this->uri));
    }


    public function getUri(): string
    {
        return $this->uri;
    }
}