<?php


namespace SAREhub\Plugin\ServiceBuilder\Util;


use PhpZip\ZipFile;

class ArchiveDownloader
{
    public function download(string $uri, $extractPath)
    {
        $zipFile = new ZipFile();
        $zipFile->openFile($uri);
        $zipFile->extractTo($extractPath);
    }
}