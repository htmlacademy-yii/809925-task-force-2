<?php

namespace App\Classes\Model;


abstract class AbstractAction 
{

    const ACTION_START = 'start';
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_COMPLETE = 'complete';
    const ACTION_FAIL = 'fail';
    
    abstract public function getName() : string;
    abstract public function getInnerName() : string;
    abstract public static function checkVerification(?int $executorId, int $customerId, int $userId) : bool;
}


