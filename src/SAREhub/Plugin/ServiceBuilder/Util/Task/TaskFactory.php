<?php


namespace SAREhub\Plugin\ServiceBuilder\Util\Task;


use SAREhub\Commons\Task\Task;

interface TaskFactory
{
    public function create(array $parameters): Task;
}