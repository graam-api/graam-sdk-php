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
    public function __construct($data)
    {
        $data = json_decode($data);
        if ($data === false) {
            throw new Exception\LocalException('JSON_DECODE_ERROR', json_last_error());
        }
        /* validation */
        if (!is_object($data)) {
            throw new Exception\LocalException('RESPONSE_NOT_AN_OBJECT');
        }
        if (!( property_exists($data, 'status') && ( property_exists($data, 'error') || property_exists($data, 'answer') ) )) { //property_exists($data, 'id') && property_exists($data, 'jsonrpc') && 
            throw new Exception\LocalException('RESPONSE_MISSING_PROPERTY');
        }
        /* response */
        if (property_exists($data, 'error')) {
            $this->error = new Exception\RemoteException($data->error);
        } else {
            $this->result = $data->answer;
        }
//         $this->id = $data->id;
//         $this->jsonrpc = $data->jsonrpc;
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
