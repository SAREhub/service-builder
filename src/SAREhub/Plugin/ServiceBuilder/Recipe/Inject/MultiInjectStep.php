<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject;


class MultiInjectStep implements InjectStep
{

    /**
     * @var InjectStep[]
     */
    private $steps;

    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    public function inject()
    {
        foreach ($this->steps as $step) {
            $step->inject();
        }
    }

    public function getSteps(): array
    {
        return $this->steps;
    }
}