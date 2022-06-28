<?php

namespace App\Classes\Model;

class CancelAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик отменил задание';
    }
   
    public function getInnerName() : string 
    {
        return parent::ACTION_CANCEL;
    }
   
    public static function checkVerification(?int $executoId, int $customerId, int $userId) : bool 
    {
        return ($customerId === $userId);
    }
}