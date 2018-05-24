<?php

namespace SAREhub\Plugin\ServiceBuilder;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use SAREhub\Plugin\ServiceBuilder\Command\InjectCommandProvider;

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
            ),
        ];
    }

    public function onPreUpdate()
    {
        $this->io->write("test");
    }

    public function getCapabilities(): array
    {
        return [
            CommandProvider::class => InjectCommandProvider::class
        ];
    }
}