<?php

namespace App\Classes\Model;

class CancelAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик отменил задание';
    }
   
    public static function checkVerification(?int $executoId, int $customerId, int $userId) : bool 
    {
        return ($customerId === $userId);
    }
}