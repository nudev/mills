<?php
/**
 * 
 */
// 



$item_style = !empty(self::$gridOptions['item_style']) ? self::$gridOptions['item_style'] : '';
$aspectRatio = '';
$orientationClass = !empty($item_style['orientation']) ? ' has-layout-' . $item_style['orientation'] : '';

if( !empty($item_style['image_dimensions']) ){
	switch ($item_style['image_dimensions']) {
		case '1-1':
			$aspectRatio = ' has-square-cover-image';
			break;
		case '16-9':
			$aspectRatio = ' has-very-wide-cover-image';
			break;
		case '3-4':
			$aspectRatio = ' has-wide-cover-image';
			break;
		case '9-16':
			$aspectRatio = ' has-very-tall-cover-image';
			break;
		case '4-3':
			$aspectRatio = ' has-tall-cover-image';
			break;
		
		default:
			# code...
			break;
	}
}

$excerpt = '';
$excerpt .= !empty(self::$fields['excerpt_title']) ? '<p class="has-smaller-font-size"><i>'.self::$fields['excerpt_title'].'</i></p>' : '';
$excerpt .= !empty(self::$fields['excerpt_body']) ? '<p class="has-smaller-font-size">'.self::$fields['excerpt_body'].'</p>' : '';

$guides['grid-item-person'] = '
	<li class="grid-item%1$s%7$s%8$s">
		%2$s
		<div class="grid-item-content">%3$s%4$s%5$s%6$s</div>
	</li>
';

$readMore = '<a class="nu_posts-grid-readmore" href="' . esc_url( get_the_permalink() ) . '"><span class="material-icons-outlined moreicon">more_vert</span><span class="moretext">View Profile</span></a>';

$griditems_return .= sprintf(
	$guides['grid-item-person'],
	' '.self::$post['post_type'],
	has_post_thumbnail( ) ? '<figure>'.get_the_post_thumbnail( ).'</figure>' : '',
	get_featured_tagstring( $post['ID'] ),
	'<h4 class="post-title">'.get_the_title().'</h4>',
	// '<p class="post-excerpt">'.get_the_excerpt().'</p>',
	$excerpt,
	$readMore,
	$aspectRatio,
	$orientationClass
);

	

// 
?>