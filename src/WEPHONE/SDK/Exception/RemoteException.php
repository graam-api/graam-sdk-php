<?php

namespace WEPHONE\SDK\Exception;

/**
 * Remote (API) Exception
 */
class RemoteException extends BaseException
{
    
    protected $errorCode;
    
    /**
     * Constructor
     * @internal
     * @param \stdClass JSON-RPC "error" property
     */
    public function __construct(\stdClass $error)
    {
        $this->errorCode = $error->code;
        parent::__construct($error->message, 0);
    }
}
