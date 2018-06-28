<?php

namespace SAREhub\Plugin\ServiceBuilder\Repository;


use Exception;

class RepositoryRegistryException extends Exception
{
    public static function get(string $type): self
    {
        return new self("repository with $type type doesn't exist in registry.");
    }

    public static function badType(string $type): self
    {
        return new self("repository type $type doesn't exist as a registered repository type.");
    }
}