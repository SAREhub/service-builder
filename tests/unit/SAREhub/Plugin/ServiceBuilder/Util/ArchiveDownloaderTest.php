<?php

namespace SAREhub\Plugin\ServiceBuilder\Util;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use PhpZip\ZipFile;

class ArchiveDownloaderTest extends TestCase
{

    public function testDownload()
    {
        $vfsRoot = vfsStream::setup("root", null, [
            "extractDir" => []
        ]);

        $zipFile = new ZipFile();
        $zipFile->addFromString("test.txt", "abc");
        $archiveFile = vfsStream::newFile("archive.zip")->setContent($zipFile->outputAsString());
        $vfsRoot->addChild($archiveFile);

        $downloader = new ArchiveDownloader();
        $downloader->download($archiveFile->url(), $vfsRoot->url()."/extractDir");

        $extractedFile = $vfsRoot->getChild("extractDir/test.txt");
        $this->assertNotNull($extractedFile);
        $this->assertEquals("abc", $extractedFile->getContent());
    }
}
