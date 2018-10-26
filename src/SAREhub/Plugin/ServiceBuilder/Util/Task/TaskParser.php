<?php


namespace SAREhub\Plugin\ServiceBuilder\Util\Task;


use SAREhub\Commons\Task\Sequence;
use SAREhub\Commons\Task\Task;

class TaskParser
{
    /**
     * @var TaskFactory[]
     */
    private $factories = [];

    public function parse(array $rawTasks): Sequence
    {
        $tasks = [];
        foreach ($rawTasks as $rawTask) {
            $tasks[] = $this->factories[$rawTask["type"]]->create($rawTask["parameters"]);
        }
        return new Sequence($tasks);
    }

    public function addFactory(string $type, TaskFactory $factory): self
    {
        $this->factories[$type] = $factory;
        return $this;
    }
}