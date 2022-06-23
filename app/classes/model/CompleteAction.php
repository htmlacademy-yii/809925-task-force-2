<?php

namespace App\Classes\Model;

class CompleteAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик отметил задание как выполненное';
    }

    public function getInnerName() : string 
    {
        return Task::ACTION_COMPLETE;
    }

    public function checkVerification(int $executorId, int $customerId, int $userId) : bool 
    {
        return ($customerId === $userId);
    }
}