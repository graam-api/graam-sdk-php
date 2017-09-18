<?php

namespace WEPHONE\SDK\Exception;

/**
 * Base Exception
 */
class BaseException extends \Exception
{
    protected $errorCode;
    
    public function getErrorCode() {
        return $this->errorCode;
    }
}
