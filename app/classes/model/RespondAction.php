<?php

namespace App\Classes\Model;

class RespondAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик выбрал исполнителя для задания';
    }

    public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool 
    {
        return is_null($executorID) && $userId !== $customerId;
    }
}