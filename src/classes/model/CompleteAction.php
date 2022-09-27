<?php

namespace TaskForce\classes\model;

class CompleteAction extends AbstractAction 
{
    public function getName() : string 
    {
        return 'Заказчик отметил задание как выполненное';
    }

    public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool 
    {
        return ($customerId === $userId);
    }
}