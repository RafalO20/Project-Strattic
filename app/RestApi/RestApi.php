<?php

namespace WCD;

class RestAPI
{
	public function __construct()
	{
		$instance = $this;
		add_action( 'rest_api_init', [$this, 'enable_rest_endpoints']);
	}

	public function enable_rest_endpoints()
	{
		new \WCD\RestAPI\Sandbox();
		new \WCD\RestAPI\Posts();
		new \WCD\RestAPI\Media();
	}
}
