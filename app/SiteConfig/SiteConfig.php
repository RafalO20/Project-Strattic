<?php

namespace WCD;

class WPSiteConfig extends \Timber\Site
{
  private $_site;
  private $_config;

  function __construct($site, $config)
  {
    $this->_site = $site;
    $this->_config = $config;

    add_filter('timber/twig', array($this, 'add_to_twig'));

    add_action('init', array($this, 'add_theme_supports_for'));

    add_action('after_setup_theme', array($this, 'register_navigations'));

    add_action('after_setup_theme', array($this, 'set_templates_place'));

    add_action('wp_enqueue_scripts', array($this, 'theme_styles'));
    add_action('wp_enqueue_scripts', array($this, 'theme_scripts'), 10, 1);

    add_action('admin_enqueue_scripts', array($this, 'admin_styles'), 10, 1);

    add_filter('timber_context', array($this, 'add_to_context'));

    // Remove WP Emoji
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    // Disable that freaking admin bar
    add_filter('show_admin_bar', '__return_false');

    add_filter('block_categories', array($this, 'register_custom_blocks_categories'), 10, 2);
    add_filter('manage_media_posts_columns', array($this, 'add_media_columns'));
    add_action('manage_media_posts_custom_column', array($this, 'media_custom_column'), 10, 2);

    add_filter('post_link', array($this, 'filter_post_link'), 10, 2);
    add_action('generate_rewrite_rules', array($this, 'blog_generate_rewrite_rules'));

    parent::__construct();
  }

  function add_theme_supports_for()
  {
    add_theme_support('post-formats');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('title-tag');
  }

  function register_navigations()
  {
    register_nav_menus(array(
      'primary' => esc_html__('Primary menu', $GLOBALS['slug']),
      'footer' => esc_html__('Footer menu', $GLOBALS['slug']),
      'burger' => esc_html__('Mobile menu', $GLOBALS['slug']),
    ));
  }

  function add_to_context($context)
  {
    $context['nav'] = array(
      'primary' => new \TimberMenu('primary'),
      'footer' => new \TimberMenu('footer'),
      'burger' => new \TimberMenu('burger'),
    );

    $context['site'] = $this;
    $context['current_user'] = new \TimberUser();

    $context['socialmedia'] = get_field('add_new_social_media', 'option');
    $context['contactinfo'] = get_field('contact_info', 'option');
    $context['newsletterform'] = get_field('form_shortcode', 'option');
    // ACF Support Options page
    if (function_exists('get_fields')) {
      $context['options'] = get_fields('options');
    }

    return $context;
  }

  function add_to_twig($twig)
  {

    $twig->addFunction(new \Timber\Twig_Function('display_read_time', array($this, 'display_read_time')));
    return $twig;
  }

  function theme_styles()
  {
    if (isset($this->_config['embed_css']) && count($this->_config['embed_css'])) {
      foreach ($this->_config['embed_css'] as $handle => $path)
        wp_enqueue_style($handle, get_stylesheet_directory_uri() . $path, [], filemtime(get_stylesheet_directory() . $path), 'all');
    }
  }

  function set_templates_place()
  {
    $site = $this->_site;
    $config = $this->_config;

    $site::$dirname = $config['site']['timber_template_paths'];
  }

  function theme_scripts()
  {
    $this->embed_localized_script();

    if (isset($this->_config['embed_js']) && count($this->_config['embed_js'])) {
      foreach ($this->_config['embed_js'] as $handle => $path)
        wp_enqueue_script('main-scripts', get_template_directory_uri() . $path, array('jquery', 'wp-util'), filemtime(get_stylesheet_directory() . $path), TRUE);
    }
  }

  function embed_localized_script()
  {
    if (!function_exists('get_language_strings') && isset($this->_config['language_strings'])  && count($this->_config['language_strings'])) {
      wp_localize_script(
        "main-scripts",
        "strings",
        $this->_config['language_strings']
      );
    } else if (isset($this->_config['language_strings'])  && count($this->_config['language_strings'])) {
      wp_localize_script(
        "main-scripts",
        "strings",
        get_language_strings()
      );
    }
  }

  function admin_styles()
  {
    if (isset($this->_config['embed_admin_css']) && count($this->_config['embed_admin_css'])) {
      foreach ($this->_config['embed_admin_css'] as $handle => $path) {
        wp_enqueue_style($handle, get_stylesheet_directory_uri() . $path, [], filemtime(get_stylesheet_directory() . $path), 'all');
      }
    }
  }

  static function dump($var)
  {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
  }

  function register_custom_blocks_categories($categories, $post)
  {
    $customBlocksCategories = $this->_config['gutenberg_blocks_categories'];
    return array_merge(
      $categories,
      $customBlocksCategories
    );
  }

  public function display_read_time($postId)
  {
    $content = get_post_field('post_content', $postId);
    $count_words = str_word_count(strip_tags($content));

    $read_time = ceil($count_words / 250);

    $prefix = '<span class="rt-prefix"></span>';

    if ($read_time == 1) {
      $suffix = '<span class="rt-suffix"> min read</span>';
    } else {
      $suffix = '<span class="rt-suffix"> min read</span>';
    }

    $read_time_output = $prefix . $read_time . $suffix;

    return $read_time_output;
  }

  function add_media_columns($columns)
  {
    return array_merge($columns, array(
      'format' => __('Format'),
    ));
  }

  function media_custom_column($column, $post_id)
  {
    switch ($column) {
      case 'format':
        echo get_post_meta($post_id, 'media_format', true);
        break;
    }
  }

  function filter_post_link($post_link, $id = 0)
  {
    $post = get_post($id);
    if (is_object($post) && $post->post_type == 'post') {
      return home_url('/insights/' . $post->post_name);
    }
    return $post_link;
  }

  function blog_generate_rewrite_rules($wp_rewrite)
  {
    $new_rules = array(
      '(.?.+?)/page/?([0-9]{1,})/?$' => 'index.php?pagename=$matches[1]&paged=$matches[2]',
      'insights/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]',
      'insights/[^/]+/attachment/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
      'insights/[^/]+/attachment/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
      'insights/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
      'insights/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
      'insights/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',
      'insights/[^/]+/attachment/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
      'insights/[^/]+/embed/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
      'insights/([^/]+)/embed/?$' => 'index.php?post_type=post&name=$matches[1]&embed=true',
      'insights/[^/]+/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
      'insights/([^/]+)/trackback/?$' => 'index.php?post_type=post&name=$matches[1]&tb=1',
      'insights/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
      'insights/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
      'insights/page/([0-9]{1,})/?$' => 'index.php?post_type=post&paged=$matches[1]',
      'insights/[^/]+/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
      'insights/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
      'insights/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&cpage=$matches[2]',
      'insights/([^/]+)(/[0-9]+)?/?$' => 'index.php?post_type=post&name=$matches[1]&page=$matches[2]',
      'insights/[^/]+/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
      'insights/[^/]+/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
      'insights/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
      'insights/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
      'insights/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
  }
}
