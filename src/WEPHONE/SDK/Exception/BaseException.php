<?php

namespace WEPHONE\SDK\Exception;

/**
 * Base Exception
 */
class BaseException extends \Exception
{
    protected $errorCode;

    public function __construct($message="", $errorCode = null, \Exception $previous = null) {
        if ($errorCode) {
            $this->errorCode = $errorCode;
        }
        parent::__construct($message, 0, new \Exception("Application exception", 0));
    }
    
    public function getErrorCode() {
        return $this->errorCode;
    }
}
