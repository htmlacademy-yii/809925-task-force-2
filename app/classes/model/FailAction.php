<?php

namespace App\Classes\Model;

class FailAction extends AbstractAction 
{

    public function getName() : string 
    {
        return 'Исполнитель отказался от выполнения задания';
    }

    public function getInnerName() : string 
    {
        return Task::ACTION_FAIL;
    }
   
    public function checkVerification(int $executorId, int $customerId, int $userId) : bool 
    {
        return ($executorId === $userId);
    }
}