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

        $this->vfsRoot = vfsStream::setup();
    }

    public function testLoad()
    {
        $content = [
            "name" => "test_recipe",
            "archiveUri" => "https://example.com/archive.zip",
            "injectTasks" => [
                ["task_info"]
            ]
        ];
        $file = vfsStream::newFile("recipe.json")->setContent(json_encode($content));
        $this->vfsRoot->addChild($file);

        $loader = new FileRecipeManifestLoader($file->url());
        $manifest = $loader->load();

        $this->assertEquals($content["name"], $manifest->getName());
        $this->assertEquals($content["archiveUri"], $manifest->getArchiveUri());
        $this->assertEquals($content["injectTasks"], $manifest->getInjectTasks());
    }
}
