<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;


use MyCLabs\Enum\Enum;

class RecipeConfigFormat extends Enum
{
    const YAML_FORMAT = "yml";
    const XML_FORMAT = "xml";
    const JSON_FORMAT = "json";
}