<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\Model\Task;

class TaskTest extends TestCase
{
    const TEST_CUSTOMER_ID = 1;
    const TEST_EXECUTOR_ID = 2;
    const TEST_RANDOM_USER_ID = 3;

    public function testGetStatusByAction()
    {
        $task = new Task(Task::STATUS_NEW, 1, 2);
        $this->assertEquals(Task::STATUS_CANCELLED, $task->getStatusByAction(Task::ACTION_CANCEL));
    }

    public function testActionsStart()
    {
        $task = new Task(Task::STATUS_NEW, self::TEST_CUSTOMER_ID);
        $this->assertEquals([Task::ACTION_START, Task::ACTION_CANCEL], $task->getAvailableActions(self::TEST_CUSTOMER_ID));
    }

    public function testActionsRespond()
    {
        $task = new Task(Task::STATUS_NEW, self::TEST_CUSTOMER_ID);
        $this->assertEquals([$task::ACTION_START, $task::ACTION_CANCEL], $task->getAvailableActions(self::TEST_CUSTOMER_ID));
    }

    public function testActionsComplete()
    {
        $task = new Task(Task::STATUS_WORK, self::TEST_CUSTOMER_ID, self::TEST_EXECUTOR_ID);
        $this->assertEquals([Task::ACTION_COMPLETE], $task->getAvailableActions(self::TEST_CUSTOMER_ID));
    }

    public function testActionsFail()
    {
        $task = new Task(Task::STATUS_WORK, self::TEST_CUSTOMER_ID, self::TEST_EXECUTOR_ID);
        $this->assertEquals([Task::ACTION_FAIL], $task->getAvailableActions(self::TEST_EXECUTOR_ID));
    }

    public function testActionsForRandomUser()
    {
        $task = new Task(Task::STATUS_WORK, self::TEST_CUSTOMER_ID, self::TEST_EXECUTOR_ID);
        $this->assertEquals([], $task->getAvailableActions(self::TEST_RANDOM_USER_ID));
    }

}
