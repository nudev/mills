<?php

namespace ProDevign\BlockMeister\Pattern_Builder\Admin;


class BlockMeister_Pattern_List_Table {

	/**
	 * Post_Editor constructor.
	 *
	 */
	public function __construct() {}


	public function init() {
		add_filter( 'manage_blockmeister_pattern_posts_columns', [ $this, 'reorder_columns_filter' ] );
	}

	/**
	 * By default WordPress will place the Categories column after the Author column.
	 * With this filter we reverse that.
	 *
	 * @param $columns
	 *
	 * @return array The reordered columns
	 */
	public function reorder_columns_filter( $columns ) {
		$columns_ordered = [];
		foreach ( $columns as $key => $title ) {
			if ( $key == 'author' ) { // Put the Categories column before the Author column
				$columns_ordered['taxonomy-pattern_category'] = esc_html__( 'Categories', 'blockmeister' );
				$columns_ordered['taxonomy-pattern_keyword']  = esc_html__( 'Keywords', 'blockmeister' );
			}
			$columns_ordered[ $key ] = $title;
		}

		return $columns_ordered;
	}


}
