<?php

// ------- //
// ATTENDANCE //
// ------- //

/* ENUQUEUE ASSETS */ 
function sp_manager_dashboard_enqueue() {
	$ver = rand(0,99999999);
	
	if(is_page('manager-dashboard')){
		
		wp_enqueue_style('sp_manager_dashboard', get_stylesheet_directory_uri() . '/assets/css/manager.css',['hello-elementor-child-style'], $ver);
		wp_enqueue_script('sp_manager_dashboard', get_stylesheet_directory_uri() . '/assets/js/manager_dashboard.js',['jquery'], $ver);

	}
}
add_action( 'wp_enqueue_scripts', 'sp_manager_dashboard_enqueue' );