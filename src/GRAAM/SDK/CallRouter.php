<?php
namespace GRAAM\SDK;

/**
 * Call Router client
 * @author David PHAN <david.phan@graam.io>
 *
 */

class CallRouter
{
	protected $routingData;

	function __construct() {
		$this->routingData = Array();
	}

	/**
	 * Route the call to a number
	 *
	 * @param string $number: The phone number to be called
	 * @param integer $timeout: The delay (in seconds) that we expect the number to answer. Otherwise, the call is consider failed
	 */
	public function toNumber($number, $timeout) {
		$target = new \stdClass;
		$target->application = "call_phone_number";
		$target->params = Array("number" => $number, "timeout" => $timeout);
		$this->routingData[] = $target;
	}

	/**
	 * Route the call to a SIP Phone
	 *
	 * @param string $number: The SIP phone extension to be called
	 */
	public function toSIPPhone($number, $timeout) {
		$target = new \stdClass;
		$target->application = "call_phone";
		$target->params = Array("extension" => $number, "timeout" => $timeout);
		$this->routingData[] = $target;
	}

	/**
	 * Route the call to a call queue
	 *
	 * @param string $queue_id: The ID or Alias of the call queue
	 */
	public function toQueue($queue_id) {
		$target = new \stdClass;
		$target->application = "callqueue";
		$target->params = Array("queue_id" => $queue_id);
		$this->routingData[] = $target;
	}

	public function getResponse() {
		return json_encode($this->routingData);
	}
}
