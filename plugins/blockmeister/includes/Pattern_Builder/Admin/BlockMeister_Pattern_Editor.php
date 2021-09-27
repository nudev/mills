<?php


namespace ProDevign\BlockMeister\Pattern_Builder\Admin;


use ProDevign\BlockMeister\Screen;

class BlockMeister_Pattern_Editor {


	public function __construct() {
	}


	public function init() {

		//add_filter( 'write_your_story', [ $this, 'filter_block_editor_placeholder' ], 10, 2 );
		add_filter( 'enter_title_here', [ $this, 'filter_enter_title_here' ], 10, 2 );

	}

	public function filter_block_editor_placeholder( $text, $post ) {
		//Original: Start writing or type / to choose a block
		if ( Screen::is_blockmeister_pattern_block_editor() ) {
			$text = esc_html__( 'Start writing or type / to choose a block to add to your block pattern', 'blockmeister' );
		}

		return $text;
	}

	public function filter_enter_title_here( $text, $post ) {
		//Original: Add title
		if ( Screen::is_blockmeister_pattern_block_editor() ) {
			$text = esc_html__( 'Enter pattern name', 'blockmeister' );
		}

		return $text;
	}

}

