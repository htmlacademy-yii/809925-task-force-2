<?php

namespace App\Classes\Model;

use phpDocumentor\Reflection\Types\Nullable;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_WORK = 'work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    private $executorId;
    private $customerId;
    private $status;

    public function __construct(string $status, int $customerId, ?int $executorId = null)
    {
        $this->status     = $status;
        $this->executorId = $executorId;
        $this->customerId = $customerId;
    }

    /*
    public function getStatusesMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_WORK => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public function getActionsMap(): array
    {
        return [
            self::ACTION_START => new StartAction(),
            self::ACTION_CANCEL => new  CancelAction(),
            self::ACTION_RESPOND => new RespondAction(),
            self::ACTION_COMPLETE => new CompleteAction(),
            self::ACTION_FAIL =>  new FailAction(),
        ];
    }

    */

    public function getStatusByAction(AbstractAction $action): ?string
    {
        switch($action->getInnerName()) {
            case AbstractAction::ACTION_START:
                return self::STATUS_NEW;

            case AbstractAction::ACTION_CANCEL:
                return self::STATUS_CANCELLED;

            case AbstractAction::ACTION_RESPOND:
                return self::STATUS_WORK;

            case AbstractAction::ACTION_COMPLETE:
                return self::STATUS_DONE;

            case AbstractAction::ACTION_FAIL:
                return self::STATUS_FAILED;

            default:
                return null;
        }
    }
    

    public function getAvailableActions(int $currentUserId): array
    {

        $availableActions = [];
        switch($this->status) {
            case self::STATUS_NEW:
                if (StartAction::checkVerification($this->executorId, $this->customerId, $currentUserId)) {
                    $availableActions[] = new StartAction();
                }
                if (CancelAction::checkVerification($this->executorId, $this->customerId, $currentUserId)) {
                    $availableActions[] = new CancelAction();
                }
                if (RespondAction::checkVerification($this->executorId, $this->customerId, $currentUserId)) {
                    $availableActions[] = new RespondAction();
                }
                break;
            case self::STATUS_WORK:
                if (CompleteAction::checkVerification($this->executorId, $this->customerId, $currentUserId)) {
                    $availableActions[] = new CompleteAction();
                }
                if (FailAction::checkVerification($this->executorId, $this->customerId, $currentUserId)) {
                    $availableActions[] = new FailAction();
                }
                break;
            default:
                break;
        }

        return $availableActions;
    }
}
