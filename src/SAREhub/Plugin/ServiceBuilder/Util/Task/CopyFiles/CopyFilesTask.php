<?php


namespace SAREhub\Plugin\ServiceBuilder\Util\Task\CopyFiles;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SAREhub\Commons\Task\Task;

class CopyFilesTask implements Task
{
    /**
     * @var array
     */
    private $filesToCopy;

    /**
     * @var string
     */
    private $srcRootDir;

    /**
     * @var string
     */
    private $destRootDir;

    public function __construct(array $filesToCopy, string $srcRootDir, string $destRootDir)
    {
        $this->filesToCopy = $filesToCopy;
        $this->srcRootDir = $srcRootDir;
        $this->destRootDir = $destRootDir;
    }

    public function run()
    {
        foreach ($this->filesToCopy as $srcFile => $destFile) {
            $srcFilePath = $this->srcRootDir . "/" . $srcFile;
            $destFilePath = $this->destRootDir . "/" . $destFile;
            if (is_dir($srcFilePath)) {
                $this->copyRecursive($srcFilePath, $destFilePath);
            } else {
                $this->copyFileTo($srcFilePath, $destFilePath);
            }
        }
    }

    public function copyRecursive(string $srcDir, string $destDir)
    {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($srcDir, FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($it as $info) {
            /** @var \SplFileInfo $info */
            if ($info->isFile()) {
                $this->copyFileTo($info->getPathname(), $this->createDestFilePath($srcDir, $destDir, $info));
            }
        }
    }

    public function createDestFilePath(string $srcDir, string $destDir, \SplFileInfo $info): string
    {
        if (substr($srcDir, -1) === "/") {
            return $destDir . "/" . substr($info->getPathname(), strlen($srcDir));
        } else {
           return $destDir . substr($info->getPathname(), strlen($this->srcRootDir));
        }
    }

    private function copyFileTo(string $srcFilePath, string $destFilePath)
    {
        $this->createDir(dirname($destFilePath));
        copy($srcFilePath, $destFilePath);
    }

    private function createDir(string $dir)
    {
        @mkdir($dir, 0777, true);
    }
}