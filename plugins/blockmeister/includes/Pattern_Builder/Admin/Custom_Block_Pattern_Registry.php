<?php

namespace ProDevign\BlockMeister\Pattern_Builder\Admin;


class Custom_Block_Pattern_Registry {

	const POST_TYPE = "blockmeister_pattern";

	/**
	 * @var string
	 */
	private $custom_namespace;

	/**
	 * Post_Editor constructor.
	 *
	 */
	public function __construct() {}


	/**
	 * Initialize if applicable, i.e.:
	 *  - block editor enabled for current post type
	 */
	public function init() {

		add_action( 'init', function () {
			$this->register_custom_default_category_and_namespace();
			$this->register_custom_block_patterns();
		}, 1020 ); // needs to run after BlockMeister_Pattern_Category_Taxonomy->init()

	}

	/**
	 * The site name will act as the default category
	 * This overrides the core default of 'uncategorized'
	 */
	private function register_custom_default_category_and_namespace() {
		$site_name              = get_bloginfo( 'name', 'display' ); // note: ia escaped by WP
		$site_slug              = sanitize_title( $site_name ); // convert name to a valid slug
		$this->custom_namespace = $site_slug;
		register_block_pattern_category( $site_slug, [ 'label' => $site_name ] );
	}

	/**
	 * Server side custom pattern registration.
	 *
	 * Security notes:
	 * - Escaping:      None of the registration args will be directly output to the screen.
	 *                  Therefore escaping isn't necessary at this point and will be done by WP when
	 *                  the patterns are rendered for preview or as rendered in a post/page.
	 * - Sanitization:  The registration args are sanitized to prevent unexpected results though.
	 */
	private function register_custom_block_patterns() {

		$current_post_id = (int) isset($_GET['post']) ? $_GET['post'] : -1 ;

		$blockmeister_pattern_posts = get_posts( [
			'numberposts' => - 1, // get all
			'post_type'   => self::POST_TYPE,
			'post_status' => 'publish',
		] );

		foreach ( $blockmeister_pattern_posts as $block_pattern ) {

			if ( $block_pattern->ID === $current_post_id ) {
				continue; // skip currently being edited pattern to prevent self nesting
			}

			$category_slugs     = wp_get_post_terms( $block_pattern->ID, 'pattern_category', [ 'fields' => 'id=>slug' ] );
			$pattern_categories = sizeof( $category_slugs ) > 0 ? explode( ",", implode( ",", $category_slugs ) ) : []; // explode/implode re-indexes array

			$keyword_slugs    = wp_get_post_terms( $block_pattern->ID, 'pattern_keyword', [ 'fields' => 'id=>slug' ] );
			$pattern_keywords = sizeof( $keyword_slugs ) > 0 ? explode( ",", implode( ",", $keyword_slugs ) ) : []; // explode/implode re-indexes array

			$filtered_post_content = wp_kses_post( $block_pattern->post_content );
			if ( $filtered_post_content !== $block_pattern->post_content ) { // some content was stripped out by kses method
				if ( current_user_can( 'unfiltered_html' ) ) {
					$filtered_post_content = $block_pattern->post_content; // potential unsafe content is the responsibility of use
				}
			}

			$pattern_props = [
				'title'         => strip_tags( $block_pattern->post_title ),
				'description'   => strip_tags( $block_pattern->post_excerpt ),
				'content'       => $filtered_post_content,
				'categories'    => array_map( 'strip_tags', $pattern_categories ),
				'keywords'      => array_map( 'strip_tags', $pattern_keywords ),
				'viewportWidth' => (int) get_post_meta( $block_pattern->ID, "_bm_viewport_width", true ),
			];

			$block_namespace    = sanitize_key( $this->custom_namespace );
			$block_pattern_name = sanitize_key( $block_pattern->post_name );
			register_block_pattern( "{$block_namespace}/{$block_pattern_name}", $pattern_props );
		}

	}


}
