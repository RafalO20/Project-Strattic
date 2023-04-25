<?php

namespace WCD;

class Acf
{
	function __construct()
	{
		if( class_exists('ACF') ) {
			$this->__config();
			$this->__options();
		}
	}

	private function __config()
	{

		if( function_exists('acf_add_options_page') ) {

			// define json save dir
			add_filter('acf/settings/save_json', function(  ) {
				return get_stylesheet_directory() . '/app/acf/json';
			});

			// add json load dir
			$acfService = new AcfService();
			$acfService->register_json_load_dir('/app/Acf/json');
		}
	}

	private function __options()
	{

		if ( function_exists( 'acf_add_options_page' ) ) {
			$options = acf_add_options_page(array(
				'page_title' 	=> 'Options theme',
				'menu_title'	=> 'Options theme',
				'menu_slug' 	=> 'theme-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> true
			));
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Brand',
				'menu_title' 	=> 'Brand',
				'menu_slug' 	=> 'menu_brand',
				'parent_slug' 	=> $options['menu_slug'],
			));
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Social Settings',
				'menu_title' 	=> 'Social',
				'menu_slug' 	=> 'menu_socials',
				'parent_slug' 	=> $options['menu_slug'],
			));
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Global contents',
				'menu_title' 	=> 'Global contents',
				'menu_slug' 	=> 'menu_contents',
				'parent_slug' 	=> $options['menu_slug'],
			));
			acf_add_options_sub_page(array(
				'page_title' 	=> 'External scripts',
				'menu_title' 	=> 'External scripts',
				'menu_slug' 	=> 'menu_external',
				'parent_slug' 	=> $options['menu_slug'],
			));
		}
	}


	public function register_json_load_dir($pathToAdd)
	{
		add_filter('acf/settings/load_json', function($path) use ($pathToAdd)
		{
			$path []= get_stylesheet_directory() . $pathToAdd;
			return $path;
		});
	}
}
