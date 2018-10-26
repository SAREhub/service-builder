<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


interface RecipeManifestLoader
{
    public function load(): RecipeManifest;
}