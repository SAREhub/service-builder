<?php

namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class MultiInjectStepTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testInject()
    {
        $step = \Mockery::mock(InjectStep::class);
        $multiStep = new MultiInjectStep([$step]);

        $step->expects("inject");

        $multiStep->inject();
    }
}
