<?php
/**
 *  global $post was declared already and will be cleaned up elsewhere
 */
// 

$guides['grid-item-event'] = '
	<li class="grid-item%1$s%7$s%8$s">
		<a href="%6$s" title="Read More about '.get_the_title( ).'">
			%2$s
			<div class="grid-item-content">%3$s%4$s%5$s</div>
		</a>
	</li>
';

$guides['date_time'] = '
	<div class="datetime">
		<div>
			%1$s
			%2$s
		</div>
		%5$s
		<div>
			%3$s
			%4$s
		</div>
	</div>
';


$the_date_time = '<p class="post-date">' . get_the_date( ) . '</p>';

if( !empty(self::$fields) ){

	$instance = new NU_DateTime_Helper(self::$fields);
	$the_date_time = $instance::build_datetime_return_string();

}


$item_style = !empty(self::$gridOptions['item_style']) ? self::$gridOptions['item_style'] : '';
$aspectRatio = '';
$orientationClass = !empty($item_style['orientation']) ? ' has-layout-' . $item_style['orientation'] : '';

if( !empty($item_style['image_dimensions']) ){
	switch ($item_style['image_dimensions']) {
		case 'square':
			$aspectRatio = ' has-square-cover-image';
			break;
		case 'widest':
			$aspectRatio = ' has-very-wide-cover-image';
			break;
		case 'wide':
			$aspectRatio = ' has-wide-cover-image';
			break;
		case 'tallest':
			$aspectRatio = ' has-very-tall-cover-image';
			break;
		case 'tall':
			$aspectRatio = ' has-tall-cover-image';
			break;
			
			default:
			# code...
			$aspectRatio = '';
			break;
	}
}


$griditems_return .= sprintf(
	$guides['grid-item-event'],
	' '.self::$post['post_type'],
	has_post_thumbnail( ) ? '<figure>'.get_the_post_thumbnail( ).'</figure>' : '',
	'<h4 class="post-title"><span>'.get_the_title( ).'</span></h4>',
	$the_date_time,
	'<p class="post-excerpt">'.get_the_excerpt( ).'</p>',
	esc_url( get_the_permalink( ) ),
	$aspectRatio,
	$orientationClass
);
	

// 
?>