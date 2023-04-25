<?php


namespace WCD\RestAPI;

use WCD\RestAPIItem;
use Timber;

class Media extends RestAPIItem
{
  public function __construct()
  {
    parent::__construct();
    $this->define_rest_endpoints();
  }

  private function define_rest_endpoints()
  {
    $this->register('get', 'media', [$this, 'get_callback']);
  }

  public function get_callback($request_data)
  {
    $params = $request_data->get_params();
    //        return $params;

    $args = array(
      'numberposts' => $params['numberposts'],
      'offset' => $params['offset'],
      'post_type'    => 'media',
      'tax_query' => array(
        array(
          'taxonomy' => 'media_category',
          'field' => 'slug',
          'terms' => $params['cat'],
        )
      )
    );

    $posts = Timber::get_posts($args);

    if ($posts) {
      foreach ($posts as $post) {
        $response = array(
          'data' => Timber::compile('modules/' . $params['template'] . '/' . $params['template'] . '.module.twig', [
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
