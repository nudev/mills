<?php

namespace ProDevign\BlockMeister;

class Utils {
	public static function camel2dashed( $word ) {
		return strtolower( preg_replace( '/([A-Z])/', '-$1', $word ) );
	}

	/**
	 * Register a custom post type
	 *
	 * @param $post_type_name
	 * @param $labels
	 * @param $icon
	 * @param bool $free_license
	 *
	 * @return \WP_Error|\WP_Post_Type
	 */
	public static function register_post_type( $post_type_name, $labels, $icon, $free_license = false
	) {
		$show_ui = true;
		$args    = array(
			'labels'              => $labels,
			'supports'            => [
				'title',   // required, else our custom block name won't be available in REST
				'editor',
				'excerpt', // required, else our custom block description won't be available in REST
				//'revisions',
				'author',
				'custom-fields',
			],
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => $show_ui,
			'menu_position'       => 80,
			'menu_icon'           => $icon,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => array( $post_type_name, $post_type_name . 's' ),
			'map_meta_cap'        => true,
			'show_in_rest'        => true,
		);

		return register_post_type( $post_type_name, $args );
	}

}