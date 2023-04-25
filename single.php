<?php

use Timber\Post;
use Timber\Timber;

$context = Timber::get_context();
$templates = array('pages/single/single.twig');
$post = new Post();
$context['post'] = $post;

$args = array(
  'post_type' => 'SF_Product',
  'posts_per_page' => 3,
  'post__not_in' => array($post->ID),
);

$context['posts'] = Timber::get_posts($args);

Timber::render($templates, $context);
