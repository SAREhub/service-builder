<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject\CopyFiles;

use SAREhub\Plugin\ServiceBuilder\Recipe\Inject\InjectStep;
use SAREhub\Plugin\ServiceBuilder\Recipe\Inject\InjectStepFactory;

class CopyFilesInjectStepFactory implements InjectStepFactory
{
    public function create(array $data): InjectStep
    {
        return new CopyFilesInjectStep($data["filesToCopy"], $data["srcRootDir"], $data["distRootDir"]);
    }
}