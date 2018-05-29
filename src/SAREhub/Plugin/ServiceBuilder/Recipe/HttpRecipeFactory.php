<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class HttpRecipeFactory implements RecipeFactory
{
    /**
     * URL to recipe repository (at this moment only github).
     * @var string
     */
    private $url;

    /**
     * Config file name(YAML format).
     * @var string
     */
    private $configFile;

    /**
     * @var string
     */
    private $configFormat;

    public function __construct(string $url, string $configFile, string $configFormat)
    {
        $this->url = $url;
        $this->configFile = $configFile;
        $this->configFormat = $configFormat;
    }

    /**
     * @return Recipe
     * @throws RecipeException
     */
    public function create(): Recipe
    {
        try {
            $config = file_get_contents($this->url."/raw/master/".$this->configFile.".".$this->configFormat);
            var_dump($config);
            return new Recipe();
        }
        catch (\Exception $e)
        {
            throw new RecipeException($e);
        }
    }
}