<?php
function acf_filter_rest_api_preload_paths( $preload_paths ) {
  if ( ! get_the_ID() ) {
    return $preload_paths;
  }
  $remove_path = '/wp/v2/' . get_post_type() . 's/' . get_the_ID() . '?context=edit';
  $v1 =  array_filter(
    $preload_paths,
    function( $url ) use ( $remove_path ) {
      return $url !== $remove_path;
    }
  );
  $remove_path = '/wp/v2/' . get_post_type() . 's/' . get_the_ID() . '/autosaves?context=edit';
  return array_filter(
    $v1,
    function( $url ) use ( $remove_path ) {
      return $url !== $remove_path;
    }
  );
}
add_filter( 'block_editor_rest_api_preload_paths', 'acf_filter_rest_api_preload_paths', 10, 1 );

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  add_action('admin_notices', function () {
    echo '<div class="error"><p>Timber not installed. Make sure you run a composer install in the theme directory</p></div>';
  });
  return;
  exit;
} else {
  require_once(__DIR__ . '/vendor/autoload.php');
}

$loader = new Nette\Loaders\RobotLoader;

$directories = glob(get_stylesheet_directory() . '/app/*', GLOB_ONLYDIR);
foreach ($directories as $directory)
  $loader->addDirectory($directory);

$loader->setTempDirectory(get_stylesheet_directory() . '/app/temp');
$loader->register(); // Run the RobotLoader

global $slug;
$slug = 'pas';

$config = [];

require_once(__DIR__ . "/config/config.php");
require_once(__DIR__ . "/app/app.php");
require_once("post-types/SF_post.php");
require_once("post-types/SF_products.php");


ini_set('upload_max_size', '64M');
ini_set('post_max_size', '64M');
ini_set('max_execution_time', '300');

add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
  remove_menu_page( 'edit-comments.php' );
  remove_menu_page( 'edit.php' );
}


function reg_tag() {
  register_taxonomy_for_object_type('post_tag', 'products');
}
add_action('init', 'reg_tag');


if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
      'page_title' 	=> 'Title Button Global Settings',
      'menu_title'	=> 'Title Button Global Settings',
      'menu_slug' 	=> 'title_button_global_settings',
      'capability'	=> 'edit_posts',
  ));

  acf_add_options_page(array(
    'page_title' 	=> 'Social media',
    'menu_title'	=> 'Social media',
    'menu_slug' 	=> 'social_media',
    'capability'	=> 'edit_posts',
    'icon_url' => 'dashicons-share',
));
  acf_add_options_page(array(
    'page_title' 	=> 'Settings contact',
    'menu_title'	=> 'Settings contact',
    'menu_slug' 	=> 'Settings_contact',
    'capability'	=> 'edit_posts',
    'icon_url' => 'dashicons-phone',
  ));
  acf_add_options_page(array(
    'page_title' 	=> 'Newsletter Form',
    'menu_title'	=> 'Newsletter Form',
    'menu_slug' 	=> 'Newsletter_Form',
    'capability'	=> 'edit_posts',
    'icon_url' => 'dashicons-format-aside',
  ));
}

function wpex_add_menu_home_link( $items, $args ) {

	if ( 'main' != $args->theme_location ) {
		return $items;
	}
	$home_link = '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
	$items = $home_link . $items;
	return $items;

}
add_filter( 'wp_nav_menu_items', 'wpex_add_menu_home_link', 10, 2 );
