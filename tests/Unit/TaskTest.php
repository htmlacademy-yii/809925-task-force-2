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

    public function getActionStart(): StartAction
    {
        return new StartAction();
    }
    public function getActionCancel(): CancelAction
    {
        return new CancelAction();
    }
    public function getActionComplete(): CompleteAction
    {
        return new CompleteAction();
    }
    public function getActionFail(): FailAction
    {
        return new FailAction();
    }
    public function getActionRespond(): RespondAction
    {
        return new RespondAction();
    }

    public function getActionsNames($actions): array
    {
        return array_map(
            function($action) {
                return $action->getInnerName();
            },
            $actions
        );
    }

    public function testActionsStart()
    {
        $task = new Task(Task::STATUS_NEW, self::TEST_CUSTOMER_ID);
        $availableActions = $task->getAvailableActions(self::TEST_CUSTOMER_ID);

        $this->assertEqualsCanonicalizing(
            [
                $this->getActionStart()->getInnerName(),
                $this->getActionCancel()->getInnerName(),
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
                $this->getActionRespond()->getInnerName(),
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
                $this->getActionComplete()->getInnerName(),
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
                $this->getActionFail()->getInnerName(),
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
        $this->assertEquals(Task::STATUS_CANCELLED, $task->getStatusByAction($this->getActionCancel()));
    }
}
