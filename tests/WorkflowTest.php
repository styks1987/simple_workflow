<?php

require_once('vendor/autoload.php');

class WorkflowTest extends PHPUnit_Framework_TestCase
{
    public function testIsHungryFalse()
    {
        $entity = new \App\WorkflowEntity([], ['is_hungry' => false]);
        $this->assertFalse($entity->isHungry());
    }

    public function testIsHungry()
    {
        $entity = new \App\WorkflowEntity([], ['is_hungry' => true]);
        $this->assertTrue($entity->isHungry());
    }

    public function testIsSlightlyHungry()
    {
        $entity = new \App\WorkflowEntity([], ['is_slightly_hungry' => true]);
        $this->assertFalse($entity->isHungry());
        $this->assertTrue($entity->isSlightlyHungry());
    }

    public function testNextWakeUp()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => 0
        ]);
        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);
        $this->assertEquals(\App\Workflows\BreakfastWorkflow::WAKEUP, $breakfastWorkflow->getNext()[0]);
    }

    public function testNextDress()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => \App\Workflows\BreakfastWorkflow::WAKEUP
        ]);
        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);
        $this->assertEquals(\App\Workflows\BreakfastWorkflow::DRESS, $breakfastWorkflow->getNext()[0]);
    }

    public function testSetNextPass()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => \App\Workflows\BreakfastWorkflow::WAKEUP
        ]);
        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);
        $breakfastWorkflow->setCurrent(\App\Workflows\BreakfastWorkflow::DRESS);
        $this->assertEquals(\App\Workflows\BreakfastWorkflow::DRESS, $breakfastWorkflow->getCurrent());
    }

    public function testSetNextFails()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => \App\Workflows\BreakfastWorkflow::WAKEUP
        ]);

        $this->expectException(Exception::class);

        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);
        $breakfastWorkflow->setCurrent(\App\Workflows\BreakfastWorkflow::LEAVE);
    }

    public function testSetNextAny()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => \App\Workflows\BreakfastWorkflow::WAKEUP
        ]);

        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);
        $breakfastWorkflow->setCurrent(\App\Workflows\BreakfastWorkflow::SLIPANDDIE);

        $this->assertEquals(\App\Workflows\BreakfastWorkflow::SLIPANDDIE, $breakfastWorkflow->getCurrent());

        $this->assertEmpty($breakfastWorkflow->getNext());
    }

    public function testSetNextEatHungryFail()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => \App\Workflows\BreakfastWorkflow::DRESS
        ]);

        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);

        $this->expectException(Exception::class);

        $breakfastWorkflow->setCurrent(\App\Workflows\BreakfastWorkflow::EAT);
    }

    public function testSetNextEatHungryPass()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => \App\Workflows\BreakfastWorkflow::DRESS
        ], ['is_hungry' => true]);

        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);

        $breakfastWorkflow->setCurrent(\App\Workflows\BreakfastWorkflow::EAT);

        $this->assertEquals(\App\Workflows\BreakfastWorkflow::EAT, $breakfastWorkflow->getCurrent());

    }

    public function testSetNextEatSlightlyHungryPass()
    {
        $entity = new \App\WorkflowEntity([
            'status_id' => \App\Workflows\BreakfastWorkflow::DRESS
        ], ['is_slightly_hungry' => true, 'is_hungry' => false]);

        $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);

        $breakfastWorkflow->setCurrent(\App\Workflows\BreakfastWorkflow::LEAVE);

        $this->assertEquals(\App\Workflows\BreakfastWorkflow::LEAVE, $breakfastWorkflow->getCurrent());

    }
}

