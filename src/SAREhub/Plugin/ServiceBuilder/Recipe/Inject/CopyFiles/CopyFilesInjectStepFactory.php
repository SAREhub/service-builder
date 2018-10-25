<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject\CopyFiles;

use SAREhub\Plugin\ServiceBuilder\Recipe\Inject\InjectStep;
use SAREhub\Plugin\ServiceBuilder\Recipe\Inject\InjectStepFactory;

class CopyFilesInjectStepFactory implements InjectStepFactory
{
    /**
     * @var string
     */
    private $srcRootDir;

    /**
     * @var string
     */
    private $distRootDir;

    public function __construct(string $srcRootDir, string $distRootDir)
    {
        $this->srcRootDir = $srcRootDir;
        $this->distRootDir = $distRootDir;
    }

    public function create(array $parameters): InjectStep
    {
        return new CopyFilesInjectStep($parameters["filesToCopy"], $this->srcRootDir, $this->distRootDir);
    }
}