<?php

// ------- //
// ATTENDANCE //
// ------- //

/* ENUQUEUE ASSETS */ 
function sp_team_performance_enqueue() {
	$ver = rand(0,99999999);
	
	if(is_page('team-performance')){
		
		wp_enqueue_style('sp_team_dashboard', get_stylesheet_directory_uri() . '/assets/css/team.css',['hello-elementor-child-style'], $ver);
		wp_enqueue_script('sp_team_dashboard', get_stylesheet_directory_uri() . '/assets/js/team_performance.js',['jquery'], $ver);
		wp_enqueue_script('canvasjs_a', get_stylesheet_directory_uri() . '/assets/js/jquery.canvasjs.min.js',['jquery'], $ver);

	}
}
add_action( 'wp_enqueue_scripts', 'sp_team_performance_enqueue' );