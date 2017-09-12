<?php

namespace JeffM\Mailchimp\Abstracts;

use Exception;

abstract class BaseAbstract {
	
	/**
	 * Available HTTP verbs:
	 * GET - Make a GET request to retrieve data
	 * POST - Use a POST request to create new resources
	 * PATCH - Make a PATCH request to update a resource
	 * PUT - Use a PUT request to create or update a resource
	 * DELETE - Make a DELETE request to remove a resource
	 */
	private $http_verbs = ['GET', 'POST', 'PATCH', 'PUT', 'DELETE'];

	/**
	 * Mailchimp endpoint
	 */
	private $endpoint = 'https://<dc>.api.mailchimp.com/3.0/';

	/**
	 * API Key
	 */
	protected $api_key;

	/**
	 * Available API responses:
	 * RAW - Straight from Mailchimp
	 * STATUS_CODE - HTTP status code
	 * BOOLEAN - True for success, false for failure
	 * STRING - 'success' and 'failed'
	 */
	private $response = ['RAW', 'STATUS_CODE', 'BOOLEAN', 'STRING'];

	/**
	 * cURL timeout
	 */
	const CURL_DEFAULT_TIMEOUT = 30;

	/**
	 * 
	 */
	public function sendRequest($http_verb, $method, $params)
	{

		$curl = curl_init();

		if( ! in_array($http_verb, $this->http_verbs)) {
			throw new Exception('Invalid HTTP request');
		}

		curl_setopt_array($curl, [
			CURLOPT_URL				=> $this->getEndpoint() .$method,
			CURLOPT_POST			=> true,
			CURLOPT_USERPWD			=> $this->getAuthKey(),
			CURLOPT_TIMEOUT			=> CURL_DEFAULT_TIMEOUT,
			CURLOPT_HTTPHEADER		=> ['Content-Type: application/json'],
			CURLOPT_POSTFIELDS		=> $params,
			CURLOPT_CUSTOMREQUEST 	=> strtoupper($http_verb),
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_SSL_VERIFYPEER	=> false,
		]);


		$result = curl_exec($curl);
		$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		switch ($this->getResponse()) {
			case 'RAW':
				return $result;
			case 'STATUS_CODE':
				return $http_code;
			case 'BOOLEAN':
				return $http_code === 200 ? true : false;
			case 'STRING':
				return $http_code === 200 ? 'success' : 'failed';
		}

	}

	/**
	 *
	 */
	public function setEndpoint($param)
	{

		$this->endpoint = $param;

	}

	/**
	 *
	 */
	public function getEndpoint()
	{

		$data_center = strstr($this->api_key, '-');

		if($data_center === false) {
			throw new Exception('Invalid API key');
		}

		return str_replace('<dc>', str_replace('-', '', $data_center), $this->endpoint);

	}

	/**
	 *
	 */
	public function setAuthKey($params)
	{

		$this->api_key = $params;

	}

	/**
	 *
	 */
	public function getAuthKey($username = 'jeffreymabazza')
	{

		return $username. ':' .$this->api_key;

	}

	/**
	 * 
	 */
	public function setResponse($value)
	{

		if( ! in_array(strtoupper($value), $this->response)) {
			throw new Exception('Response value not found. Available: RAW, STATUS_CODE, BOOLEAN, STRING');
		}

		$this->response = strtoupper($value);
		
		return $this;

	}

	/**
	 * 
	 */
	public function getResponse()
	{

		return $this->response;

	}

}