<?php


namespace SAREhub\Plugin\ServiceBuilder\Recipe\Inject;


interface InjectStepFactory
{
    public function create(array $data): InjectStep;
}