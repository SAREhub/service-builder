<?php

namespace SAREhub\Plugin\ServiceBuilder\Util;


class RepositoryRegistry
{
    private $repositories = [
        RepositoryTypes::REPOSITORY_GITHUB => "https://github.com"
    ];

    public function getRepositories()
    {
        return $this->repositories;
    }

    /**
     * @param string $repositoryType
     * @return string
     * @throws RepositoryRegistryException
     */
    public function getRepository(string $repositoryType)
    {
        if(!in_array($repositoryType, RepositoryTypes::values())) throw RepositoryRegistryException::badType($repositoryType);
        if(!isset($this->repositories[$repositoryType])) throw RepositoryRegistryException::get($repositoryType);
        return $this->repositories[$repositoryType];
    }
}