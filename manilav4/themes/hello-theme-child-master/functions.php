<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Unset cron event on plugin deactivation.
 */
function logout_users_plugin_deactivate() {
    wp_clear_scheduled_hook( 'logout_users_plugin_cron_hook' ); // unschedule event.
}
register_deactivation_hook( __FILE__, 'logout_users_plugin_deactivate' );

function logout_all_users() {
    // Get an instance of WP_User_Meta_Session_Tokens
    $sessions_manager = WP_Session_Tokens::get_instance();
    // Remove all the session data for all users.
    $sessions_manager->drop_sessions();
}

// hook function logout_users_plugin_cron_hook() to the action logout_users_plugin_cron_hook.
add_action( 'logout_users_plugin_cron_hook', 'logout_all_users' );

function hello_elementor_child_enqueue_scripts() {
	$ver = rand(0,99999999);
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',[
			'hello-elementor-theme-style',
		], $ver
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

// Sidebar
function my_custom_sidebar() {
	register_sidebar(
		array (
			'name' => __( 'Custom Sidebar Area', 'hello-elementor-child' ),
			'id' => 'custom-side-bar',
			'description' => __( 'This is the custom sidebar that you registered using the code snippet. You can change this text by editing this section in the code.', 'your-theme-domain' ),
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'my_custom_sidebar' );

// Pagebuilder Locale
function sp_unload_textdomain_elementor() {
	if (is_admin()) {
		$user_locale = get_user_meta( get_current_user_id(), 'locale', true );
		if ( 'en_US' === $user_locale ) {
			unload_textdomain( 'elementor' );
			unload_textdomain( 'elementor-pro' );
		}
	}
}
add_action( 'init', 'sp_unload_textdomain_elementor', 100 );
add_filter('jpeg_quality', function($arg){return 100;});
add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_10_hours');

function keep_me_logged_in_for_10_hours( $expirein ) {
    return 43200; // 10 hours in seconds
}

function test() {
        global $totProdTime;
}
add_action( 'after_setup_theme', 'test' );

function custom_node_example($wp_admin_bar){
    $args = array(
        'id' => 'menu-id',
        'title' => 'Manila Inquiry',
        'href' => 'https://manilav4.wpengine.com/leave-request/',
        'meta' => array(
            'class' => 'custom-node-class'
        )
    );
    $wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'custom_node_example', 50);

add_action( 'admin_bar_menu', 'admin_bar_item', 500 );
function admin_bar_item ( WP_Admin_Bar $admin_bar ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$admin_bar->add_menu( array(
		'id'    => 'custom-node',
		'parent' => 'menu-id',
		'group'  => null,
		'title' => 'Leave Request', //you can use img tag with image link. it will show the image icon Instead of the title.
		'href'  => get_permalink( 4230 ),
		'meta' => [
			'title' => __( 'Leave Request', 'textdomain' ), //This title will show on hover
		]
	) );
}

// Custom functions
include_once('includes/core.php');
include_once('includes/gravityforms.php');
include_once('includes/corecomp.php');
include_once('includes/kpi_gravity_form.php');
include_once('includes/user_shortcode.php');
include_once('includes/gsheet-ajax.php');
include_once('includes/gftrackeraction.php');
include_once('includes/tracker.php');
include_once('includes/attendance.php');
include_once('includes/manager_dashboard.php');
include_once('includes/team_performance.php');

// DISABLE ELEMENTOR METADATA
add_filter( "hello_elementor_description_meta_tag", "__return_false" );
// REDIRECT USER ON LOGOUT
add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
  wp_safe_redirect( home_url() );
  exit;
}
