<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Task;

require __DIR__ . '/../../classes/Task.php';

class TaskTest extends TestCase
{
    public function testGetStatusByAction()
    {
        $task = new Task(Task::STATUS_NEW, 1, 2);
        $this->assertEquals(Task::STATUS_CANCELLED, $task->getStatusByAction(Task::ACTION_CANCEL));
    }

    public function testGetAvailableActions()
    {
        $customerId = 1;
        $executorId = 2;
        $randomUserId = 3;
        $task = new Task(Task::STATUS_NEW, $customerId);
        $this->assertEquals([Task::ACTION_START, Task::ACTION_CANCEL], $task->getAvailableActions($customerId));
        $this->assertEquals([Task::ACTION_RESPOND], $task->getAvailableActions($randomUserId));

        $task = new Task(Task::STATUS_WORK, $customerId, $executorId);
        $this->assertEquals([Task::ACTION_COMPLETE], $task->getAvailableActions($customerId));
        $this->assertEquals([Task::ACTION_FAIL], $task->getAvailableActions($executorId));
        $this->assertEquals([], $task->getAvailableActions($randomUserId));
    }
}
