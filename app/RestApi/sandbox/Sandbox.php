<?php


namespace WCD\RestAPI;

use WCD\RestAPIItem;

class Sandbox extends RestAPIItem
{
  public function __construct()
  {
    parent::__construct();
    $this->define_rest_endpoints();
  }

  private function define_rest_endpoints()
  {
    $this->register('get', 'sandbox', [$this, 'get_callback']);
  }

  public function get_callback()
  {
    return 'hello';
  }
}
