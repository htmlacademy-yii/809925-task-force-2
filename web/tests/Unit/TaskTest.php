<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\Model\Task;
use App\Classes\Model\AbstractAction;
use App\Classes\Model\StartAction;
use App\Classes\Model\CancelAction;
use App\Classes\Model\CompleteAction;
use App\Classes\Model\FailAction;
use App\Classes\Model\RespondAction;

class TaskTest extends TestCase
{
    const TEST_CUSTOMER_ID = 1;
    const TEST_EXECUTOR_ID = 2;
    const TEST_RANDOM_USER_ID = 3;

    public function testActionsStart()
    {
        $task = new Task(Task::STATUS_NEW, self::TEST_CUSTOMER_ID);
        $availableActions = $task->getAvailableActions(self::TEST_CUSTOMER_ID);

        $this->assertEqualsCanonicalizing(
            [
                StartAction::class,
                CancelAction::class,
            ],
            $this->getActionsNames($availableActions)
        );
    }

    public function testActionsRespond()
    {
        $task = new Task(Task::STATUS_NEW, self::TEST_CUSTOMER_ID);
        $availableActions = $task->getAvailableActions(self::TEST_EXECUTOR_ID);

        $this->assertEqualsCanonicalizing(
            [
                RespondAction::class,
            ],
            $this->getActionsNames($availableActions)
        );
    }

    public function testActionsComplete()
    {
        $task = new Task(Task::STATUS_WORK, self::TEST_CUSTOMER_ID, self::TEST_EXECUTOR_ID);
        $availableActions = $task->getAvailableActions(self::TEST_CUSTOMER_ID);

        $this->assertEqualsCanonicalizing(
            [
                CompleteAction::class,
            ],
            $this->getActionsNames($availableActions)
        );
    }

    public function testActionsFail()
    {
        $task = new Task(Task::STATUS_WORK, self::TEST_CUSTOMER_ID, self::TEST_EXECUTOR_ID);
        $availableActions = $task->getAvailableActions(self::TEST_EXECUTOR_ID);

        $this->assertEqualsCanonicalizing(
            [
                FailAction::class,
            ],
            $this->getActionsNames($availableActions)
        );
    }

    public function testActionsForRandomUser()
    {
        $task = new Task(Task::STATUS_WORK, self::TEST_CUSTOMER_ID, self::TEST_EXECUTOR_ID);
        $availableActions = $task->getAvailableActions(self::TEST_RANDOM_USER_ID);

        $this->assertEquals(0, count($availableActions));
    }

    public function testGetStatusByAction()
    {
        $task = new Task(Task::STATUS_NEW, 1, 2);
        $this->assertEquals(Task::STATUS_CANCELLED, $task->getStatusByAction(new CancelAction()));
    }

    public function getActionsNames($actions): array
    {
        return array_map('get_class', $actions);
    }
}
