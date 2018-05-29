<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;


interface RecipeFactory
{
    public function create(): Recipe;
}