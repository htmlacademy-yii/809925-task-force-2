<?php

namespace TaskForce\classes\model;

abstract class AbstractAction 
{
    abstract public function getName() : string;
    abstract public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool;
}


