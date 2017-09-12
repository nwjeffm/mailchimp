<?php

namespace JeffM\Mailchimp\Methods;

use JeffM\Mailchimp\Abstracts\BaseAbstract;

class Lists extends BaseAbstract {

	/**
	 * 
	 */
	protected $api_key;

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
	public function create($name, $contact = [], $permission_reminder, $campaign_defaults = [], $email_type_option = false)
	{

		$params = ['name' => $name, 'contact' => $contact, 'permission_reminder' => $permission_reminder, 'campaign_defaults' => $campaign_defaults, 'email_type_option' => $email_type_option];

		return $this->sendRequest('POST', 'lists', json_encode($params));

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

	public function delete()
	{
		
	}

}