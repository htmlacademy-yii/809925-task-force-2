<?php
class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_WORK = 'work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const ACTION_START = 'start';
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_COMPLETE = 'complete';
    const ACTION_FAIL = 'fail';

    private $executorId;
    private $customerId;
    private $status;

    public function __construct($status, $customerId, $executorId = null)
    {
        $this->status     = $status;
        $this->executorId = $executorId;
        $this->customerId = $customerId;
    }

    public function getStatusesMap()
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_WORK => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public function getActionsMap()
    {
        return [
            self::ACTION_START  => 'Задание опубликовано, исполнитель ещё не найден',
            self::ACTION_CANCEL => 'Заказчик отменил задание',
            self::ACTION_RESPOND => 'Заказчик выбрал исполнителя для задания',
            self::ACTION_COMPLETE => 'Заказчик отметил задание как выполненное',
            self::ACTION_FAIL => 'Исполнитель отказался от выполнения задания',
        ];
    }

    public function getStatusByAction($actionName)
    {
        switch($actionName) {
            case self::ACTION_START:
                return self::STATUS_NEW;

            case self::ACTION_CANCEL:
                return self::STATUS_CANCELLED;

            case self::ACTION_RESPOND:
                return self::STATUS_WORK;

            case self::ACTION_COMPLETE:
                return self::STATUS_DONE;

            case self::ACTION_FAIL:
                return self::STATUS_FAILED;

            default:
                return null;
        }

    }

    public function getAvailableActions($currentUserId)
    {
        switch($this->status) {
            case self::STATUS_NEW:
                if ($currentUserId === $this->customerId) {
                    return [self::ACTION_START, self::ACTION_CANCEL];
                }
                return [self::ACTION_RESPOND];
            case self::STATUS_WORK:
                if ($currentUserId === $this->customerId) {
                    return [self::ACTION_COMPLETE];
                }
                if ($currentUserId === $this->executorId) {
                    return [self::ACTION_FAIL];
                }
                return [];
            default:
                return [];
        }
    }
}
