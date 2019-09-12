<?php

namespace GRAAM\SDK\Exception;

/**
 * Remote (API) Exception
 */
class RemoteException extends BaseException
{
    
    protected $errorCode = 'remote';
    
    /**
     * Constructor
     * @internal
     * @param \stdClass JSON-RPC "error" property
     */
    public function __construct(\stdClass $error)
    {
        if (property_exists($error, 'code')) {
            $this->errorCode = $error->code;
        }
        parent::__construct($error->message, 0);
    }
}
