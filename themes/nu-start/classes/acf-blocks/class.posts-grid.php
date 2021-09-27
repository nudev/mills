<?php 
/**
 * 
 */
// 


class PostsGrid
{

	// assemble core block properties
	private $block, $post_id, $fields;

	// internal methods will hoist data to these properties to avoid repetitive calls
	private $wp_query, $wp_query_args, $httpAPI;

	// store various return strings or null values to handle these optional components
	private $grid_items_str, $pagination_str, $filtering_str;

	


	function __construct( $block, $post_id ){

		$this->block = $block;
		$this->post_id = $post_id;
		$this->fields = get_fields();


		// prepare the wp query
		if( !empty($this->fields['select_posts']) ){

			// posts are selected
			$this->_build_manual_query();
			
		} else if( !empty($this->fields['options']['autoselect']) ){
			
			// posts are selected
			$this->_build_auto_query();

		}

		// do the WP Query
		$this->wp_query = new WP_Query($this->wp_query_args);

		// maybe build pagination
		if( !empty( $this->fields['options']['pagination'] ) ){
			$this->_build_pagination();
		}

		
		// maybe build filtering form
		if( !empty( $this->fields['options']['show_filter'] ) ){
			$this->_build_filter_form();
		}

		// build all grid items
		$this->_build_griditems_return_string();

		
		// build entire block
		$this->_build_acf_block_output();
		
	}

	public function _do_debug(){

		// var_dump($this->wp_query_args);
		
	}

	private function _build_pagination(){
		
		
		$total_pages = $this->wp_query->max_num_pages;

		global $wp_query;
		$wp_query = $this->wp_query;
		
		$big = 9999999; // need an unlikely integer
		$pagination = paginate_links(array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $total_pages,
			'type' => 'list',
			'prev_text' => '<span><</span>',
			'next_text' => '<span>></span>',
			'before_page_number' => '<span>',
			'after_page_number' => '</span>',
			'mid_size' => 5
		));
		
		$this->pagination_str = '<div class="pagination">'.$pagination.'</div>';
	}
	
	private function _build_filter_form(){
		if( is_admin() ){
			$this->filtering_str = '<div class="filteringform">Disabled</div>';
			return;
		} else {
			include( __DIR__ . '/class.posts-grid-filters.php' );
		}
	}

	private function _build_acf_block_output(){

		$guides['acf-block-container'] = '<div id="%1$s" class="nu_posts-grid%2$s%3$s">%7$s<div class="nu__grid cols-%4$s">%6$s<ul>%5$s</ul>%6$s</div></div>';

		$return = sprintf(
			$guides['acf-block-container'],
			!empty( $this->block['anchor' ]) ? $this->block['anchor'] : $this->block['id'],	// block anchor or a unique ID
			!empty($this->block['className']) ? ' '.$this->block['className'] : '',
			!empty($this->block['align']) ? ' '.$this->block['align'] : '',
			$this->fields['options']['columns'],  // column count value (required field)
			$this->grid_items_str,
			$this->pagination_str,
			$this->filtering_str,
		);

		echo $return;
		
	}

	private function _build_griditems_return_string(){

		$return = '';

		$wp_query = $this->wp_query;

		if( !$wp_query->have_posts() ){
			$return .= '<li class="grid-item broken">Nothing Found :(</li>';
		}
		while( $wp_query->have_posts() ) : $wp_query->the_post();
		
			global $post;
			$return .= PostsGrid_Item::init($post, $this->fields);
			
		endwhile;
		wp_reset_postdata(  );

		$this->grid_items_str = $return;
		
	}
	
	
	private function _build_manual_query(){
		
		// 
		$this->wp_query_args = [
			'post_type'			=>		'any',
			'post_status' 		=> 		'publish',
			'posts_per_page' 	=> 		!empty( $this->fields['options']['pagination'] ) ? $this->fields['options']['per_page'] : 12,
			'paged'				=>		get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
			'post__in'			=>		$this->fields['select_posts'],
			'order'				=>		'ASC',
			'orderby'			=>		'post__in',
		];
		
	}
	
	
	
	private function _build_auto_query(){
		
		$selected_post_type = $this->fields['autoselect_posts']['post_type'] ? $this->fields['autoselect_posts']['post_type'] : '';
		$operator = !empty($this->fields['autoselect_posts']['limit_from']) ? 'NOT IN' : 'IN';

		if( !empty($selected_post_type) ){

			// 
			$this->wp_query_args = [
				'post_type' 		=> 		!empty($selected_post_type) ? $selected_post_type : '',
				'post_status' 		=> 		'publish',
				'order'				=>		'ASC',
				'orderby'			=>		'title',
				'paged'				=>		get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
				'posts_per_page' 	=> 		!empty( $this->fields['options']['pagination'] ) ? $this->fields['options']['per_page'] : 12,
			];
	
			
			$this->wp_query_args['tax_query'] = [
				'relation' 		=> 		'AND',
			];

			if( !empty($this->fields['autoselect_posts'][ str_replace( 'nu_', '', $selected_post_type ) . '_category' ]) ){

				$this->wp_query_args['tax_query'][] = [
					'taxonomy'				=> 		$selected_post_type . '-categories',
					'terms'					=> 		$this->fields['autoselect_posts'][ str_replace( 'nu_', '', $selected_post_type ) . '_category' ],
					'include_children'		=> 		false,
					'operator'				=> 		$operator,
				];

			}

			if( !empty($this->fields['autoselect_posts'][ str_replace( 'nu_', '', $selected_post_type ) . '_tags' ]) ){

				$this->wp_query_args['tax_query'][] = [
					'taxonomy'				=> 		$selected_post_type . '-tags',
					'terms'					=> 		$this->fields['autoselect_posts'][ str_replace( 'nu_', '', $selected_post_type ) . '_tags' ],
					'include_children'		=> 		false,
					'operator'				=> 		$operator,
				];

			}
	
	
			if( !empty($_GET['filter-tags']) ){
	
				$this->wp_query_args['tax_query'][] = [
					'taxonomy'				=> 		$selected_post_type . '-tags',
					'terms'					=> 		$_GET['filter-tags'],
					'include_children'		=> 		false,
				];
			}
	
			if( !empty($_GET['filter-categories']) ){
	
				$this->wp_query_args['tax_query'][] = [
					'taxonomy'				=> 		$selected_post_type . '-categories',
					'terms'					=> 		$_GET['filter-categories'],
					'include_children'		=> 		false,
				];
				
			}

		}


	}







	



} // ? end of PostsGrid class

 



?>