<?php

namespace WCD;

class RestAPIItem
{
  public $namespace = '';
  public $version = 1;

  public function __construct()
  {
    global $GLOBALS;
    $this->namespace = $GLOBALS['slug'];
  }

  public function register($method, $route, $callback)
  {
    $posts_per_page = (get_option('posts_per_page')) ? get_option('posts_per_page') : 10;
    register_rest_route($this->namespace . '/v' . $this->version, $route, [
      'methods' => is_array($method) ? $method : strtoupper($method),
      'callback' => $callback,
      'posts_per_page'   => $posts_per_page,
    ]);
  }
}
