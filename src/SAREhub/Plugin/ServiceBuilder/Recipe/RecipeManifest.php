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
    private $injectTasks;

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

    public function getInjectTasks(): array
    {
        return $this->injectTasks;
    }

    public function setInjectTasks(array $injectTasks): self
    {
        $this->injectTasks = $injectTasks;
        return $this;
    }
}