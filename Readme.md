# Simple Workflow Definition Example

Purpose is to allow pushing a similar entity through multiple workflows with differing permissions

Getting the next place

```php
    $entity = new \App\WorkflowEntity([
        'status_id' => \App\Workflows\BreakfastWorkflow::WAKEUP
    ]);
    $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);
    $this->assertEquals(
        \App\Workflows\BreakfastWorkflow::DRESS,
        $breakfastWorkflow->getNext()[0]
    );
```

Setting a new place

```php
    $entity = new \App\WorkflowEntity([
        'status_id' => \App\Workflows\BreakfastWorkflow::WAKEUP
    ]);
    $breakfastWorkflow = new \App\Workflows\BreakfastWorkflow($entity);
    $breakfastWorkflow->setCurrent(\App\Workflows\BreakfastWorkflow::DRESS);
    $this->assertEquals(
        \App\Workflows\BreakfastWorkflow::DRESS,
        $breakfastWorkflow->getCurrent()
    );

```

Run the tests

```vendor/bin/phpunit ./tests```