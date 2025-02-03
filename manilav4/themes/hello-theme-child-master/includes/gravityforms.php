<?php

// USER LOGIN
add_filter( 'gform_validation_15', 'mp_validate_login' );
function mp_validate_login( $validation_result ){
    $form      = $validation_result['form'];
	$loginargs = array(
        'user_login'    => rgpost( 'input_1' ),
        'user_password' => rgpost( 'input_2' ),
		'remember'      => false,
    );
	$userobj = wp_signon( $loginargs, false );
	wp_set_current_user( $userobj->ID, $userobj->user_login );
    wp_set_auth_cookie( $userobj->ID,true);
    do_action( 'wp_login', $userobj->user_login, $userobj);

	if( is_wp_error($userobj) ) $validation_result['is_valid'] = false;
	else{
		$userid   = $userobj->ID;
		$useropts = get_field('mp_user_options','option',true);
		//$getuser  = array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; });
		$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

		$todayname = current_datetime()->format('l');


		if($getuser[0]['other_schedule'] != null){
			$key = array_search($todayname, array_column($getuser[0]['other_schedule'], 'other_schedule_day'));
		}else{
			$key = 'null';
		}
		

		if($getuser){
//			$datetime = date('Y-m-d H:i:').'00';
			$datetime = current_datetime()->format('Y-m-d H:i:').'00';

			if(is_int($key)){
				$usertime = current_datetime()->format('Y-m-d ').$getuser[0]['other_schedule'][$key]['OtherTime'];
			}else{
				$usertime = current_datetime()->format('Y-m-d ').$getuser[0]['mp_user_start'];
			}

			//$usertime = current_datetime()->format('Y-m-d ').$getuser[0]['mp_user_start'];
			$ontime   = ($usertime < $datetime) ? 'LATE' : 'PRESENT';
			$transexp = date('Y-m-d H:i:s', strtotime('+18 hours',strtotime($usertime)));
			// SET TRANSIENT
				// LOG TO SHEET
				$arrdata = [
					'action' => 'login',
					'user'   => [
						'timestamp' => $datetime,
						'user'      => $userobj->ID,
						'name'      => $userobj->display_name,
						'status'    => $ontime,
						'schedule'  => $usertime,
						'row'		=> '=Row()',
					],
				];
				$curlurl = 'https://script.google.com/macros/s/AKfycby7-0BCZHLmtcwCzO2n33AjQ3vtmQ37uNXB483O3CsNjdgt-h02PSJstuYgxL12te9X6g/exec';
				$ch = curl_init( $curlurl );
				$payload = json_encode( $arrdata );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
				curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
				$result = curl_exec($ch);
				curl_close($ch);
// 			}
		}
	}
    $validation_result['form'] = $form;
    return $validation_result;
}
// VALIDATION MESSAGE
add_filter( 'gform_validation_message_15', 'mp_validate_message', 10, 2 );
function mp_validate_message( $message, $form ) {
    return "<div class='validation_error'>Login failed, please try again</div>";
}
// DISABLE NOTIFICATIONS
add_filter( 'gform_disable_notification_16', 'mp_disable_notification', 10, 4 );
add_filter( 'gform_disable_notification_15', 'mp_disable_notification', 10, 4 );
function mp_disable_notification( $is_disabled, $notification, $form, $entry ) {
    return true;
}
// DISABLE ENTRIES
add_action( 'gform_after_submission', 'mp_disable_entries' );
function mp_disable_entries( $entry ) {
    GFAPI::delete_entry( $entry['id'] );
}


add_filter( 'gform_field_value_sa_fname', 'gf_user_firstname' );
function gf_user_firstname( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	

	return $getuser[0]['mp_user']['user_firstname'];
}

add_filter( 'gform_field_value_sa_contact', 'gf_user_contact' );
function gf_user_contact( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$usercontact = get_field('mp_number','user_' . $userid);
	return $usercontact;
}


add_filter( 'gform_field_value_sa_lname', 'gf_user_lastname' );
function gf_user_lastname( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	
	return $getuser[0]['mp_user']['user_lastname'];
}

add_filter( 'gform_field_value_sa_uemail', 'gf_user_email' );
function gf_user_email( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	
	return $getuser[0]['mp_user']['user_email'];
}

add_filter( 'gform_field_value_sa_leademail', 'gf_user_leademail' );
function gf_user_leademail( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	
	return $getuser[0]['reports_to']['user_email'];
}

add_filter( 'gform_field_value_sa_role', 'gf_user_role' );
function gf_user_role( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	
	return $getuser[0]['job_description'];
}


//sa_leademail

add_filter( 'gform_field_value_sa_team', 'gf_team_name' );
function gf_team_name( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	
	return $getuser[0]['mp_user_team'];
}

add_filter( 'gform_field_value_sa_leadname', 'gf_leadname' );
function gf_leadname( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	
	return $getuser[0]['reports_to']['nickname'];
}

add_filter( 'gform_field_value_sa_leadfullname', 'gf_leadfullname' );
function gf_leadfullname( $value ) {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
	$useropts = get_field('mp_user_options','option',true);
	$getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));	
	return $getuser[0]['mp_user']['display_name'];
}

add_filter('gform_pre_render_27','gf_team_memberlist');
function gf_team_memberlist($form){
	foreach( $form['fields'] as &$field )  {
		if ( $field->id == 11 ) {
			$userobj = wp_get_current_user();
		    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
		    $useropts = get_field('mp_user_options','option',true);
		    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));
		    $choices = array();
		    $choices[] = array( 'text' => "Select a Member" , 'value' => "" );
		    if($getuser[0]['mp_user_role'] === 'Team Leader'){
		        $filterBy = $getuser[0]['mp_user_team'];		       	
		        foreach($useropts as $user){
		            if($user['mp_user_team'] == $filterBy || $user['reports_to']['ID'] == $userid){
		                $udisplay_name =  $user['mp_user']['display_name'];
		                $udisplay_nname =  $user['mp_user']['display_nickname'];
		                $udisplay_email =  $user['mp_user']['user_email'];
		                
		                $udisplay_id =  $user['mp_user']['ID'];
		                $choices[] = array( 'text' => $udisplay_name , 'value' => $udisplay_email );                              
		            }
		        }
		    }

		    if($getuser[0]['mp_user_role'] === 'Manager'){
		        $filterBy = $getuser[0]['mp_user']['display_name'];
		        
		        $choices[] = array( 'text' => $getuser[0]['mp_user']['display_name'] , 'value' => $getuser[0]['mp_user']['user_email']); 
		        foreach($useropts as $user){
		            $userunder = get_field('mp_user_options','option',true);
		            
		            if($user['mp_user_role'] == 'Team Leader'){
		                $udisplay_name =  $user['mp_user']['display_name'];
		                $udisplay_nname =  $user['mp_user']['display_nickname'];
		                $udisplay_email =  $user['mp_user']['user_email'];
		                $udisplay_id =  $user['mp_user']['ID'];

		                $getundermember  = array_values(array_filter($userunder, function($userunder) use ($udisplay_id) { return $userunder['reports_to']['ID'] == $udisplay_id; }));

		                $choices[] = array( 'text' => $udisplay_name , 'value' => $udisplay_email );

		                foreach($getundermember as $user_under){
		                    $udisplay_uname =  $user_under['mp_user']['display_name'];
		                    $udisplay_unname =  $user_under['mp_user']['display_nickname'];
		                    $udisplay_uid =  $user_under['mp_user']['ID'];
		                    $udisplay_email =  $user_under['mp_user']['user_email'];
		                    $choices[] = array( 'text' => "- - " . $udisplay_uname , 'value' => $udisplay_email );
		                }                
		            }else{
		            	if($user['reports_to']['ID'] == $userid){
		            		$choices[] = array( 'text' => "- - " . $user['mp_user']['display_name'] , 'value' => $user['mp_user']['user_email'] );
		            	}
		            }
		        }
		    }

		    if($getuser[0]['mp_user_role'] === 'Director'){
		        $filterBy = $getuser[0]['mp_user']['display_name'];        

		        foreach($useropts as $user){
		            $userunder = get_field('mp_user_options','option',true);

		            if($user['mp_user_role'] == 'Manager'){
		                $udisplay_name =  $user['mp_user']['display_name'];
		                $udisplay_nname =  $user['mp_user']['display_nickname'];
		                $udisplay_id =  $user['mp_user']['ID'];
		                $udisplay_email =  $user['mp_user']['user_email'];
		                $getundermember  = array_values(array_filter($userunder, function($userunder) use ($udisplay_id) { return $userunder['reports_to']['ID'] == $udisplay_id; }));

						$choices[] = array( 'text' => $udisplay_name , 'value' => $udisplay_email );

		                foreach($getundermember as $user_under){
		                    $userunderunder = get_field('mp_user_options','option',true);
		                    $udisplay_uname =  $user_under['mp_user']['display_name'];
		                    $udisplay_unname =  $user_under['mp_user']['display_nickname'];
		                    $udisplay_uid =  $user_under['mp_user']['ID'];
		                    $udisplay_email =  $user_under['mp_user']['user_email'];

		                    $choices[] = array( 'text' => "- - ".$udisplay_uname , 'value' => $udisplay_email );
		                    

		                    $getundermemberlist  = array_values(array_filter($userunderunder, function($userunderunder) use ($udisplay_uid) { return $userunderunder['reports_to']['ID'] == $udisplay_uid; }));


		                    foreach($getundermemberlist as $user_uunder){
		                        $udisplay_uuname =  $user_uunder['mp_user']['display_name'];
		                        $udisplay_uunname =  $user_uunder['mp_user']['display_nickname'];
		                        $udisplay_uuid =  $user_uunder['mp_user']['ID'];
								$udisplay_email =  $user_under['mp_user']['user_email'];
		                        $choices[] = array( 'text' => "- - - - ".$udisplay_uuname , 'value' => $udisplay_email );
		                                         
		                    } 

		                }                
		            }
		        }        
		    }
		$field->choices = $choices;
		}
	}
    
    
   
    return $form;
}

add_filter( 'gform_pre_render_23', 'my_populate_radio' );

function my_populate_radio( $form ) {
  foreach( $form['fields'] as &$field ) {
    if( 8 === $field->id || 12 === $field->id || 15 === $field->id || 16 === $field->id || 17 === $field->id) {
    	$field->visibility = 'hidden';
    }
  } 
  return $form;
}

add_filter('gform_pre_submission_filter_23', 'change_save_request_tologin');
function change_save_request_tologin($form){
	// grab the first and last name, parts of field 1
	$useropts = get_field('mp_user_options','option',true);
	$femail = rgpost('input_2');
  	$getuser  = array_values(array_filter($useropts, function($user) use ($femail) { return $user['mp_user']['user_email'] == $femail; }));

	$f_firstName = $user['mp_user']['user_firstname'];
	$f_lastName = $user['mp_user']['user_lastname'];
	$f_Team = $user['mp_user_role'];

	$begin = "";
	$end   = "";	

    if($getuser[0]['other_schedule'] != null){
        $key = array_search($todayname, array_column($getuser[0]['other_schedule'], 'other_schedule_day'));
    }else{
        $key = 'null';
    }	

	if (str_contains(rgpost('input_13'), ' - ')) {
		$myArray = explode(' - ', rgpost('input_13'));
		$begin = new DateTime(\DateTime::createFromFormat("d/m/Y", $myArray[0])->format("Y-m-d"));
		$end = new DateTime(\DateTime::createFromFormat("d/m/Y", $myArray[1])->format("Y-m-d"));
		$dateArray = array();

			for($i = $begin; $i <= $end; $i->modify('+1 day')){

				if(is_int($key)){
				    $usertime = $i->format('Y-m-d ').$getuser[0]['other_schedule'][$key]['OtherTime'];
				}else{
				    $usertime = $i->format('Y-m-d ').$getuser[0]['mp_user_start'];
				}

				$ontime   = rgpost('input_14');
				$transexp = date('Y-m-d H:i:s', strtotime('+18 hours',strtotime($usertime)));
				$arrdata = [
					    'timestamp' => $usertime,
					    'user'      => $getuser[0]['mp_user']['ID'],
					    'name'      => $getuser[0]['mp_user']['display_name'],
					    'status'    => $ontime,
					    'schedule'  => $usertime,
					    'row'       => '=Row()',
				];
				array_push($dateArray,$arrdata);
			}

			$arrdata = [
				'action' => 'bulkinsert',
				'user'   => $dateArray,
			];

			$curlurl = 'https://script.google.com/macros/s/AKfycbw8D2tdDh3WQUZRENensUQabRkcLXQdraeDvac41J39ekboQ49MX7LVyno-MAg4tAmBjA/exec';
			$ch = curl_init( $curlurl );
			$payload = json_encode( $arrdata );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
			$result = curl_exec($ch);
			curl_close($ch);
	}else{
		$begin = new DateTime(\DateTime::createFromFormat("d/m/Y", rgpost('input_13'))->format("m/d/Y"));

		if(is_int($key)){
		    $usertime = $begin->format('Y-m-d ').$getuser[0]['other_schedule'][$key]['OtherTime'];
		}else{
		    $usertime = $begin->format('Y-m-d ').$getuser[0]['mp_user_start'];
		}		
		$ontime   = rgpost('input_14');
		$transexp = date('Y-m-d H:i:s', strtotime('+18 hours',strtotime($usertime)));		

		$arrdata = [
			'action' => 'login',
			'user'   => [
					    'timestamp' => $usertime,
					    'user'      => $getuser[0]['mp_user']['ID'],
					    'name'      => $getuser[0]['mp_user']['display_name'],
					    'status'    => $ontime,
					    'schedule'  => $usertime,
					    'row'       => '=Row()',
					],
		];
		$curlurl = 'https://script.google.com/macros/s/AKfycbw8D2tdDh3WQUZRENensUQabRkcLXQdraeDvac41J39ekboQ49MX7LVyno-MAg4tAmBjA/exec';
		$ch = curl_init( $curlurl );
		$payload = json_encode( $arrdata );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
		$result = curl_exec($ch);
		curl_close($ch);		
	}

	// return modified form
	return $form;
}

add_filter('gform_pre_submission_filter_26', 'change_notification_subject');
add_filter('gform_pre_submission_filter_24', 'change_notification_subject');
function change_notification_subject($form){
	// grab the first and last name, parts of field 1
	$useropts = get_field('mp_user_options','option',true);
	$femail = rgpost('input_3');
  	$getuser  = array_values(array_filter($useropts, function($user) use ($femail) { return $user['mp_user']['user_email'] == $femail; }));

	$f_firstName = $user['mp_user']['user_firstname'];
	$f_lastName = $user['mp_user']['user_lastname'];
	$f_Team = $user['mp_user_role'];
	$datetime = date('Y-m-d');

	if($getuser[0]['other_schedule'] != null){
	    $key = array_search($todayname, array_column($getuser[0]['other_schedule'], 'other_schedule_day'));
	}else{
	    $key = 'null';
	}

	if($getuser){


	    if(is_int($key)){
	        $usertime = $datetime.' '.$getuser[0]['other_schedule'][$key]['OtherTime'];
	    }else{
	        $usertime = $datetime.' '.$getuser[0]['mp_user_start'];
	    }

	    $ontime   = rgpost('input_5');;
	    $transexp = date('Y-m-d H:i:s', strtotime('+18 hours',strtotime($usertime)));

	        $arrdata = [
	            'action' => 'login',
	            'user'   => [
	                'timestamp' => $usertime,
	                'user'      => $getuser[0]['mp_user']['ID'],
	                'name'      => $getuser[0]['mp_user']['display_name'],
	                'status'    => $ontime,
	                'schedule'  => $usertime,
	                'row'       => '=Row()',
	            ],
	        ];


	        $curlurl = 'https://script.google.com/macros/s/AKfycby7-0BCZHLmtcwCzO2n33AjQ3vtmQ37uNXB483O3CsNjdgt-h02PSJstuYgxL12te9X6g/exec';
	        $ch = curl_init( $curlurl );
	        $payload = json_encode( $arrdata );
	        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
	        $result = curl_exec($ch);
	        curl_close($ch);
	}
	
	$form['autoResponder']['subject'] = "test";

	// return modified form
	return $form;
}

add_filter( 'gform_notification_26', 'change_notification_email', 10, 3 );
add_filter( 'gform_notification_24', 'change_notification_email', 10, 3 );
function change_notification_email( $notification, $form, $entry ) {

	$useropts = get_field('mp_user_options','option',true);
	$femail = rgpost('input_3');
  	$getuser  = array_values(array_filter($useropts, function($user) use ($femail) { return $user['mp_user']['user_email'] == $femail; }));

	$f_firstName = $getuser[0]['mp_user']['user_firstname'];
	$f_lastName = $getuser[0]['mp_user']['user_lastname'];
	$f_Team = $getuser[0]['mp_user_team'];
	$f_email = $getuser[0]['mp_user']['user_email'];
	$f_leadEmail = $getuser[0]['reports_to']['user_email'];
	$f_contact = get_field('mp_number','user_' . $getuser[0]['mp_user']['ID']);
	$datetime = date('Y-m-d');


    if ( $notification['name'] == 'Admin Notification' ) {
 
	    //There is no concept of admin notifications anymore, so we will need to target notifications based on other criteria, such as name
	    $notification['message'] = str_replace(array("{Team Lead}","{Leave Date}","{Name First}","{Name Last}","{Role}","{Email}","{contact}"),array($getuser[0]['reports_to']['nickname'],$datetime,$f_firstName,$f_lastName,$f_Team,$f_email,$f_contact), $notification['message']);

	    $notification['fromName'] = str_replace(array("{Name First}","{Name Last}"),array($f_firstName,$f_lastName),$notification['fromName']);

	    $notification['bcc'] = str_replace("{LeadEmail}",$f_leadEmail,$notification['bcc']);

 
    }
    if ( $notification['name'] == 'Request Notification' ) {
    	$notification['subject'] = str_replace("{Leave Date}",$datetime,$notification['subject']);
    	$notification['message'] = str_replace(array("{Name First}","{Leave Date}"),array($f_firstName,$datetime),$notification['message']);
    }
 
    return $notification;
}
add_filter( 'gform_notification_27', 'change_notification_coaching', 10, 3 );
function change_notification_coaching( $notification, $form, $entry ) {

	$useropts = get_field('mp_user_options','option',true);
	$femail = rgpost('input_11');
  	$getuser  = array_values(array_filter($useropts, function($user) use ($femail) { return $user['mp_user']['user_email'] == $femail; }));

	$f_firstName = $getuser[0]['mp_user']['user_firstname'];
	$f_lastName = $getuser[0]['mp_user']['user_lastname'];
	$f_Team = $getuser[0]['mp_user_team'];
	$f_email = $getuser[0]['mp_user']['user_email'];
	$f_leadEmail = $getuser[0]['reports_to']['user_email'];
	$f_contact = get_field('mp_number','user_' . $getuser[0]['mp_user']['ID']);
	$datetime = date('Y-m-d');


    if ( $notification['name'] == 'Admin Notification' ) {
 
	    //There is no concept of admin notifications anymore, so we will need to target notifications based on other criteria, such as name
	    $notification['message'] = str_replace(array("{Team Lead}","{Leave Date}","{Name First}","{Name Last}","{Role}","{Email}","{contact}"),array($getuser[0]['reports_to']['nickname'],$datetime,$f_firstName,$f_lastName,$f_Team,$f_email,$f_contact), $notification['message']);

	    $notification['fromName'] = str_replace(array("{Name First}","{Name Last}"),array($f_firstName,$f_lastName),$notification['fromName']);

	    $notification['to'] = str_replace("{LeadEmail}",$f_leadEmail,$notification['to']);
	    $notification['subject'] = str_replace(array("{Name First}","{Name Last}"),array($f_firstName,$f_lastName),$notification['subject']);
 
    }
    if ( $notification['name'] == 'Request Notification' ) {
    	$notification['subject'] = str_replace(array("{Name First}","{Name Last}"),array($f_firstName,$f_lastName),$notification['subject']);
    	$notification['message'] = str_replace(array("{Name First}","{Name Last}"),array($f_firstName,$f_lastName),$notification['message']);
    }
 
    return $notification;
}

add_filter( 'gform_validation_26', 'custom_validation' );
add_filter( 'gform_validation_24', 'custom_validation' );
function custom_validation( $validation_result ) {
	$useropts = get_field('mp_user_options','option',true);

    $form = $validation_result['form'];

    $femail = rgpost('input_3');

  	$getuser  = array_values(array_filter($useropts, function($user) use ($femail) { return $user['mp_user']['user_email'] == $femail; }));


    //supposing we don't want input 1 to be a value of 86
    if (!$getuser) {
  
        // set the form validation to false
        $validation_result['is_valid'] = false;
  
        //finding Field with ID of 1 and marking it as failed validation
        foreach( $form['fields'] as &$field ) {
  
            //NOTE: replace 1 with the field you would like to validate
            if ( $field->id == '3' ) {
                $field->failed_validation = true;
                $field->validation_message = "Please use you're spotzer email";
                break;
            }
        }
  
    }
  
    //Assign modified $form object back to the validation result
    $validation_result['form'] = $form;
    return $validation_result;
  
}