<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe;


use PhpZip\ZipFile;
use PhpZip\ZipFileInterface;

class RecipeArchiveDownloader
{
    /**
     * @var Recipe
     */
    private $recipe;

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @param string $repositoryUri
     * @throws \PhpZip\Exception\InvalidArgumentException
     * @throws \PhpZip\Exception\ZipException
     * @return string Root directory of created project
     */
    public function download(string $repositoryUri): string
    {
        $file = file_get_contents($this->formatRepositoryArchiveUri($repositoryUri, $this->recipe->getName()));
        $zipFile = (new ZipFile())->openFromString($file);
        $rootDirectory = $zipFile->getListFiles()[0];

        $zipFile->extractTo(getcwd(), $this->getAdditionalFilesFromArchive($rootDirectory));
        $zipFile->extractTo(getcwd(), $this->getSourceFilesFromArchive($zipFile, $rootDirectory));
        $this->rcopy(getcwd().$rootDirectory."src", getcwd().$rootDirectory.$this->recipe->getNamespace()."/src");
        return $rootDirectory;
    }

    private function formatRepositoryArchiveUri(string $repositoryUri, string $recipeName): string
    {
        return sprintf("%s/%s/archive/master.zip", $repositoryUri, $recipeName);
    }

    private function getAdditionalFilesFromArchive($rootDirectory): array
    {
        $additionalFiles = $this->recipe->getAdditionalFiles();
        foreach ($additionalFiles as $key => $path) {
            $additionalFiles[$key] = $rootDirectory . $path;
        }
        return $additionalFiles;
    }

    private function getSourceFilesFromArchive(ZipFileInterface $zipFile, $rootDirectory): array
    {
        $sourceFiles = [];
        foreach ($zipFile->getListFiles() as $filePath) {
            if (strpos($filePath, $rootDirectory . "src")) {
                $sourceFiles[] = $filePath;
            }
            continue;
        }
        return $sourceFiles;
    }

    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
            rmdir($dir);
        }
        else if (file_exists($dir)) unlink($dir);
    }

    private function rcopy($src, $dst) {
        if (file_exists ( $dst ))
            $this->rrmdir ( $dst );
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file )
                if ($file != "." && $file != "..")
                    $this->rcopy ( "$src/$file", "$dst/$file" );
        } else if (file_exists ( $src ))
            copy ( $src, $dst );
    }
}