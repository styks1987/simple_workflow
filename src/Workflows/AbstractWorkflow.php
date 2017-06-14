<?php

namespace App\Workflows;

abstract class AbstractWorkflow implements WorkflowInterface
{
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    abstract public function getNext();

    abstract public function getAllNext();

    public function setCurrent($id)
    {
        $this->entity->setStatus($id);
        return $this;
    }

    public function getCurrent()
    {
        return $this->entity->getStatus();
    }
}