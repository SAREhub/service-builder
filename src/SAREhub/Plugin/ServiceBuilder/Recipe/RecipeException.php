<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;


use Exception;
use Throwable;

class RecipeException extends Exception
{
    public static function create(Throwable $previous): self
    {
        return new self("error occurred when creating recipe", 0, $previous);
    }
}