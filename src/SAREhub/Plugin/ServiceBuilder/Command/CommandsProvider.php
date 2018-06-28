<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;


use Composer\Plugin\Capability\CommandProvider;
use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistry;

class CommandsProvider implements CommandProvider
{
    /**
     * @var RepositoryRegistry
     */
    private $repositoryRegistry;

    public function __construct()
    {
        $this->repositoryRegistry = new RepositoryRegistry();
    }

    public function getCommands()
    {
        return [
            new InjectCommand($this->repositoryRegistry)
        ];
    }
}