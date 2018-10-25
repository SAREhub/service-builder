<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class InjectStepParserTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var InjectStepParser
     */
    private $parser;

    protected function setUp()
    {
        $this->parser = new InjectStepParser();
    }

    public function testParse()
    {
        $factory = \Mockery::mock(InjectStepFactory::class);
        $this->parser->addStepFactory("test_type", $factory);
        $rawInjectSteps = [["type" => "test_type", "parameters" => ["test_data"]]];
        $expectedInjectStep = \Mockery::mock(InjectStep::class);
        $factory->expects("create")->with($rawInjectSteps[0]["parameters"])->andReturn($expectedInjectStep);

        $multiInjectStep = $this->parser->parse($rawInjectSteps);

        $this->assertCount(1, $multiInjectStep->getSteps());
        $this->assertSame($expectedInjectStep, $multiInjectStep->getSteps()[0]);
    }
}
