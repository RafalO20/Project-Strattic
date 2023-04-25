<?php


namespace WCD\RestAPI;

use WCD\RestAPIItem;
use Timber;

class Posts extends RestAPIItem
{
  public function __construct()
  {
    parent::__construct();
    $this->define_rest_endpoints();
  }

  private function define_rest_endpoints()
  {
    $this->register('get', 'posts', [$this, 'get_callback']);
  }

  public function get_callback()
  {
    $args = array(
      'post_type' => 'post',
      'numberposts' => 10000,
      'offset' => 9,
    );

    $tpl = 'modules/PostCard/PostCard.module.twig';

    if (isset($_GET['post_type']) && $_GET['post_type'])
      $args['post_type'] = $_GET['post_type'];

    if (isset($_GET['offset']) && $_GET['offset'])
      $args['offset'] = $_GET['offset'];

    if (isset($_GET['numberposts']) && $_GET['numberposts'])
      $args['numberposts'] = $_GET['numberposts'];

    $posts = Timber::get_posts($args);

    if ($posts) {
      foreach ($posts as $post) {
        $response = array(
          'data' => Timber::compile('modules/PostCard/PostCard.module.twig', [
            'post' => $post
          ])
        );
        $message[] = $response;
      }
    } else {
      $message = "no posts";
    }

    return $message;
  }
}
