<?php

namespace TaskForce\classes\model;

class StartAction extends AbstractAction 
{

    public function getName() : string 
    {
       return 'Задание опубликовано, исполнитель ещё не найден';
    }
   
    public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool 
    {
        return ($customerId === $userId);
    }
}