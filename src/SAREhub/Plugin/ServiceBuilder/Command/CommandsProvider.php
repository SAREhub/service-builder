<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;


use Composer\Plugin\Capability\CommandProvider;
use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistry;

class CommandsProvider implements CommandProvider
{
    public function getCommands()
    {
        return [
            new InjectCommand()
        ];
    }
}