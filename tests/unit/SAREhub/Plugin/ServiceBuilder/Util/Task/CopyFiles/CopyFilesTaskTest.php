<?php

namespace SAREhub\Plugin\ServiceBuilder\Util\Task\CopyFiles;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class CopyFilesTaskTest extends TestCase
{

    public function testRunWhenFileIsNotNestedThenIsCopied()
    {
        $filesToCopy = [
            "test.txt" => "copied.txt"
        ];
        $vfsRoot = $this->createFilesStructure([
            "test_src" => [
                "test.txt" => "abc"
            ],
            "test_dest" => []
        ]);
        $rootDir = $vfsRoot->url();
        $injectStep = new CopyFilesTask($filesToCopy, $rootDir . "/test_src", $rootDir . "/test_dest");

        $injectStep->run();

        $this->assertFile("abc", "root/test_dest/copied.txt", $vfsRoot);
    }

    public function testRunWhenFileIsNestedThenIsCopied()
    {
        $filesToCopy = [
            "dir/test.txt" => "copied/copied.txt"
        ];
        $vfsRoot = $this->createFilesStructure([
            "test_src" => [
                "dir" => [
                    "test.txt" => "abc"
                ]
            ],
            "test_dest" => []
        ]);
        $rootDir = $vfsRoot->url();
        $injectStep = new CopyFilesTask($filesToCopy, $rootDir . "/test_src", $rootDir . "/test_dest");

        $injectStep->run();

        $this->assertFile("abc", "root/test_dest/copied/copied.txt", $vfsRoot);
    }

    public function testRunWhenSrcFileIsDirAndNotEndingWithSlashThenCopyRecursive()
    {
        $filesToCopy = [
            "dir" => "copied"
        ];
        $vfsRoot = $this->createFilesStructure([
            "test_src" => [
                "dir" => [
                    "test1.txt" => "abc1",
                    "nested" => [
                        "test2.txt" => "abc2"
                    ]
                ]
            ],
            "test_dest" => []
        ]);
        $rootDir = $vfsRoot->url();
        $injectStep = new CopyFilesTask($filesToCopy, $rootDir . "/test_src", $rootDir . "/test_dest");

        $injectStep->run();

        $this->assertFile("abc1", "root/test_dest/copied/dir/test1.txt", $vfsRoot);
        $this->assertFile("abc2", "root/test_dest/copied/dir/nested/test2.txt", $vfsRoot);
    }

    public function testRunWhenSrcFileIsDirAndEndingWithSlashThenCopyRecursive()
    {
        $filesToCopy = [
            "dir/" => "copied"
        ];
        $vfsRoot = $this->createFilesStructure([
            "test_src" => [
                "dir" => [
                    "test1.txt" => "abc1",
                    "nested" => [
                        "test2.txt" => "abc2"
                    ]
                ]
            ],
            "test_dest" => []
        ]);
        $rootDir = $vfsRoot->url();
        $injectStep = new CopyFilesTask($filesToCopy, $rootDir . "/test_src", $rootDir . "/test_dest");

        $injectStep->run();

        $this->assertFile("abc1", "root/test_dest/copied/test1.txt", $vfsRoot);
        $this->assertFile("abc2", "root/test_dest/copied/nested/test2.txt", $vfsRoot);
    }

    private function createFilesStructure(array $structure): vfsStreamDirectory
    {
        return vfsStream::setup("root", null, $structure);
    }

    private function assertFile(string $expectedContent, string $path, vfsStreamDirectory $vfsRoot)
    {
        $file = $vfsRoot->getChild($path);
        $this->assertNotNull($file, "file exists");
        $this->assertEquals($expectedContent, $file->getContent(), "file content");
    }
}
