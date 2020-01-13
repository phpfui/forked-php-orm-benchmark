<?php

use Cycle\ORM\Mapper\Mapper;

class GeneratedBookMapper extends Mapper
{
    public function __construct(\Cycle\ORM\ORMInterface $orm, string $role)
    {
        parent::__construct($orm, $role);

        $config = new \GeneratedHydrator\Configuration($this->entity);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $this->hydrator = new $hydratorClass();
    }
}