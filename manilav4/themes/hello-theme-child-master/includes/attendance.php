<?php

// ------- //
// ATTENDANCE //
// ------- //

/* ENUQUEUE ASSETS */ 
function sp_attendance_enqueue() {
	$ver = rand(0,99999999);
	
	if(is_page('attendance')){
		
		//wp_enqueue_style('bootstrap_sp', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css',['hello-elementor-child-style'], $ver, true);
		//wp_enqueue_script('bootstrap_sp', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js',['jquery'], $ver,true);			
		wp_enqueue_script('sp_attendance_js', get_stylesheet_directory_uri() . '/assets/js/attendance.js',['jquery'], $ver);

	}
}
add_action( 'wp_enqueue_scripts', 'sp_attendance_enqueue' );

add_action("wp_ajax_get_individual_attendance", "get_individual_attendance");
add_action("wp_ajax_nopriv_get_individual_attendance", "get_individual_attendance");

/* ENUQUEUE ASSETS */ 
function get_individual_attendance() {
	
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];    

	$ver = rand(0,99999999);
	
		$mydata = [];
		foreach(get_field('mp_user_options','option') as $udata){
			if($udata['mp_user']['ID'] == $userid){
				$mydata = $udata;
				break;
			}
		}


		// GET TASKS
		$attendance_url = "";
		$attendace_list = [];
		$sheet_url['WPDEV'] = 'https://script.google.com/macros/s/AKfycbxDdGdpzDvkXXyQnuTV8Udc75PD-vdBXkfqvkSs62i9mnce6xFM-iaxNYfxC3NZb2UD/exec';
		$sheet_url['QA'] = 'https://script.google.com/macros/s/AKfycbwkxlO0ZQ85jxKGWz1Ai_8mDtMFWTG9e2KQ-McOklte5kFkjtFWMJaza8syuLRfBKRfMg/exec';
		$sheet_url['DESIGN'] = 'https://script.google.com/macros/s/AKfycbyQ2XSZ3XPRdbXRVFI1Fdm4XQDAUAOJrYxos0-LmHNyBMy6qJsyj1tm1b0UHWn9ZvYUvw/exec';
		$sheet_url['DMAU'] = 'https://script.google.com/macros/s/AKfycbzBF9aeZAzXsOCekmYd9dekbLkJAjZ0oFEdC1xNERVX3p-2W-RzI1ddSpOgwIlVgXWZRA/exec';
		$sheet_url['DMEU'] = 'https://script.google.com/macros/s/AKfycbzuR4bRJigFgSfXsXwMZIXr7LrrQT6JfMmvPoZY5TUSvQak27hKfMKp1oCM_pydgQ2Y-w/exec';
		$sheet_url['FRONTEND'] = 'https://script.google.com/macros/s/AKfycbyjiOw0EeG5yEkGHP47W6zkB2pQ0aWvlLU6qr73ExVB_mIbsSweQgXw7QXPMLGyIrMT/exec';
		$sheet_url['TRAFFIC'] = 'https://script.google.com/macros/s/AKfycbzo3EVVSD9v1hFaHf-l-j0p_CXS254MhSsNAk8X8NllUGwShdeeZ-WBATUsRO5Rr-pZ/exec';

		$attendance_url = $sheet_url[$mydata['mp_user_team']] . '?action=get_attendance';
		$attendance_url = $attendance_url . '&user='.$userid;
		
		$json = file_get_contents($attendance_url);
		echo $json;

	


		die();
}