<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject;


class InjectStepParser
{
    /**
     * @var InjectStepFactory[]
     */
    private $factories = [];

    public function parse(array $rawInjectSteps): MultiInjectStep
    {
        $steps = [];
        foreach ($rawInjectSteps as $rawInjectStep) {
            $steps[] = $this->factories[$rawInjectStep["type"]]->create($rawInjectStep["parameters"]);
        }
        return new MultiInjectStep($steps);
    }

    public function addStepFactory(string $type, InjectStepFactory $factory): self
    {
        $this->factories[$type] = $factory;
        return $this;
    }
}