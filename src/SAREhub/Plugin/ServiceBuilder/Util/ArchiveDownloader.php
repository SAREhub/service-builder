<?php


namespace SAREhub\Plugin\ServiceBuilder\Util;


use PhpZip\ZipFile;

class ArchiveDownloader
{
    public function download(string $uri, $extractPath)
    {
        $zipFile = new ZipFile();
        $content = file_get_contents($uri);
        $zipFile->openFromString($content);
        $zipFile->extractTo($extractPath);
    }
}