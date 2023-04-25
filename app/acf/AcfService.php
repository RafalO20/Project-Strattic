<?php

namespace WCD;

class AcfService
{
	public function register_json_load_dir($pathToAdd)
	{
		add_filter('acf/settings/load_json', function($path) use ($pathToAdd)
		{
			if(!substr_count($pathToAdd, get_stylesheet_directory()))
				$path []= get_stylesheet_directory() . $pathToAdd;
			else
				$path []= $pathToAdd;

			return $path;
		});
	}
}
