<?php
namespace GRAAM\SDK;

/**
 * Call Router SystemClient
 * @author Thong Vo <thongvv@vietpointer.vn>
 *
 */

class SystemClient
{
    const API_URL = '/ws/sys/call_function';
    const SDK_VERSION = '1.0';
    
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
	public function init($apiKey, $domain='graam-tvo.localnet.dev', $ssl=true) {
		$url = ($ssl ? 'https' : 'http') . '://' . $domain . self::API_URL;
		$url .= ( strpos('?', $url) !== false ? '&' : '?' ) . 'apikey=' . $apiKey;
		$this->url = $url;
	}

	/**
     * @param string $method JSON-RPC method
     * @param mixed[] $params JSON-RPC parameters
     * @return mixed API response
     * @throws \GRAAM\SDK\API\Exception\LocalException
     * @throws \GRAAM\SDK\API\Exception\RemoteException
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

        if (!$this->url) {
            throw new Exception\LocalException('API_KEY_ERROR');
        }
        
        $request = new Request;
        $request->id = $id;
        $request->method = $method;
        $request->params = $params;
        
        $response = $request->send(
            $this->url,
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
