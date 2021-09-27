<?php
/**
 * 
 */
// 


$guides['grid-item'] = '
	<li class="grid-item default%1$s%7$s%8$s">
		%2$s
		<div class="grid-item-content">%3$s%4$s%5$s%6$s</div>
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

$thePostThumbnail = !empty($item_style['display_featured_image']) && has_post_thumbnail() ? '<figure>'.get_the_post_thumbnail( ).'</figure>' : '';

$readMore = '<a class="nu_posts-grid-readmore" href="' . esc_url( get_the_permalink() ) . '"><span class="moretext">Read More</span></a>';

$griditems_return .= sprintf(
	$guides['grid-item'],
	' '.self::$post['post_type'],
	$thePostThumbnail,
	get_featured_tagstring( $post['ID'] ),
	'<h4 class="post-title is-style-display">'.get_the_title($post['ID']).'</h4>',
	// '<p class="post-title has-larger-font-size">'.get_the_title($post['ID']).'</p>',
	has_excerpt( $post['ID'] ) ? '<p class="post-excerpt">'.get_the_excerpt($post['ID']).'</p>' : '',
	$readMore,
	$aspectRatio,
	$orientationClass
);

	

// 
?>