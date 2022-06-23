<?php

namespace App\Classes\Model;

class RespondAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик выбрал исполнителя для задания';
    }

    public function getInnerName() : string 
    {
        return Task::ACTION_RESPOND;
    }

    public function checkVerification(int $executorId, int $customerId, int $userId) : bool 
    {
        return ($customerId === $userId);
    }
}