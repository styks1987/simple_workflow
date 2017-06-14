<?php

namespace App;

class WorkflowEntity
{
    public function __construct($entity, $permissions = [])
    {
        $this->entity = (object) $entity;
        $this->permissions = array_keys(array_filter($permissions));
    }

    public function getStatus()
    {
        return $this->entity->status_id;
    }

    public function setStatus($statusId)
    {
        $this->entity->status_id = $statusId;
        return $this;
    }

    public function isHungry()
    {
        if(in_array('is_hungry', $this->permissions)){
            return true;
        }

        return false;
    }

    public function isSlightlyHungry()
    {
        if(in_array('is_slightly_hungry', $this->permissions)){
            return true;
        }

        return false;
    }
}