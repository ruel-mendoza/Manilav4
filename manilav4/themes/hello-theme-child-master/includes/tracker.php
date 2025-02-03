<?php

// ------- //
// TRACKER //
// ------- //

/* ENUQUEUE ASSETS */ 
function sp_tracker_enqueue() {
	global $current_user; wp_get_current_user();
	$ver = rand(0,99999999);
	
	if(is_page('task-manager')){

		// GET USER DATA
		$mydata = [];
		foreach(get_field('mp_user_options','option') as $udata){
			if($udata['mp_user']['ID'] == $current_user->ID){
				$mydata = $udata;
				break;
			}
		}

		// GET TASKS
		$tasks_list = [];
		$sheet_url = [];
		$sheet_url['WPDEV'] = 'https://script.google.com/macros/s/AKfycbzaj3_S1UN8uZPNFMUr0grh9SGeOsgdtNt1SGBywqyornoT4bCiedEViJ94PeVfvqN3/exec';
		$sheet_url['QA'] = 'https://script.google.com/macros/s/AKfycbxVTzYxwEcLF5f8eGO2b-0Fxq0TqLafyBmiQpswA1TVapXFsSL0lq8G4xQUWGMs-mCyAg/exec';
		$sheet_url['DESIGN'] = 'https://script.google.com/macros/s/AKfycbwiLn1x6aPNx54mQuaevqbyUVHN54FUDjYjmhublvwD5rNUOFm8Qh0F5_b83KKBI0tBKg/exec';
		$sheet_url['DMAU'] = 'https://script.google.com/macros/s/AKfycbxeqCu_lhriiVUOLZ1wLwwoIKrCaZAaMxFX7l94tsd8IbjkBjGVCKSMWx3laxBeHwHnuw/exec';
		$sheet_url['DMEU'] = 'https://script.google.com/macros/s/AKfycbxmLXETjWhQlUqujEGFq874OCpT-TL4wg_ZCg92VL4nmsg78O_loYz6WU73WY5_dmdpsA/exec';
		$sheet_url['FRONTEND'] = 'https://script.google.com/macros/s/AKfycbyjiOw0EeG5yEkGHP47W6zkB2pQ0aWvlLU6qr73ExVB_mIbsSweQgXw7QXPMLGyIrMT/exec';
		$sheet_url['TRAFFIC'] = 'https://script.google.com/macros/s/AKfycbzchmDUvmZAJ-HQYBGTbuLKDOVaNgRAZK4OggMec_LZnFlv43Eb0DVWSBWu_IqXu7Sf/exec';

		$fetch_url = $sheet_url[$mydata['mp_user_team']] . '?action=get_task';
		$fetch_url = $fetch_url . '&name='.$current_user->user_login;


		$json = file_get_contents($fetch_url);
		$data_arr = json_decode($json,true);
		if(isset($data_arr['success'])){
			$tasks_list = $data_arr['data'];
		}
		
		
		// GET TASKS
		wp_enqueue_style('sp-tracker', get_stylesheet_directory_uri() . '/assets/css/tracker.css',['hello-elementor-child-style'], $ver);
		wp_enqueue_script('sp-tracker', get_stylesheet_directory_uri() . '/assets/js/tracker.js',['jquery'], $ver);
		wp_localize_script( 'sp-tracker', 'sp_tracker_obj', [
			'tasks' => $tasks_list,
			'user'  => $current_user->user_login,
			'displayname'  => $current_user->display_name,
			'team'  => $mydata['mp_user_team'],
			'daily_sheet' => $sheet_url[$mydata['mp_user_team']]
		] );
	}
}
add_action( 'wp_enqueue_scripts', 'sp_tracker_enqueue' );