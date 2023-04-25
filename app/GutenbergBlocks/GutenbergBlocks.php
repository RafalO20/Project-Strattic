<?php

namespace WCD;

class GutenbergBlocks
{
  private $_blocks_enabled;
  private $_blocks_path;

  public function __construct($blocksConfig)
  {
    $this->_blocks_enabled = $blocksConfig['blocks'];
    $this->_blocks_path = $blocksConfig['path'];

    add_action('acf/init', [$this, 'register_blocks']);
  }

  public function register_blocks()
  {
    if (function_exists('acf_register_block')) {
      foreach ($this->_blocks_enabled as $blockSlug => $blockData) {
        require_once $this->_blocks_path . '/' . $blockSlug . '/' . $blockSlug . '.block.render.php';
        if (function_exists('acf_block_render_callback_' . $blockSlug))
          $blockCallback = 'acf_block_render_callback_' . $blockSlug;
        else
          $blockCallback = [$this, 'render_block'];


        $this->_register_block($blockSlug, $blockData, $blockCallback);


        $acfService = new AcfService();
        $acfService->register_json_load_dir($this->_blocks_path . '/' . $blockSlug . '/json');
      }
    }
  }

  private function _register_block(string $blocksSlug, array $blockData, $blockCallback)
  {
    if (isset($blockData['name']))
      $blockName = $blockData['name'];
    else
      $blockName = str_replace('_', ' ', ucfirst($blocksSlug));

    acf_register_block(array(
      'name'        => $blocksSlug,
      'title'        => $blockName,
      'description'    => isset($blockData['description']) ? $blockData['description'] : sprintf(__('%s description.'), $blockName),
      'render_callback'  => $blockCallback,
      'category'      => isset($blockData['category']) ? $blockData['category'] : 'formatting',
      'icon'        => isset($blockData['icon']) ? $blockData['icon'] : 'admin-comments',
      'keywords'      => isset($blockData['keywords']) ? $blockData['keywords'] : [],
      'mode' => isset($blockData['mode']) ? $blockData['mode'] : 'edit',
      //            'supports'          => array( 'mode' => false )
    ));
  }

  public function render_block($block)
  {
    $slug = str_replace('acf/', '', $block['name']);
    $context = Timber::get_context();
    $context['block'] = $block;
    $context['fields'] = get_fields();

    Timber::render($this->_blocks_path = '/' . $slug . '/' . $slug . '.block.twig', $context);
  }
}
