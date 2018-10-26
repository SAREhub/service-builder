<?php


namespace SAREhub\Plugin\ServiceBuilder\Util\Task\CopyFiles;


use SAREhub\Commons\Task\Task;
use SAREhub\Plugin\ServiceBuilder\Util\Task\TaskFactory;

class CopyFilesTaskFactory implements TaskFactory
{

    const PARAM_FILES = "files";

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

    public function create(array $parameters): Task
    {
        return new CopyFilesTask($parameters[self::PARAM_FILES], $this->srcRootDir, $this->distRootDir);
    }
}