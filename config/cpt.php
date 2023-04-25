<?php

$config['cpt'] = [
];

add_filter('post_type_link', 'my_custom_permalinks', 10, 2);
function my_custom_permalinks($permalink, $post)
{
  if (is_object($post) && $post->post_type == 'media') {
    $permalink = str_replace(
      array(
        '%taxonomy%'
      ),
      array(
        get_the_terms($post->ID, 'media_category')[0]->slug,
      ),
      $permalink
    );
  }
  return $permalink;
}

add_action('generate_rewrite_rules', 'media_rewrite_rules');

function media_rewrite_rules($wp_rewrite)
{
  $new_rules = array(
    'media/([^/]+)/([^/]+)/?$' => 'index.php?post_type=media&name=$matches[2]',

  );
  $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
