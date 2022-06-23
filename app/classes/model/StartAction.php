<?php

namespace App\Classes\Model;

class StartAction extends AbstractAction 
{

    public function getName() : string 
    {
       return 'Задание опубликовано, исполнитель ещё не найден';
    }

    public function getInnerName() : string 
    {
        return Task::ACTION_START;
    }
   
    public function checkVerification(int $executorId, int $customerId, int $userId) : bool 
    {
        return ($customerId === $userId);
    }
}