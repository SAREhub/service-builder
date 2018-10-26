<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class FileRecipeManifestLoaderTest extends TestCase
{
    /**
     * @var FileRecipeManifestLoader
     */
    private $loader;

    /**
     * @var vfsStreamDirectory
     */
    private $vfsRoot;

    protected function setUp()
    {
        $this->loader = new FileRecipeManifestLoader();
        $this->vfsRoot = vfsStream::setup();
    }

    public function testLoad()
    {
        $content = [
            "name" => "test_recipe",
            "archiveUri" => "https://example.com/archive.zip",
            "injectSteps" => [
                ["step_info"]
            ]
        ];
        $file = vfsStream::newFile("recipe.json")->setContent(json_encode($content));
        $this->vfsRoot->addChild($file);
        $manifest = $this->loader->load($file->url());

        $this->assertEquals($content["name"], $manifest->getName());
        $this->assertEquals($content["archiveUri"], $manifest->getArchiveUri());
        $this->assertEquals($content["injectSteps"], $manifest->getInjectSteps());
    }
}
