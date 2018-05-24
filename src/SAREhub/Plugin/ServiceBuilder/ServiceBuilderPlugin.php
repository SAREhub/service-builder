<?php

namespace SAREhub\Plugin\ServiceBuilder;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use SAREhub\Plugin\ServiceBuilder\Command\CommandsProvider;

class ServiceBuilderPlugin implements PluginInterface, EventSubscriberInterface, Capable
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            "pre-update-cmd" => array(
                array('onPreUpdate', 0)
            )
        ];
    }

    public function onPreUpdate()
    {
        $this->io->write("[Service-Builder] Updating using SAREhub Service Builder plugin.");
        $this->io->write("enabled capabilities:");

        var_dump($this->composer->getPluginManager()->getPluginCapability($this, CommandProvider::class));
        foreach($this->getCapabilities() as $key => $value) {
            $this->io->write($key." => ".$value);
        }
    }

    public function getCapabilities()
    {
        return [
            CommandProviderCapability::class => CommandsProvider::class,
        ];
    }
}