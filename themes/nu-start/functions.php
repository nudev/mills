<?php
/**
 *
 */
require_once(  get_template_directory() . '/functions/utilities.php');

/**
 * 		enqueues scripts / styles
 * 		cleans wp_head
 * 		...
 */
require_once(  get_template_directory() . '/classes/setup-theme.php');

/**
 * 		creates the theme settings
 * 		google maps api key
 * 		...
 *
 * 		TODO: this really needs a lot of work
 */
// require_once(  get_template_directory() . '/classes/nu-start.php');
require_once(  get_template_directory() . '/classes/nu-starter.php');

/**
 *
 * 		register all the option pages we will use for theme-settings
 *
 */
require_once(  get_template_directory() . '/functions/options-pages.php');

/**
 * 		TBD: brief explainer
 *
 */
require_once(  get_template_directory() . '/classes/content-types.php');


/**
 * 		registers our block styles, pattern categories, block categories
 * 		enqueues some block assets
 * 		handles some filters / utilities specifically related to blocks
 */
require_once(  get_template_directory() . '/functions/gutenberg.php');

/**
 * 		TBD: brief explainer
 *
 */
require_once(  get_template_directory() . '/classes/acf-blocks.php');

/**
 * 		PIM Sync and auto-create posts
 *
 */
require_once(  get_template_directory() . '/classes/pim-handler.php');

// tweaks to the styling for the login page
function my_custom_login(){ ?>
  <style type="text/css">

    body.login{
      background: rgba(0, 0, 0, 1.0) !important;
    }

    body.login div#login h1 a{
      background-image: url('https://brand.northeastern.edu/global/assets/logos/northeastern/svg/northeastern-logo.svg');
      width:315px;
      background-size: 315px 85px;
      height: 85px;
    }
    body.login #login_error, .login .message{
      border-left: 4px solid rgba(224, 39, 47, 1.0) !important;
    }
    body.login #backtoblog a, .login #nav a{
      color:rgba(255,255,255,1.0) !important;
    }
    body.login #backtoblog a:hover, .login #nav a:hover{
      color: rgba(224, 39, 47, 1.0) !important;
      text-decoration: underline;
    }
    .wp-core-ui .button-primary{
      background:rgba(224, 39, 47, 1.0) !important;
      border-color: none !important;
      border-radius: 0 !important;
      text-shadow: none !important;
      box-shadow: none !important;
      border: none;
      min-width: 100px;
    }
    body.login label{
      color:rgba(51, 62, 71, 1.0) !important;
    }

    p#backtoblog{
      display: none;
    }
  </style>
<?php }


// set the remember option to be automatically checked for easier use
function login_checked_remember_me(){
  add_filter('login_footer','rememberme_checked');
}

function rememberme_checked(){
  echo "<script>document.getElementById('rememberme').checked = true;</script>";
}


// change the url that the logo on the login page links to
function my_login_logo_url(){
  return get_bloginfo('url');
}


// change the tooltip value of the logo on the login page
function my_login_logo_url_title(){
  return get_bloginfo('name');
}


// override the default error message
function login_error_override(){
  return 'Invalid login.';
}


// remove the shake on error for the login panel
function my_login_head(){
  remove_action('login_head', 'wp_shake_js', 12);
}




add_action('login_head', 'my_custom_login');
add_filter( 'login_headerurl', 'my_login_logo_url' );
// add_filter( 'login_headertitle', 'my_login_logo_url_title' );
add_filter( 'login_headertext', 'my_login_logo_url_title' );
add_filter('login_errors', 'login_error_override');
add_action('login_head', 'my_login_head');
add_action( 'init', 'login_checked_remember_me' );
add_action('admin_head', 'htx_custom_logo');

	

//
?>
