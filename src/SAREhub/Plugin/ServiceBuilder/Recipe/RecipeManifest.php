<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


class RecipeManifest implements \JsonSerializable
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

    public static function createFromJson(string $json): self
    {
        return self::createFromArray(json_decode($json, true));
    }

    public static function createFromArray(array $data): self
    {
        return (new self())
            ->setName($data["name"])
            ->setArchiveUri($data["archiveUri"])
            ->setInjectTasks($data["injectTasks"]);
    }

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

    public function jsonSerialize()
    {
        return [
            "name" => $this->getName(),
            "archiveUri" => $this->getArchiveUri(),
            "injectTasks" => $this->getInjectTasks()
        ];
    }
}