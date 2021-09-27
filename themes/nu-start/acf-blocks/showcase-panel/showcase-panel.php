<?php
/**
 * 
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// 


// Create id attribute allowing for custom "anchor" value.
$id = 'nu_showcase_panel-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'nu_showcase_panel';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
	<div>
		<?php 

			$allowed_blocks = array( 'acf/showcase-panel-panel','acf/showcase-panel-item', 'acf/showcase-panel-grid', 'core/columns', 'core/group', 'core/column' );
			$template = array(
				array( 'core/columns', [], [
					array( 'core/column', [], [
						array( 'acf/showcase-panel-panel', [], [] ),
					] ),
					array( 'core/column', [], [
						array( 'acf/showcase-panel-grid', [], [] )

					] ),
				] )
			);
			echo '<InnerBlocks template="' . esc_attr( wp_json_encode( $template ) ) . '" templateLock="false" allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" />';
				
		
		 ?>
	</div>
</div>