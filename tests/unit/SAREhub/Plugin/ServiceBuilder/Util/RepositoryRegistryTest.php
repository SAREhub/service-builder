<?php

namespace SAREhub\Plugin\ServiceBuilder\Util;

use PHPUnit\Framework\TestCase;
use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistry;
use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryRegistryException;
use SAREhub\Plugin\ServiceBuilder\Repository\RepositoryTypes;

class RepositoryRegistryTest extends TestCase
{
    /**
     * @var RepositoryRegistry
     */
    private $registry;

    public function setUp()
    {
        $this->registry = new RepositoryRegistry();
    }

    /**
     * @throws RepositoryRegistryException
     */
    public function testGetRepositoryWhenGoodTypeThenReturnRepositoryUrl()
    {
        $this->assertEquals("https://github.com", $this->registry->getRepository(RepositoryTypes::REPOSITORY_GITHUB));
    }

    /**
     * @throws RepositoryRegistryException
     */
    public function testGetRepositoryWhenBadTypeThenThrowException()
    {
        $this->expectException(RepositoryRegistryException::class);
        $this->registry->getRepository("test");
    }

    /**
     * @throws RepositoryRegistryException
     */
    public function testGetRepositoryWhenGoodTypeAndNotExistsThenThrowException()
    {
        $this->expectException(RepositoryRegistryException::class);
        $this->registry->getRepository(RepositoryTypes::REPOSITORY_GITLAB);
    }
}
