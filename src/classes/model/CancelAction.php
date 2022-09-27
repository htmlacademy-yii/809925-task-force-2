<?php

namespace TaskForce\classes\model;

class CancelAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик отменил задание';
    }
   
    public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool
    {
        return ($customerId === $userId);
    }
}