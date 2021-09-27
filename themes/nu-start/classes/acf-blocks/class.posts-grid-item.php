<?php
/**
 * 		get the template for a post depending on the content type
 */
// 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class PostsGrid_Item
{


	private static $post;
	private static $fields;
	private static $gridOptions;

	public static function init($post, $gridOptions){

		// convert wp post object into an array to prevent errors
		$post = (array)$post;

		self::$gridOptions = $gridOptions;
		self::$post = $post;
		self::$fields = get_fields($post['ID']);

		$griditems_return = '';

		switch (self::$post['post_type']) {
			case 'nu_people':
				include( get_template_directory( ) . '/classes/acf-blocks/posts-grid-templates/person.php' );
				break;
			case 'nu_events':
				include( get_template_directory( ) . '/classes/acf-blocks/posts-grid-templates/event.php' );
				break;
			case 'nu_programs':
				include( get_template_directory( ) . '/classes/acf-blocks/posts-grid-templates/program.php' );
				break;
			case 'page':
				include( get_template_directory( ) . '/classes/acf-blocks/posts-grid-templates/is-page.php' );
				break;
			default:
				include( get_template_directory( ) . '/classes/acf-blocks/posts-grid-templates/default.php' );
				break;
		}

		return $griditems_return;
	}
	
}

// 
?>