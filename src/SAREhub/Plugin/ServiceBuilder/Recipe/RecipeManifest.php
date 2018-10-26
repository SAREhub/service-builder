<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class RecipeManifest
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $archiveUri;

    /**
     * @var array
     */
    private $injectSteps;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): RecipeManifest
    {
        $this->name = $name;
        return $this;
    }

    public function getArchiveUri(): string
    {
        return $this->archiveUri;
    }

    public function setArchiveUri(string $archiveUri): RecipeManifest
    {
        $this->archiveUri = $archiveUri;
        return $this;
    }

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