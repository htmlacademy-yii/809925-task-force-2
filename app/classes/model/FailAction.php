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
        return parent::ACTION_FAIL;
    }
   
    public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool 
    {
        return ($executorId === $userId);
    }
}