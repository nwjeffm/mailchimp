<?php

namespace JeffM\Mailchimp\Methods;

use JeffM\Mailchimp\Abstracts\BaseAbstract;

class Campaigns extends BaseAbstract {

	/**
	 * 
	 */
	protected $api_key;

	/**
	 * 
	 */
	private $types = ['regular', 'plaintext', 'rss', 'variate'];

	/**
	 * 
	 */
	public function __construct($api_key)
	{

		$this->api_key = $api_key;

	}

	/**
	 * 
	 */
	public function create($type, $options = [], $content = [], $segment_opts = [], $type_opts = [])
	{

		$params = ['type' => $type, 'options' => $options, 'content' => $content, 'segment_opts' => $segment_opts, 'type_opts' => $type_opts];

		// echo '<pre>';var_dump($params);exit;
		return $this->sendRequest('POST', 'campaigns', $params);

	}

	/**
	 * 
	 */
	public function read()
	{

	}

	/**
	 * 
	 */
	public function edit()
	{

	}

	/**
	 * 
	 */
	public function delete()
	{

	}

}