<?php
namespace GRAAM\SDK;


/**
 * JSON-RPC 2.0 Request
 * @author Kien Ngo <kien.ngo@graam.io>
 */
class Request
{
    const JSON_RPC_VERSION = '2.0';

    public $id = 0;
    public $method;
    public $params = [];

    /**
     * Send the request!
     * @param string $url Endpoint URL
     * @param string[] $headers HTTP headers (array of "Key: Value" strings)
     * @param bool $raw_response Returns the raw response
     * @param string $proxy HTTP proxy to use
     * @return \GRAAM\SDK\Response Response object
     * @throws \GRAAM\SDK\Exception\LocalException
     */
    public function send(
        $url,
        $auth = null,
        array $headers = [],
        $proxy = null,
        $raw_response = false
    ) {
        /* JSON-RPC request */
        $request = new \stdClass;
        $request->id = (int) $this->id;
        $request->method = (string) $this->method;
        $request->params = (array) $this->convertParams();
        $request->jsonrpc = self::JSON_RPC_VERSION;

        /* content type */
        $headers[] = 'Content-Type: application/json-rpc; charset=utf-8';
        $headers[] = 'User-Agent: sdk=PHP; sdk-version='.Client::SDK_VERSION.'; lang-version=' . phpversion() . '; platform='. PHP_OS;
        $headers[] = 'Expect:'; // avoid lighttpd bug
        
        /* curl */
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FAILONERROR, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode((array)$request));
        curl_setopt($c, CURLOPT_FORBID_REUSE, false);
        
        if ( (float) phpversion() < 5.6 ) {
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        }

        if (is_string($proxy)) {
            curl_setopt($c, CURLOPT_PROXY, $proxy);
        }

        $data = curl_exec($c);
        /* curl error */
        if ($data === false) {
            throw new Exception\LocalException('CURL_ERROR '. curl_errno($c) .': '.curl_error($c));
        }

        curl_close($c);
        /* response */
        return $raw_response ? $data : new Response($data);
    }

    private function convertParams()
    {
    	//TODO customize object serialized
        return $this->params;
    }
}
