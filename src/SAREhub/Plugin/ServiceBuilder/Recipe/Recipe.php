<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class Recipe
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var resource[]
     */
    private $sources;

    /**
     * @var array
     */
    private $additionalFiles;

    public function createFromArray(array $data): self
    {
        $recipe = new Recipe();
        $recipe->setName($data["name"]);
        $recipe->setAdditionalFiles($data["additionalFiles"]);
        $recipe->setNamespace($data["namespace"]);
        $recipe->setSources($data["sources"]);
        return $recipe;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    public function getSources(): array
    {
        return $this->sources;
    }

    public function setSources(array $sources): void
    {
        $this->sources = $sources;
    }

    public function getAdditionalFiles(): array
    {
        return $this->additionalFiles;
    }

    public function setAdditionalFiles(array $additionalFiles): void
    {
        $this->additionalFiles = $additionalFiles;
    }

    public function toArray(): array
    {
        return [
            "namespace" => $this->getNamespace(),
            "additionalFiles" => $this->getAdditionalFiles()
        ];
    }

}