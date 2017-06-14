<?php
namespace App\Workflows;

interface WorkflowInterface
{
    public function getNext();
    public function getAllNext();

    public function getCurrent();
    public function setCurrent($id);
}