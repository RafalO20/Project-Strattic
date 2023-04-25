<?php

$config['embed_css'] = [
  'main-styles' => '/static/css/app.bundle.css',
  'main-styles' => '/static/css/app.bundle.css'
];

$config['embed_admin_css'] = [
  'admin-main-styles' => '/static/css/admin.bundle.css'
];

function add_rel_preload($html, $handle, $href, $media)
{

  if (is_admin())
    return $html;

  $html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
<link rel='stylesheet' href='$href' type='text/css' media='all' />

EOT;
  return $html;
}
add_filter('style_loader_tag', 'add_rel_preload', 10, 4);

function hook_css()
{
?>
	<?php
}
add_action('wp_head', 'hook_css');
