<?php

namespace TaskForce\classes\model;

class RespondAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик выбрал исполнителя для задания';
    }

    public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool 
    {
        return is_null($executorId) && $userId !== $customerId;
    }
}