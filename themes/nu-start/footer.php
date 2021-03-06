</main>
<?php
/**
 *
 */
//


// * the pattern is the pattern
$return = [];
$guides = [];


// * guide string for the entire footer
$guides['footer'] = '
	<footer class="site-footer">
		<section>
			<div class="footer-siteinfo">%1$s%3$s%4$s%5$s</div>
			<div class="footer-navmenu">
				%2$s
			</div>
			<div class="footer-sidebar">%6$s</div>
		</section>
	</footer>
';



$social_media = '';

// * loop thru all social media links
if( !empty(NU__Starter::$themeSettings['social']['social_media']) ){

	foreach( NU__Starter::$themeSettings['social']['social_media'] as $name => $link ){
	
		// ? check for link, then find the custom SVG or bail
		if( !empty($link) && file_exists( get_template_directory() . '/__lib/icons/'.$name.'.svg' ) ){
	
			$customIcon = file_get_contents( get_template_directory() . '/__lib/icons/'.$name.'.svg' );
	
			$social_media .= '<span class="nu__customsvg"><a href="'.$link.'" target="_blank" title="view our '.$name.' profile">'.$customIcon.'</a></span>';
	
		}
	}
	
}




$contact_info = '';
if( !empty(NU__Starter::$themeSettings['social']['contact_info']) ){

	foreach( NU__Starter::$themeSettings['social']['contact_info'] as $name => $link ){
	
		if( !empty($link) ){
			if( $name === 'email' ){
				$contact_info .= '<span><a href="mailto:' . $link . '" target="_blank">' . $link . '</a></span>';
			} else {
				$contact_info .= '<span><a href="tel:' . $link . '" target="_blank">' .preg_replace('/\d{3}/', '$0.', str_replace('.', null, $link), 2). '</a></span>';
			}
		}
	
	
	}
}



$footer_sidebar = '';
if( is_active_sidebar( 'footer-engagement' ) ){
	ob_start();
	dynamic_sidebar( 'footer-engagement' );
	$footer_sidebar = ob_get_clean();
}


$return['footer'] = sprintf(
	$guides['footer']
	,nu__getLogo()
	,has_nav_menu('footer_1') ? nu__getMenu('footer_1') : ''
	,!empty(NU__Starter::$themeSettings['social']['google_address']) ? '<div class="address">' . nu__getGoogleMapAddress(NU__Starter::$themeSettings['social']['google_address']) . '</div>' : ''
	,!empty($contact_info) ? '<div class="contact">' . $contact_info . '</div>' :''
	,!empty($social_media) ? '<div class="social">' . $social_media . '</div>' :''
	,$footer_sidebar
);

if( !empty(NU__Starter::$themeSettings['footer']['site_footer']['status']) ){

	echo $return['footer'];
}



// ? handle the required global footer element
NU__Starter::nu__showCookieWarning();
NU__Starter::nu__globalFooterElement();

wp_footer();


echo '
</body>
</html>
';

//
?>