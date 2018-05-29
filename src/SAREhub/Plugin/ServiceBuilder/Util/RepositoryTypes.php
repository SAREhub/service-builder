<?php

namespace SAREhub\Plugin\ServiceBuilder\Util;


use MyCLabs\Enum\Enum;

class RepositoryTypes extends Enum
{
    const REPOSITORY_GITHUB = "github";
    const REPOSITORY_GITLAB = "gitlab";
}