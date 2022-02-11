<?php
class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_WORK = 'work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const ACTION_START = 'publish';
    const ACTION_CANCEL = 'cancel';
    const ACTION_CHOOSE_PERFORMER = 'choose_performer';
    const ACTION_COMPLETE = 'complete';
    const ACTION_FAIL = 'fail';

    private $performerId;
    private $customerId;
    private $status;

    public function __construct($performerId, $customerId, $status)
    {
        $this->performerId = $performerId;
        $this->customerId  = $customerId;
        $this->status      = $status;
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
            self::ACTION_CHOOSE_PERFORMER => 'Заказчик выбрал исполнителя для задания',
            self::ACTION_COMPLETE => 'Заказчик отметил задание как выполненное',
            self::ACTION_FAIL => 'Исполнитель отказался от выполнения задания',
        ];
    }

    public function getStatusByAction($actionName)
    {
        switch($actionName) {
            case self::ACTION_START:
                $status = self::STATUS_NEW;
                break;

            case self::ACTION_CANCEL:
                $status = self::STATUS_CANCELLED;
                break;

            case self::ACTION_CHOOSE_PERFORMER:
                $status = self::STATUS_WORK;
                break;

            case self::ACTION_COMPLETE:
                $status = self::STATUS_DONE;
                break;

            case self::ACTION_FAIL:
                $status = self::STATUS_FAILED;
                break;

            default:
                $status = '';
        }

        return $status;
    }

    public function getAvailableActions($currentUserId)
    {
        $actions = [];
        if ( $currentUserId === $this->performerId ) {
            switch($this->status) {
                case self::STATUS_NEW:
                    $actions = [self::ACTION_CHOOSE_PERFORMER];
                    break;

                case self::STATUS_WORK:
                    $actions = [self::ACTION_FAIL];
                    break;

                default:
                    $actions = [];
            }
        } elseif ( $currentUserId === $this->customerId ) {
            switch($this->status) {
                case self::STATUS_NEW:
                    $actions = [self::ACTION_CANCEL];
                    break;

                case self::STATUS_WORK:
                    $actions = [self::ACTION_COMPLETE];
                    break;

                default:
                    $actions = [];
            }
        }

        return $actions;
    }

}

