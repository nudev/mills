<?php
/**
 * 
 */
// 


$guides['filteringform'] = '
	<div class="filteringform js__filteringform">
		<form action="">
			<div class="filters">
				<div class="filters-filter">
					<label for="filter-categories"><span>Categories:</span></label>
					<select name="filter-categories[]" data-placeholder="Categories" multiple="multiple">
						%1$s
					</select>
				</div>
				<div class="filters-filter">
					<label for="filter-tags"><span>Tags:</span></label>
					<select name="filter-tags[]" data-placeholder="Tags" multiple="multiple">
						%2$s
					</select>
				</div>
			</div>
			<div class="submission">
				<div class="wp-block-button is-style-outline"><a href="#" class="wp-block-button__link">Submit</a></div>
				<a href="'.get_permalink($this->post_id).'" class="outline button">Clear</a>
			</div>
		</form>
	</div>
';


$filter_by_categories = get_terms([
	'taxonomy' => $this->fields['autoselect_posts']['post_type'].'-categories',
	'hide_empty' => true
]);
$filter_by_tags = get_terms([
	'taxonomy' => $this->fields['autoselect_posts']['post_type'].'-tags',
	'hide_empty' => true
]);

$selectedFilters = [];
if( !empty($_GET['filter-categories']) ){
	$selectedFilters = array_merge( $selectedFilters, $_GET['filter-categories'] );
}
if( !empty($_GET['filter-tags']) ){
	$selectedFilters = array_merge( $selectedFilters, $_GET['filter-tags'] );
}

$cats_string = '';
$tags_string = '';
foreach( $filter_by_categories as $filter_by_category ){
	$term = get_term($filter_by_category, $this->fields['autoselect_posts']['post_type'].'-categories');
	$cats_string .= sprintf(
		'<option value="%2$s"%3$s>%1$s</option>'
		,$term->name
		,$term->term_id
		,in_array($term->term_id, $selectedFilters) ? ' selected="selected"' : ''  // httpAPI things
	);
}
foreach( $filter_by_tags as $filter_by_tag ){
	$term = get_term($filter_by_tag, $this->fields['autoselect_posts']['post_type'].'-tags');
	$tags_string .= sprintf(
		'<option value="%2$s"%3$s>%1$s</option>'
		,$term->name
		,$term->term_id
		,in_array($term->term_id, $selectedFilters) ? ' selected="selected"' : ''  // httpAPI things
	);
}






$this->filtering_str = sprintf(
	$guides['filteringform'],
	!empty($cats_string) ? $cats_string : '',
	!empty($tags_string) ? $tags_string : '',
);






// 
?>