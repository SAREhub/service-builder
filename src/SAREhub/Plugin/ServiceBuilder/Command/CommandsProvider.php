<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;


use Composer\Plugin\Capability\CommandProvider;

class CommandsProvider implements CommandProvider
{
    public function getCommands()
    {
        return [
            new InjectCommand()
        ];
    }
}