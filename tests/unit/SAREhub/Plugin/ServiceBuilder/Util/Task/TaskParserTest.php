<?php

namespace SAREhub\Plugin\ServiceBuilder\Util\Task;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use SAREhub\Commons\Task\Task;

class TaskParserTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var TaskParser
     */
    private $parser;

    protected function setUp()
    {
        $this->parser = new TaskParser();
    }

    public function testParse()
    {
        $factory = \Mockery::mock(TaskFactory::class);
        $this->parser->addFactory("test_type", $factory);
        $rawTasks = [["type" => "test_type", "parameters" => ["test_data"]]];
        $expected = \Mockery::mock(Task::class);
        $factory->expects("create")->with($rawTasks[0]["parameters"])->andReturn($expected);

        $sequence = $this->parser->parse($rawTasks);

        $this->assertCount(1, $sequence->getTasks());
        $this->assertSame($expected, $sequence->getTasks()[0]);
    }
}
