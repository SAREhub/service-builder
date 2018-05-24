<?php

namespace SAREhub\Plugin\ServiceBuilder\Command;

use Composer\Plugin\Capability\CommandProvider;

class InjectCommandProvider implements CommandProvider
{
    public function getCommands(): array
    {
        return [
            new InjectCommand()
        ];
    }
}