<?php
namespace WEPHONE\SDK;

/**
 * Call Router client
 * @author Kien Ngo <kien.ngo@wephone.io>
 *
 */

class Client
{
    const API_URL = 'http://wephone-kngo.localnet.dev/ws/apikey/call_function';
    const SDK_VERSION = '1.0';
    
	private $apiKey;
    /** @var string API URL */
    private $url;
    /** @var string[] HTTP Headers */
    private $headers = [];
    /** @var string proxy */
    private $proxy = null;
    
	function __construct() {
	}
    
    /**
     * Set custom HTTP headers.
     * @param array $headers {
     *     @var  string $key HTTP header key
     *     @var  string $value HTTP header value
     * }
     */
    public function setCustomHeaders(array $headers)
    {
        foreach ($headers as $k => &$v) {
            if (strpos($v, ':') === false) {
                $v = $k.': '.$v;
            }
        }
        $this->headers = $headers;
    }

    /**
     * Set HTTP proxy
     * @param string $proxy (http://proxy.url:port)
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }
    
	/**
	 * Route the call to a number
	 *
	 * @param string $number: The phone number to be called
	 * @param integer $timeout: The delay (in seconds) that we expect the number to answer. Otherwise, the call is consider failed
	 */
	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
	}

	/**
     * @param string $method JSON-RPC method
     * @param mixed[] $params JSON-RPC parameters
     * @return mixed API response
     * @throws \WEPHONE\SDK\API\Exception\LocalException
     * @throws \WEPHONE\SDK\API\Exception\RemoteException
     */
    public function call($method, array $params = [], $id = null)
    {
        if (!is_string($method)) {
            throw new Exception\LocalException('METHOD_TYPE_ERROR');
        }

        if ($id === null) {
            $id = (int) mt_rand(1, 1024);
        } elseif (!is_int($id)) {
            throw new Exception\LocalException('ID_TYPE_ERROR');
        }

        if (!$this->apiKey) {
            throw new Exception\LocalException('API_KEY_ERROR');
        }
        
        $request = new Request;
        $request->id = $id;
        $request->method = $method;
        $request->params = $params;

        //$request->params['apikey'] = $this->apiKey; //update apikey in requested params

        $url = $this->url ? $this->url : self::API_URL;
        $url .= ( strpos('?', $url) !== false ? '&' : '?' ) . 'apikey=' . $this->apiKey; //update apikey in requested params
        
        $response = $request->send(
            $url,
            null,
            $this->headers,
            $this->proxy
        );
        
        if ($response->isError()) {
            throw $response->error;
        }

        return $response->result;
    }

}
