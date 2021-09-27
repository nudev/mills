<?php

namespace ProDevign\BlockMeister\Pattern_Builder;

use ProDevign\BlockMeister\Debug;
use ProDevign\BlockMeister\Pattern_Builder\Admin\BlockMeister_Pattern_List_Table;
use ProDevign\BlockMeister\Pattern_Builder\Admin\Custom_Block_Pattern_Registry;
use ProDevign\BlockMeister\Screen;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


final class Pattern_Builder {

	/**
	 * @var Pattern_Builder
	 */
	private static $instance = null;

	/**
	 * Constructor for the Pattern_Builder class
	 */
	private function __construct() {
	}

	/**
	 * @return Pattern_Builder
	 */
	public static function get_instance() {
		return Pattern_Builder::$instance;
	}

	/**
	 * Runs (and initializes) Pattern_Builder
	 *
	 * @return void
	 */
	public static function init() {

		if ( is_null( Pattern_Builder::$instance ) ) {

			$pattern_builder = Pattern_Builder::$instance = new Pattern_Builder();

			// Init context specific classes, based on request type
			if ( is_admin() ) {
				$pattern_builder->init_admin();
			} elseif ( defined( 'DOING_AJAX' ) ) {
				$pattern_builder->init_ajax();
			} elseif ( defined( 'REST_REQUEST' ) ) {
				$pattern_builder->init_rest();
			} else {
				$pattern_builder->init_frontend();
			}

		}
	}

	private function init_frontend() {
		( new BlockMeister_Pattern_Post_Type() )->init();
		( new BlockMeister_Pattern_Post_Meta_Fields() )->init();
		( new BlockMeister_Pattern_Category_Taxonomy() )->init();
		( new BlockMeister_Pattern_Keywords_Taxonomy() )->init();
	}

	private function init_admin() {
		( new Assets() )->init();
		( new BlockMeister_Pattern_Post_Type() )->init();
		( new BlockMeister_Pattern_Category_Taxonomy() )->init();
		( new BlockMeister_Pattern_Keywords_Taxonomy() )->init();
		( new BlockMeister_Pattern_Post_Meta_Fields() )->init();
		( new Custom_Block_Pattern_Registry() )->init();
		( new BlockMeister_Pattern_List_Table() )->init();
		( new Admin\BlockMeister_Pattern_Editor() )->init();
	}

	private function init_ajax() {

	}

	private function init_rest() {
		( new BlockMeister_Pattern_Post_Type() )->init();
		( new BlockMeister_Pattern_Category_Taxonomy() )->init();
		( new BlockMeister_Pattern_Keywords_Taxonomy() )->init();
		( new BlockMeister_Pattern_Post_Meta_Fields() )->init();
	}




} // Pattern_Builder




