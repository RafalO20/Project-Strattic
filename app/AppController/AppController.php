<?php

namespace WCD;

class AppController
{
  function __construct($site, $config)
  {

    new RestAPI();
    new WPSiteConfig($site, $config);

    if (is_array($config['cpt']) && count($config['cpt']))
      new PostTypes($config['cpt']);

    new Acf();

    if (isset($config['gutenberg_blocks']) && count($config['gutenberg_blocks']))
      new GutenbergBlocks($config['gutenberg_blocks']);
  }
}
