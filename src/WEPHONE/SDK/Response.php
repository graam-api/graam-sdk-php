<?php

namespace WEPHONE\SDK;

/**
 * JSON-RPC 2.0 Response
 * @author Kien Ngo <kien.ngo@wephone.io>
 */
class Response
{
//     public $jsonrpc;
//     public $id;
    public $result;
    public $error;

    /**
     * Constructor
     * @param string Raw input
     * @throws \WEPHONE\SDK\Exception\LocalException
     */
    public function __construct($msg)
    {
        $data = json_decode($msg);
        /* validation */
        if (is_object($data)) {
            /* response */
            if (property_exists($data, 'error')) {
                $this->error = new Exception\RemoteException($data->error);
            } else {
                $this->result = $data->answer;
            }
        }
        else {
            throw new Exception\RemoteException($msg);
        }
    }

    /**
     * Is the response an error?
     * @return boolean Error?
     */
    public function isError()
    {
        return $this->error !== null;
    }
}
