<?php

namespace Src\Classes\Model;

use  Src\Classes\Exceptions;

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

        if (!array_key_exists($status, $this->getStatusesMap())) {
            throw new ExceptionTask("Некорректный статус");
        }

        if ($customerId === $executorId) {
            throw new ExceptionTask("Заказчик не может быть исполнителем");
        }
        
        $this->status     = $status;
        $this->executorId = $executorId;
        $this->customerId = $customerId;
    }

    
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

    public function getStatusByAction(AbstractAction $action): ?string
    {
        switch(true) {
            case $action instanceof StartAction:
                return self::STATUS_NEW;

            case  $action instanceof CancelAction:
                return self::STATUS_CANCELLED;

            case $action instanceof RespondAction:
                return self::STATUS_WORK;

            case $action instanceof CompleteAction:
                return self::STATUS_DONE;

            case $action instanceof FailAction:
                return self::STATUS_FAILED;

            default:
                return null;
        }
    }
    
    public function getAvailableActions(int $currentUserId): array
    {

        $actions = $this->getActionsByStatuses();
        $availableActions = [];

        foreach ($actions[$this->status] as $action) {
            if ($action::checkVerification($this->executorId, $this->customerId, $currentUserId)) {
                $availableActions[] = new $action();
            }
        }

        return $availableActions;
    }

    public function getActionsByStatuses(): array
    {
        return [
            self::STATUS_NEW => [
                StartAction::class,
                CancelAction::class,
                RespondAction::class,
            ],

            self::STATUS_WORK => [
                CompleteAction::class,
                FailAction::class,
            ]
            
        ];
    }
}
