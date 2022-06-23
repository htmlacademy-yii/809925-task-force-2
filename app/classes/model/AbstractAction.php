<?php

namespace App\Classes\Model;


abstract class AbstractAction 
{
    abstract public function getName() : string;
    abstract public function getInnerName() : string;
    abstract public function checkVerification(int $executorId, int $customerId, int $userId) : bool;
}


