<?php
abstract class SF_abstract_post{
	public static $slug = 'post';
	public function __construct() {
		add_action('init',array($this,'init'));
		$this->actionHooks();
	}
	public function init(){
		if(is_admin())
		add_filter( 'rwmb_meta_boxes', array($this,'createMeta') );
		$this->createPost();
	}

	public function actionHooks(){

	}

	public function createPost(){

	}

	public function createMeta($meta_boxes){
		$prefix = 'sf_';
		return $meta_boxes;
	}

	/**
	 * @return array
	 */
	public static function getAll(){
		return get_posts(array(
			'post_type' => static::$slug,
			'nopaging' => true,
			'orderby' => 'menu_order',
			'order' => 'DESC',
		));
	}


	/**
	 * @param $field
	 * @param $value
	 *
	 * @return array
	 */
	public static function getSpecific($field,$value){

		$args = array(
			'post_type' => static::$slug,
			'nopaging' => true,
			'orderby' => 'menu_order',
			'order' => 'DESC',
			'meta_query'=> array(
				'relation' => 'AND',
				array(
					'key'     => $field,
					'value'   => $value,
					'compare' => '='
				)
			),
		);
		return get_posts($args);
	}

	public static function getNotEmpty($field){

		$args = array(
			'post_type' => static::$slug,
			'nopaging' => true,
			'orderby' => 'menu_order',
			'order' => 'DESC',
			'meta_query'=> array(
				'relation' => 'AND',
				array(
					'key'     => $field,
					'value'   => '',
					'compare' => '!='
				)
			),
		);
		return get_posts($args);
	}

}