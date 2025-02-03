<?php

add_action( 'template_redirect', 'mp_redirect_if_user_not_logged_in' );
function mp_redirect_if_user_not_logged_in() {

	if(is_front_page() && is_user_logged_in() ){
		wp_redirect( home_url('user-dashboard') );	
		exit;
	}else if(!is_front_page() && is_user_logged_in()){
		
	}else if( ! is_front_page() && ! is_user_logged_in() ){
		wp_redirect( home_url() );
		exit;
	}

}

add_shortcode( 'test_code', 'mp_code_tester' );
function mp_code_tester( $atts ) {
    // PRINT CONTENT
    ob_start();
    return ob_get_clean();
}

add_action( 'template_redirect', 'role_based_redirect' );
function role_based_redirect() {
    if( is_page('manager-dashboard') ){

		$userobj = wp_get_current_user();
		$userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;

		$useropts = get_field('mp_user_options','option',true);
		$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

		if($getuser[0]['mp_user_role'] === "Member" || $getuser[0]['mp_user_role'] === "Team Leader"){
			wp_redirect( home_url('user-dashboard') );
			exit;			
		}
    }
}

add_action( 'template_redirect', 'role_based_redirect_team_performance' );
function role_based_redirect_team_performance() {
    if( is_page('team-performance') ){

		$userobj = wp_get_current_user();
		$userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;

		$useropts = get_field('mp_user_options','option',true);
		$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

		if($getuser[0]['mp_user_role'] === "Member"){
			wp_redirect( home_url('user-dashboard') );
			exit;			
		}
    }
}

function ti_custom_javascript() {
    ?>
		<script>
			jQuery(document).ready(function(){
				jQuery("body").addClass(user_object.mp_user_team.toLowerCase().replace(/\s/g, '-')).addClass(user_object.role.toLowerCase().replace(/\s/g, '-'));
			});
		</script>
    <?php
}
add_action('wp_head', 'ti_custom_javascript');
