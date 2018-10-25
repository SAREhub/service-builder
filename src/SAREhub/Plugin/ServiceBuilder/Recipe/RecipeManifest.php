<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class RecipeManifest
{
    /**
     * @var array
     */
    private $injectSteps = [];

    public function getInjectSteps(): array
    {
        return $this->injectSteps;
    }

    public function setInjectSteps(array $injectSteps): self
    {
        $this->injectSteps = $injectSteps;
        return $this;
    }
}