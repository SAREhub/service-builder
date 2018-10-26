<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;

use PHPUnit\Framework\TestCase;

class RecipeManifestLoaderFactoryTest extends TestCase
{
    /**
     * @var RecipeManifestLoaderFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new RecipeManifestLoaderFactory();
    }

    public function testCreateWhenStartsWithHttp()
    {
        $loader = $this->factory->create("http:test.com/recipe.json");

        $this->assertInstanceOf(FileRecipeManifestLoader::class, $loader);
        $this->assertEquals("http://test.com/recipe.json", $loader->getUri());
    }

    public function testCreateWhenStartsWithHttps()
    {
        $loader = $this->factory->create("https:test.com/recipe.json");

        $this->assertInstanceOf(FileRecipeManifestLoader::class, $loader);
        $this->assertEquals("https://test.com/recipe.json", $loader->getUri());
    }

    public function testCreateWhenUriStartsWithGithub()
    {
        $loader = $this->factory->create("github:account/recipe_repository");

        $this->assertInstanceOf(FileRecipeManifestLoader::class, $loader);
        $this->assertEquals("https://github.com/account/recipe_repository/raw/master/recipe.json", $loader->getUri());
    }

    public function testCreateWhenLoaderIsNotSupported()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Unsupported Recipe Manifest loader");
        $this->factory->create("not_supported:test");
    }
}
