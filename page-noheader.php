<?php

/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Template Name: Page - No Header
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.1
 */

use Timber\Post;
use Timber\Timber;

$context = Timber::get_context();
$templates = array('pages/page-noheader/page-noheader.twig');
$post = new Post();
$context['post'] = $post;
Timber::render($templates, $context);
