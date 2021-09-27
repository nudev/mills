<?php
/**
 *  global $post was declared already and will be cleaned up elsewhere
 */
// 


$guides['grid-item'] = '
	<li class="grid-item%1$s%7$s%8$s">
		<a href="%6$s" title="Read More about '.get_the_title( ).'">
			%2$s
			<div class="grid-item-content">%3$s%4$s%5$s</div>
		</a>
	</li>
';

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
	$guides['grid-item'],
	' '.self::$post['post_type'],
	has_post_thumbnail( ) ? '<figure>'.get_the_post_thumbnail( ).'</figure>' : '',
	get_featured_tagstring( $post['ID'] ),
	'<h4 class="post-title">'.get_the_title($post['ID']).'</h4>',
	has_excerpt( $post['ID'] ) ? '<p class="post-excerpt">'.get_the_excerpt($post['ID']).'</p>' : '',
	esc_url( get_the_permalink( ) ),
	$aspectRatio,
	$orientationClass
);

// 
?>