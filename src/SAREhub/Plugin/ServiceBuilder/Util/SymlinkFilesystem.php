<?php

namespace SAREhub\Plugin\ServiceBuilder\Util;


use Composer\Util\Filesystem;

class SymlinkFilesystem extends Filesystem
{
    public function ensureSymlinkExists($sourcePath, $symlinkPath): bool
    {
        if (!is_link($symlinkPath)) {
            $this->ensureDirectoryExists(dirname($symlinkPath));
            return symlink($sourcePath, $symlinkPath);
        }
        return false;
    }

    public function removeSymlink($symlinkPath): bool
    {
        if (is_link($symlinkPath)) {
            if (!$this->unlink($symlinkPath)) {
                // @codeCoverageIgnoreStart
                throw new \RuntimeException('Unable to remove the symlink : ' . $symlinkPath);
                // @codeCoverageIgnoreEnd
            }
            return true;
        }
        return false;
    }

    public function removeEmptyDirectory($directoryPath): bool
    {
        if (is_dir($directoryPath) && $this->isDirEmpty($directoryPath)) {
            if (!$this->removeDirectory($directoryPath)) {
                // @codeCoverageIgnoreStart
                throw new \RuntimeException('Unable to remove the directory : ' . $directoryPath);
                // @codeCoverageIgnoreEnd
            }
            return true;
        }
        return false;
    }
}