<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject;


interface InjectStepFactory
{
    public function create(array $parameters): InjectStep;
}