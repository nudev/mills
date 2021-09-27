<?php
/* 

*/

// add/remove block categories
add_filter( 'block_categories_all', 'nu__manage_block_categories', 10, 2 );

// restrict allowed blocks for certain post types
add_filter('allowed_block_types_all', 'nu__manage_allowed_blocks', 10, 2);

// register additional block styles
add_action( 'init', 'nu__register_block_styles' );

// register categories for patterns
add_action( 'init', 'nu__register_block_pattern_categories');

// add reusable blocks to the main menu
add_action( 'admin_menu', 'nu__reusable_blocks_in_admin_menu' );

// ? really big hammer for adjusting blocks w/o recovery error in cms
// add_filter( 'render_block', 'nu__customize_rendering_blocks', 10, 2 );


function nu__customize_rendering_blocks( $block_content, $block ) {

    if ( $block['blockName'] === 'core/columns' ) {


		error_log(print_r($block, true));
		
    }


    return $block_content;
}

if( !function_exists( 'nu__register_block_types' ) ){
	function nu__manage_allowed_blocks($allowed_block_types, $block_editor_context) {


		if( isset($block_editor_context->post->ID) && $block_editor_context->post->post_type === "nu_faces" ){

			$allowed_block_types = [
				'core/block',
				'core/cover',
				'core/buttons',
				'core/button',
				'core/columns',
				'core/column',
				'core/paragraph',
				'core/heading',
				'core/image',
				'acf/breadcrumbs',
			];

		}

		

		return $allowed_block_types;
		
	}
}







if( !function_exists( 'nu__register_block_styles' ) ){
	function nu__register_block_styles(){

		register_block_style(
			'eedee/block-gutenslider',
			array(
				'name'         => 'alternate',
				'label'        => __( 'Alternate', 'nu-start' ),
			)
		);



		register_block_style(
			'ep/tabs',
			array(
				'name'         => 'underlined',
				'label'        => __( 'Underlined', 'nu-start' ),
			)
		);
		register_block_style(
			'ep/tabs',
			array(
				'name'         => 'floating',
				'label'        => __( 'Floating', 'nu-start' ),
			)
		);
		register_block_style(
			'ep/tabs',
			array(
				'name'         	=> 'bordered',
				'label'        	=> __( 'Bordered', 'nu-start' ),
				'is_default'	=> true
			)
		);


		register_block_style(
			'core/paragraph',
			array(
				'name'         => 'links-have-arrows',
				'label'        => __( 'Links have arrows', 'nu-start' ),
			)
		);

		register_block_style(
			'core/post-title',
			array(
				'name'         => 'display',
				'label'        => __( 'Display', 'nu-start' ),
			)
		);

		register_block_style(
			'core/heading',
			array(
				'name'         => 'display',
				'label'        => __( 'Display', 'nu-start' ),
			)
		);

		register_block_style(
			'core/button',
			array(
				'name'         => 'card',
				'label'        => __( 'Card', 'nu-start' ),
			)
		);

		register_block_style(
			'core/button',
			array(
				'name'         => 'playhead',
				'label'        => __( 'Playhead', 'nu-start' ),
			)
		);

		// 
		register_block_style(
			'core/group',
			array(
				'name'         => 'card-outlined',
				'label'        => __( 'Outlined Card', 'nu-start' ),
			)
		);

		// register_block_style(
		// 	'core/group',
		// 	array(
		// 		'name'         => 'card-floating',
		// 		'label'        => __( 'Floating Card', 'nu-start' ),
		// 	)
		// );


	}
}





if( !function_exists('nu__manage_block_categories') ){
	
	/**
	 * add / remove block editor categories
	 *
	 * @param [type] $block_categories
	 * @param [type] $block_editor_context
	 * @return void
	 */
	function nu__manage_block_categories( $block_categories, $block_editor_context  ) {
	
		// create the nu-blocks category
		return array_merge(
			$block_categories,
			array(
				array(
					'slug' => 'nu-blocks',
					'title' => __( 'NU Blocks', 'nu-start' ),
					'icon'  => 'f131',
				),
				array(
					'slug' => 'nublocks',
					'title' => __( 'NU Blocks Plugin', 'nublocks' ),
					'icon'  => 'f131',
				),
			)
		);
	}
	
}



if( !function_exists('nu__register_block_pattern_categories') ){

	/**
	 * register custom categories for patterns
	 *
	 * @return void
	 */	
	function nu__register_block_pattern_categories(){
		
		$nu_pattern_categories = [
			// 
			'dev-helpers' => ['label' => __('Dev Helpers', 'nu-start')],
			// 
			'heros' => ['label' => __('Heros', 'nu-start')],
			'partners' => ['label' => __('Partners', 'nu-start')],
			'featured-people' => ['label' => __('Featured People', 'nu-start')],
			'featured-items' => ['label' => __('Features', 'nu-start')],
			'stat-highlights' => ['label' => __('Stat Highlights', 'nu-start')],
			'case-studies' => ['label' => __('Case Studies', 'nu-start')],
			'testimonials' => ['label' => __('Testimonials', 'nu-start')],
			// 
			'event-templates' => ['label' => __('Event Templates', 'nu-start')],
			'person-templates' => ['label' => __('Person Templates', 'nu-start')],
		];

		foreach( $nu_pattern_categories as $category_name => $category_properties ) {
			register_block_pattern_category( $category_name, $category_properties );
		}
		
	}
}



/**
 * 		this function is registered as the enqueue_assets callback for the carousel block
 */
if( !function_exists('nu__enqueueCarouselAssets') ){
	function nu__enqueueCarouselAssets(){
		wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/acf-blocks/carousel/lib/slick-theme-min.css' );
		wp_enqueue_style( 'slick', get_template_directory_uri() . '/acf-blocks/carousel/lib/slick.css' );
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/acf-blocks/carousel/lib/slick.js', array('jquery'), '', true );
		wp_enqueue_script( 'carousel-editor', get_template_directory_uri() . '/acf-blocks/carousel/carousel-editor-min.js', array('jquery'), '', true );
	}
}

/**
 *
 *		Add the "Manage Reusable Blocks" page to the main menu
 *
 */
if( !function_exists('nu__reusable_blocks_in_admin_menu') ){
	function nu__reusable_blocks_in_admin_menu() {
	
		add_menu_page(
			'Reusable Blocks',
			'Reusable Blocks',
			'manage_options',
			'edit.php?post_type=wp_block',
			'',
			'dashicons-editor-table',
			'3.1'
		);
	
	}
}



// 
?>