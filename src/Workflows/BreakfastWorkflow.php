<?php

namespace App\Workflows;

class BreakfastWorkflow extends AbstractWorkflow
{
    const WAKEUP = 1;
    const DRESS = 2;
    const EAT = 3;
    const LEAVE = 4;
    const STOP = 5;
    const ARRIVE = 6;
    const SLIPANDDIE = 6;

    public function getNext()
    {
        switch ($this->getCurrent()) {
            case self::WAKEUP:
                return [self::DRESS];
            case self::DRESS:
                if($this->entity->isHungry()) {
                    return [self::EAT];
                } elseif($this->entity->isSlightlyHungry()){
                    return [self::EAT, self::LEAVE];
                }
                return [self::LEAVE];
            case self::EAT:
                return [self::LEAVE];
            case self::LEAVE;
                return [self::ARRIVE];
            case self::STOP;
                return [];
            case self::ARRIVE;
                return [];
            case self::SLIPANDDIE;
                return [];
            default:
                return [self::WAKEUP];
        }
    }

    public function getAllNext()
    {
        if(!empty($this->getNext())) {
            return array_unique(array_merge($this->getNext(), [self::STOP, self::SLIPANDDIE]));
        }

        return [];
    }

    public function setCurrent($id)
    {
        if(!in_array($id, $this->getAllNext())){
            throw new \Exception('You cannot set this as the next step');
        }

        return parent::setCurrent($id);
    }
}