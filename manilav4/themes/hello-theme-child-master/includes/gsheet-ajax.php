<?php

add_action("wp_ajax_new_quarter_entry", "new_quarter_entry");
add_action("wp_ajax_nopriv_new_quarter_entry", "new_quarter_entry");

function new_quarter_entry() {
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    user_new_quarter_entry();

    die();
}

add_action("wp_ajax_new_core_comp_entry", "new_core_comp_entry");
add_action("wp_ajax_nopriv_new_core_comp_entry", "new_core_comp_entry");

function new_core_comp_entry() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    mp_after_validate_corecomp($_POST['data']);

    die();
}

add_action("wp_ajax_display_individual_dashboard", "display_individual_dashboard");
add_action("wp_ajax_nopriv_display_individual_dashboard", "display_individual_dashboard");

function display_individual_dashboard() {
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    echo do_shortcode('[individual_dashboard]'); 
    //team_individual_dashboard();

    die();
}

add_action("wp_ajax_guser_montly_production_full", "guser_montly_production_full");
add_action("wp_ajax_nopriv_guser_montly_production_full", "guser_montly_production_full");

function guser_montly_production_full() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $month = isset( $_POST['month'] ) ? (int) $_POST['month'] : date('m');
    if($month == 12){
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year + 1 . "-01-01";
    }else{
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year . "-" . $month + 1 . "-01";
    }


    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = $q_sheet_key['ALL'];
    $q_sheet_key['QA'] = $q_sheet_key['ALL'];
    $q_sheet_key['DESIGN'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMAU'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMEU'] = $q_sheet_key['ALL'];
    $q_sheet_key['FRONTEND'] = $q_sheet_key['ALL'];
    $q_sheet_key['TRAFFIC'] = $q_sheet_key['ALL']; 


    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => 'Productivity Full Report',
        'sheet' => $q_sheet_key['ALL'],
        'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col1,Col2,Col16,Col17,Col18 where Col1 >= date \''.$dateFrom.'\' and Col1 < date \''.$dateTo.'\' and Col2 = \''.$user_firstname.'\' label Col17 \'EXPECTED PRODUCTIVITY\', Col18 \'ACTUAL PRODUCTIVITY\'")',
    ];

// Send the data to Google Spreadsheet via HTTP POST request
    // Query Result version 28
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action("wp_ajax_guser_montly_non_production_full", "guser_montly_non_production_full");
add_action("wp_ajax_nopriv_guser_montly_non_production_full", "guser_montly_non_production_full");

function guser_montly_non_production_full() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $month = isset( $_POST['month'] ) ? (int) $_POST['month'] : date('m');
    if($month == 12){
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year + 1 . "-01-01";
    }else{
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year . "-" . $month + 1 . "-01";
    }


    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = $q_sheet_key['ALL'];
    $q_sheet_key['QA'] = $q_sheet_key['ALL'];
    $q_sheet_key['DESIGN'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMAU'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMEU'] = $q_sheet_key['ALL'];
    $q_sheet_key['FRONTEND'] = $q_sheet_key['ALL'];
    $q_sheet_key['TRAFFIC'] = $q_sheet_key['ALL']; 


    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => 'Non Productivity Full Report',
        'sheet' => $q_sheet_key['ALL'],
        'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AH"), "Select Col1,Col2,Col16,Col17,Col18,Col34 where Col1 >= date \''.$dateFrom.'\' and Col1 < date \''.$dateTo.'\' and Col2 = \''.$user_firstname.'\' and Col16 < 1 and Col16 is Not Null")',
    ];
// Send the data to Google Spreadsheet via HTTP POST request
    // Query Result version 28
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action("wp_ajax_guser_montly_unplanned_leave_full", "guser_montly_unplanned_leave_full");
add_action("wp_ajax_nopriv_guser_montly_unplanned_leave_full", "guser_montly_unplanned_leave_full");

function guser_montly_unplanned_leave_full() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $month = isset( $_POST['month'] ) ? (int) $_POST['month'] : date('m');
    if($month == 12){
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year + 1 . "-01-01";
    }else{
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year . "-" . $month + 1 . "-01";
    }


    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => 'Unplanned Leave',
        'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
        'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col1,Col2,Col3,Col36 where Col1 >= date \''.$dateFrom.'\' and Col1 < date \''.$dateTo.'\' and Col2 = \''.$user_firstname.'\' and Col3 MATCHES \'UNAUTHORISED ABSENCE*|SICK LEAVE*|HALF DAY SICK LEAVE*|HALF DAY (HANGOUT)*|EMERGENCY LEAVE*|HALF DAY EMERGENCY*\'")',
    ];
// Send the data to Google Spreadsheet via HTTP POST request
    // Query Result version 28
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action("wp_ajax_guser_montly_schedule_adherence_full", "guser_montly_schedule_adherence_full");
add_action("wp_ajax_nopriv_guser_montly_schedule_adherence_full", "guser_montly_schedule_adherence_full");

function guser_montly_schedule_adherence_full() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $month = isset( $_POST['month'] ) ? (int) $_POST['month'] : date('m');
    if($month == 12){
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year + 1 . "-01-01";
    }else{
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year . "-" . $month + 1 . "-01";
    }


    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => 'Schedule Adherence',
        'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
        'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col1,Col2,Col3,Col36 where Col1 >= date \''.$dateFrom.'\' and Col1 < date \''.$dateTo.'\' and Col2 = \''.$user_firstname.'\'")',
    ];
// Send the data to Google Spreadsheet via HTTP POST request
    // Query Result version 28
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action("wp_ajax_guser_montly_exeed_tat", "guser_montly_exeed_tat");
add_action("wp_ajax_nopriv_guser_montly_exeed_tat", "guser_montly_exeed_tat");

function guser_montly_exeed_tat() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');

    if(isset( $_POST['month'] )){
        $month = isset( $_POST['month'] ) ? (int) $_POST['month'] : date('m');
        if($month == 12){
            $dateFrom   = $g_year . "-" . $month . "-01";
            $dateTo     = $g_year + 1 . "-01-01";
        }else{
            $dateFrom   = $g_year . "-" . $month . "-01";
            $dateTo     = $g_year . "-" . $month + 1 . "-01";
        }
    }

    if(isset( $_POST['quarter'] )){
        $quarter = isset( $_POST['quarter'] ) ? $_POST['quarter'] : "Q1";
        if($quarter == "Q4"){
            $dateFrom   = $g_year . "-10-01";
            $dateTo     = $g_year + 1 . "-01-01";
        }
        if($quarter == "Q1" || trim($quarter) == ""){
            $dateFrom   = $g_year . "-01-01";
            $dateTo     = $g_year . "-04-01";
        }
        if($quarter == "Q2"){
            $dateFrom   = $g_year . "-04-01";
            $dateTo     = $g_year . "-07-01";
        }
        if($quarter == "Q3"){
            $dateFrom   = $g_year . "-07-01";
            $dateTo     = $g_year . "-10-01";
        }    
    }


    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => 'Query Result',
        'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
        'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","Task TAT!A:O"), "Select Col6,Col3,Col4,Col13,Col10 where Col1 >= date \''.$dateFrom.'\' and Col1 < date \''.$dateTo.'\' and Col2 = \''.$user_firstname.'\' and Col12 = \'Exeeds TAT\'")',
    ];
// Send the data to Google Spreadsheet via HTTP POST request
    // Query Result version 28
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action("wp_ajax_guser_quarter_production", "guser_quarter_production");
add_action("wp_ajax_nopriv_guser_quarter_production", "guser_quarter_production");

function guser_quarter_production() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $quarter = isset( $_POST['quarter'] ) ? $_POST['quarter'] : "Q1";
    if($quarter == "Q4"){
        $dateFrom   = $g_year . "-10-01";
        $dateTo     = $g_year + 1 . "-01-01";
    }
    if($quarter == "Q1" || trim($quarter) == ""){
        $dateFrom   = $g_year . "-01-01";
        $dateTo     = $g_year . "-04-01";
    }
    if($quarter == "Q2"){
        $dateFrom   = $g_year . "-04-01";
        $dateTo     = $g_year . "-07-01";
    }
    if($quarter == "Q3"){
        $dateFrom   = $g_year . "-07-01";
        $dateTo     = $g_year . "-10-01";
    }

    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = $q_sheet_key['ALL'];
    $q_sheet_key['QA'] = $q_sheet_key['ALL'];
    $q_sheet_key['DESIGN'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMAU'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMEU'] = $q_sheet_key['ALL'];
    $q_sheet_key['FRONTEND'] = $q_sheet_key['ALL'];
    $q_sheet_key['TRAFFIC'] = $q_sheet_key['ALL']; 


    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => 'Quarterly Productivity',
        'dateFrom' => $dateFrom ,
        'dateTo' => $dateTo,
        'uname' => $user_firstname,
        'key' => $sheet_key[$getuser[0]['mp_user_team']],
        'sheet' => $q_sheet_key[$getuser[0]['mp_user_team']],
    ];


// Send the data to Google Spreadsheet via HTTP POST request
    // Productivity Query script version1 16
    $post_url = "https://script.google.com/macros/s/AKfycbwOSyiqr_TUISyOamf_kOyuc_oxjxMegj0CdiDohDpzBKZwwGdHnSMKHrVr7TlKFhpW_w/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}


add_action("wp_ajax_guser_montly_production", "guser_montly_production");
add_action("wp_ajax_nopriv_guser_montly_production", "guser_montly_production");

function guser_montly_production() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $month = isset( $_POST['month'] ) ? (int) $_POST['month'] : date('m');
    if($month == 12){
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year + 1 . "-01-01";
    }else{
        $dateFrom   = $g_year . "-" . $month . "-01";
        $dateTo     = $g_year . "-" . $month + 1 . "-01";
    }

    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = $q_sheet_key['ALL'];
    $q_sheet_key['QA'] = $q_sheet_key['ALL'];
    $q_sheet_key['DESIGN'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMAU'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMEU'] = $q_sheet_key['ALL'];
    $q_sheet_key['FRONTEND'] = $q_sheet_key['ALL'];
    $q_sheet_key['TRAFFIC'] = $q_sheet_key['ALL']; 

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => 'Productivity',
        'dateFrom' => $dateFrom ,
        'dateTo' => $dateTo,
        'uname' => $user_firstname,
        'key' => $sheet_key[$getuser[0]['mp_user_team']],
        'sheet' => $q_sheet_key[$getuser[0]['mp_user_team']],
    ];


// Send the data to Google Spreadsheet via HTTP POST request
    // Productivity Query script version1 16
    $post_url = "https://script.google.com/macros/s/AKfycbwOSyiqr_TUISyOamf_kOyuc_oxjxMegj0CdiDohDpzBKZwwGdHnSMKHrVr7TlKFhpW_w/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action("wp_ajax_guser_daily_production", "guser_daily_production");
add_action("wp_ajax_nopriv_guser_daily_production", "guser_daily_production");

function guser_daily_production() {

    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    } 

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];
    
    $user = get_user_by('id', $userid);
    $date_time = (isset($_POST["date"]) && $_POST["date"] != "") ? $_POST["date"] : date('Y-m-d');

    $mydata = [];
    foreach(get_field('mp_user_options','option') as $udata){
        if($udata['mp_user']['ID'] == $userid){
            $mydata = $udata;
            break;
        }
    }


    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M';

    if($mydata['mp_user_team'] == "DMAU"){
        $arrdata = [
            'action' => 'request_daily',
            'tab'   => 'Daily Production',
            'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
            'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$mydata['mp_user_team']].'","Task TAT!A:N45000"),"Select Col1,Col2,Col13,Col6,Col3,Col4,Col7,Col12,Col11,Col10  where Col2 = \''.$user->display_name.'\' and Col1 = date \''.$date_time.'\' Label Col1 \'Date\',Col2 \'Name\',Col6 \'Issue Key\', Col3 \'Request Type\', Col7 \'Status\', Col13 \'TIME SPENT\', Col4 \'Priority\', Col12 \'TAT REACH\', Col11 \'TAT\', Col10 \'TAT#REF\'")',
        ];
    }else{
        $arrdata = [
            'action' => 'request_daily',
            'tab'   => 'Daily Production',
            'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
            'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$mydata['mp_user_team']].'","Task TAT!A:N"),"Select Col1,Col2,Col13,Col6,Col3,Col4,Col7,Col12,Col11,Col10  where Col2 = \''.$user->display_name.'\' and Col1 = date \''.$date_time.'\' LIMIT 1000 Label Col1 \'Date\',Col2 \'Name\',Col6 \'Issue Key\', Col3 \'Request Type\', Col7 \'Status\'")',
        ];
    }

// Send the data to Google Spreadsheet via HTTP POST request
    // Query Result version 28
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action("wp_ajax_guser_capacity_plan", "guser_capacity_plan");
add_action("wp_ajax_nopriv_guser_capacity_plan", "guser_capacity_plan");

function guser_capacity_plan() {
   if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

            $userobj = wp_get_current_user();
            $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
            $userid = ($_POST["u_id"] == "") ? $userid : $_POST["u_id"];


            $timestamp = strtotime($_POST["date"]);
            $dateObject = date('Y-m-d ',$timestamp);            

            $useropts = get_field('mp_user_options','option',true);
            
            $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

            $todayname = date('l',$timestamp);


            if($getuser[0]['other_schedule'] != null){
                $key = array_search($todayname, array_column($getuser[0]['other_schedule'], 'other_schedule_day'));
            }else{
                $key = 'null';
            }

            if($getuser){


                if(is_int($key)){
                    $usertime = $dateObject.$getuser[0]['other_schedule'][$key]['OtherTime'];
                }else{
                    $usertime = $dateObject.$getuser[0]['mp_user_start'];
                }

                $ontime   = $_POST["status"];
                $transexp = date('Y-m-d H:i:s', strtotime('+18 hours',strtotime($usertime)));
                // SET TRANSIENT
        //          if( ! get_transient('user-'.$userid) ){
        //              set_transient( 'user-'.$userid, $ontime, strtotime($transexp));
                    // LOG TO SHEET
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


                    echo $result;
                    die();

            }

}

add_action("wp_ajax_g_production_quarterly_overall_kpi", "production_overall_kpi");
add_action("wp_ajax_nopriv_g_production_quarterly_overall_kpi", "production_overall_kpi");


add_action("wp_ajax_g_production_overall_kpi_team", "production_overall_kpi");
add_action("wp_ajax_nopriv_g_production_overall_kpi_team", "production_overall_kpi");


add_action("wp_ajax_g_production_overall_kpi", "production_overall_kpi");
add_action("wp_ajax_nopriv_g_production_overall_kpi", "production_overall_kpi");

add_action("wp_ajax_g_production_overall_kpi_lead", "production_overall_kpi");
add_action("wp_ajax_nopriv_g_production_overall_kpi_lead", "production_overall_kpi");

add_action("wp_ajax_g_production_quarterly_overall_kpi_lead", "production_overall_kpi");
add_action("wp_ajax_nopriv_g_production_quarterly_overall_kpi_lead", "production_overall_kpi");

add_action("wp_ajax_g_overall_team_kpi", "overall_team_kpi");
add_action("wp_ajax_nopriv_g_overall_team_kpi", "overall_team_kpi");

add_action("wp_ajax_g_individual_utilization_rate_per_task", "individual_utilization_rate_per_task");
add_action("wp_ajax_nopriv_g_individual_utilization_rate_per_task", "individual_utilization_rate_per_task");

add_action("wp_ajax_g_team_overall_task_submited", "team_overall_task_submited");
add_action("wp_ajax_nopriv_g_team_overall_task_submited", "team_overall_task_submited");

add_action("wp_ajax_g_team_yearly_performnace", "g_team_yearly_performnace");
add_action("wp_ajax_nopriv_g_team_yearly_performnace", "g_team_yearly_performnace");

add_action("wp_ajax_g_group_kpi_performnace", "group_kpi_performnace");
add_action("wp_ajax_nopriv_g_group_kpi_performnace", "group_kpi_performnace");

function individual_utilization_rate_per_task(){

    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $_data = isset( $_POST['_data'] ) ? $_POST['_data'] : "ALL";
    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $_tab = isset( $_POST['tab'] ) ? $_POST['tab'] : 'Over All KPI';

    $q_sheet_key = [];
    $q_sheet_key['ALL']         = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV']       = '1MbBxnKxS8NmqmBBX9q0T9NS7d4Cib_lPvBtq7PFRs3g';
    $q_sheet_key['QA']          = '1tcPiMatBKunTeZUyc5z1neOwvh_5hgfoP085P1-rRbU';
    $q_sheet_key['DESIGN']      = '1kofsH1wXqwWrH0aEAnFVf_L_hqDD3FGKdTpQHWyM5WU';
    $q_sheet_key['DMAU']        = '1MWk4ZryYzOmComAGmjep3x833O2vJHdrhejLIsJzaPI';
    $q_sheet_key['DMEU']        = '1mMwOY_UXr-O1Rs_bYtULo8OmTts971W_Dqlme8kHjxQ';
    $q_sheet_key['FRONTEND']    = '1kyOxs5276N3sl5qx15_p-IE1RQXnM2V8Nyux61H21QM';
    $q_sheet_key['TRAFFIC']     = '1Lnodd2A2LK_ZMGYUq-KAYHe0UyWo10DpNM7yQFLPujw';      

    $qry = '=QUERY({IMPORTRANGE(\'Over All KPI Team\'!D$2,"Member!A:A")},"Select * where Col1 <> \'Khale Velasquez\' and Col1 <> \'Debbie Rose Tolentino\' and Col1 <> \'Juan Dela Cruz\'")';    

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => $_tab,
        'sheet' => $q_sheet_key[$_data],
        'qry' => $qry ,
    ];

    // Send the data to Google Spreadsheet via HTTP POST request
    // Query Result version 28
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));

    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();

}

function team_overall_task_submited(){

    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $_data = isset( $_POST['_data'] ) ? $_POST['_data'] : "ALL";
    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $_tab = isset( $_POST['tab'] ) ? $_POST['tab'] : 'Over All KPI';

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = '1MbBxnKxS8NmqmBBX9q0T9NS7d4Cib_lPvBtq7PFRs3g';
    $q_sheet_key['QA'] = '1tcPiMatBKunTeZUyc5z1neOwvh_5hgfoP085P1-rRbU';
    $q_sheet_key['DESIGN'] = '1kofsH1wXqwWrH0aEAnFVf_L_hqDD3FGKdTpQHWyM5WU';
    $q_sheet_key['DMAU'] = '1MWk4ZryYzOmComAGmjep3x833O2vJHdrhejLIsJzaPI';
    $q_sheet_key['DMEU'] = '1mMwOY_UXr-O1Rs_bYtULo8OmTts971W_Dqlme8kHjxQ';
    $q_sheet_key['FRONTEND'] = '1kyOxs5276N3sl5qx15_p-IE1RQXnM2V8Nyux61H21QM';
    $q_sheet_key['TRAFFIC'] = '1Lnodd2A2LK_ZMGYUq-KAYHe0UyWo10DpNM7yQFLPujw';

    $qry = '=UNIQUE(QUERY({IMPORTRANGE(\'Over All KPI Team\'!D$2,"Task TAT!A:C")},"Select Col3 where Col3 <> \'\' and Col3 <> \'Coaching / 1on1\' and Col3 <> \'1on1 Session\' and Col3 <> \'Break / Lunch break\' and Col3 <> \'Coaching Session\' and Col3 <> \'Catch-up / Meeting\' and Col3 <> \'Admin Task\' and Col3 <> \'Idle Time\' and Col3 <> \'Leadership Meeting\' order by Col3"))';    

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => $_tab,
        'qry' => $qry ,
        'sheet' => $q_sheet_key[$_data],
    ];

    // Send the data to Google Spreadsheet via HTTP POST request
    // Query Result
    //$post_url = "https://script.google.com/macros/s/AKfycbxkVT5OW21v5V4lxzKB_YzFYjhzEmk-GTxktmwbl2Z0oBlISh5uvVbZXhsO4aJ5yqGe/exec";
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));

    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();

}

function g_team_yearly_performnace(){

    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $_data = isset( $_POST['_data'] ) ? $_POST['_data'] : "ALL";
    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $_tab = isset( $_POST['tab'] ) ? $_POST['tab'] : 'Over All KPI';

    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M';

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = '1MbBxnKxS8NmqmBBX9q0T9NS7d4Cib_lPvBtq7PFRs3g';
    $q_sheet_key['QA'] = '1tcPiMatBKunTeZUyc5z1neOwvh_5hgfoP085P1-rRbU';
    $q_sheet_key['DESIGN'] = '1kofsH1wXqwWrH0aEAnFVf_L_hqDD3FGKdTpQHWyM5WU';
    $q_sheet_key['DMAU'] = '1MWk4ZryYzOmComAGmjep3x833O2vJHdrhejLIsJzaPI';
    $q_sheet_key['DMEU'] = $q_sheet_key['ALL'];
    $q_sheet_key['FRONTEND'] = '1kyOxs5276N3sl5qx15_p-IE1RQXnM2V8Nyux61H21QM';
    $q_sheet_key['TRAFFIC'] = $q_sheet_key['ALL'];    

    $qry = '=UNIQUE(QUERY({IMPORTRANGE("'.$sheet_key[$_data].'","Task TAT!A:C")},"Select Month(Col1)+1 where Col1 like \''.$g_year.'-%'.'\' label Month(Col1)+1 \' '.$sheet_key[$_data]. " " .$g_year.'\'"))';

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => $_tab,
        'qry' => $qry ,
        'sheet' => $q_sheet_key[$_data],
    ];

    // Send the data to Google Spreadsheet via HTTP POST request
    // Query Result
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));

    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();

}

function group_kpi_performnace(){

    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $_data = isset( $_POST['_data'] ) ? $_POST['_data'] : "ALL";
    $_tab = isset( $_POST['tab'] ) ? $_POST['tab'] : 'Over All KPI';

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = '1MbBxnKxS8NmqmBBX9q0T9NS7d4Cib_lPvBtq7PFRs3g';
    $q_sheet_key['QA'] = '1tcPiMatBKunTeZUyc5z1neOwvh_5hgfoP085P1-rRbU';
    $q_sheet_key['DESIGN'] = '1kofsH1wXqwWrH0aEAnFVf_L_hqDD3FGKdTpQHWyM5WU';
    $q_sheet_key['DMAU'] = '1MWk4ZryYzOmComAGmjep3x833O2vJHdrhejLIsJzaPI';
    $q_sheet_key['DMEU'] = '1mMwOY_UXr-O1Rs_bYtULo8OmTts971W_Dqlme8kHjxQ';
    $q_sheet_key['FRONTEND'] = '1kyOxs5276N3sl5qx15_p-IE1RQXnM2V8Nyux61H21QM';
    $q_sheet_key['TRAFFIC'] = '1Lnodd2A2LK_ZMGYUq-KAYHe0UyWo10DpNM7yQFLPujw';    

    $qry = '=QUERY(IMPORTRANGE("'.$q_sheet_key[$_data].'","Over All KPI Team!A:D"), "Select Col4",0)';

    $arrdata = [
        'action' => 'request_kpi_group',
        'tab'   => $_tab,
        'qry' => $qry ,
        'sheet' => $q_sheet_key[$_data],
    ];

    // Send the data to Google Spreadsheet via HTTP POST request
    // Query Result
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));

    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();

}

function overall_team_kpi(){
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $_data = isset( $_POST['_data'] ) ? $_POST['_data'] : "ALL";
    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $_tab = isset( $_POST['tab'] ) ? $_POST['tab'] : 'Over All KPI';
    if($_data == "ALL"){
    $qry = '=UNIQUE(QUERY({IMPORTRANGE("1mcQlCOKX-pagywbq_zEMpL-EllE3axj0xmORYK1VnZE","Score!A:AN")},"Select Col4,Col5 where Col1 like \''.$g_year.'-%\'"))';
    }else{
    $qry = '=UNIQUE(QUERY({IMPORTRANGE("1mcQlCOKX-pagywbq_zEMpL-EllE3axj0xmORYK1VnZE","Score!A:AN")},"Select Col4,Col5 where Col1 like \''.$g_year.'-%\'  and Col5 = \''.$_data.'\'"))';        
    }

    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = $q_sheet_key['ALL'] ;
    $q_sheet_key['QA'] = $q_sheet_key['ALL'];
    $q_sheet_key['DESIGN'] = $q_sheet_key['ALL'];
    $q_sheet_key['DMAU'] = $q_sheet_key['ALL'] ;
    $q_sheet_key['DMEU'] = $q_sheet_key['ALL'];
    $q_sheet_key['FRONTEND'] = $q_sheet_key['ALL'];
    $q_sheet_key['TRAFFIC'] = $q_sheet_key['ALL']; 

    $arrdata = [
        'action' => 'request_yearly',
        'tab'   => $_tab,
        'year' => $g_year,
        'qry' => $qry ,
        'sheet' => $q_sheet_key[$_data],
    ];


// Send the data to Google Spreadsheet via HTTP POST request
//Query Result    
//$post_url = "https://script.google.com/macros/s/AKfycbxkVT5OW21v5V4lxzKB_YzFYjhzEmk-GTxktmwbl2Z0oBlISh5uvVbZXhsO4aJ5yqGe/exec";
    $post_url =  "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    //$post_url = "https://script.google.com/macros/s/AKfycbyvOsj8wgBol80ADvpzVtkDkTaL1S3e1S04s9fdWwkx307gLEkNmkzEHE9VFWCTDtXC/exec";
    //$post_url = "https://script.google.com/macros/s/AKfycbyT3Xk3ohaKm2PVndDgW7PuzyvJXP_CsC8PEmXVdw7lvcHjG0s-EKkBtMNMIL288DHR/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

function production_overall_kpi() {
    if ( !wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
      exit("No naughty business please");
    }

    $user_firstname = "";
    $leadid = '';
    $_data = isset( $_POST['_data'] ) ? $_POST['_data'] : "ALL";
    $g_year = isset( $_POST['g_year'] ) ? (int) $_POST['g_year'] : date('Y');
    $month = isset( $_POST['month'] ) ? (int) $_POST['month'] : date('m');
    $_tab = isset( $_POST['tab'] ) ? $_POST['tab'] : 'Over All KPI';

    if($_tab == 'Over All KPI Lead'){

        $useropts = get_field('mp_user_options','option',true);
        $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user_team'] == $_POST['_data']; }));
        
        $getuser_mem  = array_values(array_filter($getuser, function($user) use ($userid) { return $user['mp_user_role'] == 'Member'; }));

        $leaddName = $getuser_mem[0]['reports_to']['display_name'];
        $leadId = $getuser_mem[0]['reports_to']['ID'];

        $getlead  = array_values(array_filter($useropts, function($user) use ($leadId) { return $user['mp_user']['ID'] == $leadId; }));
        $_dataLead = $getlead[0]['mp_user_team']; 
    }else{
        $_dataLead = $_data;
    }
    
    if(isset( $_POST['month'] )){
        if($month == 12){
            $dateFrom   = $g_year . "-" . $month . "-01";
            $dateTo     = $g_year + 1 . "-01-01";
        }else{
            $dateFrom   = $g_year . "-" . $month . "-01";
            $dateTo     = $g_year . "-" . $month + 1 . "-01";
        }
    }

    $quarter = isset( $_POST['quarter'] ) ? $_POST['quarter'] : "Q1";

    if(isset( $_POST['quarter'] )){
        if($quarter == "Q4"){
            $dateFrom   = $g_year . "-10-01";
            $dateTo     = $g_year + 1 . "-01-01";
        }
        if($quarter == "Q1" || trim($quarter) == ""){
            $dateFrom   = $g_year . "-01-01";
            $dateTo     = $g_year . "-04-01";
        }
        if($quarter == "Q2"){
            $dateFrom   = $g_year . "-04-01";
            $dateTo     = $g_year . "-07-01";
        }
        if($quarter == "Q3"){
            $dateFrom   = $g_year . "-07-01";
            $dateTo     = $g_year . "-10-01";
        }  
    }

    $dateFrom = isset($_POST['fromDate']) ? $_POST['fromDate'] : $dateFrom;
    $dateTo = isset($_POST['toDate']) ? $_POST['toDate'] : $dateTo;

    $sheet_key = [];
    $sheet_key['ALL'] = '';
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 


    $q_sheet_key = [];
    $q_sheet_key['ALL'] = '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs';
    $q_sheet_key['WPDEV'] = '1MbBxnKxS8NmqmBBX9q0T9NS7d4Cib_lPvBtq7PFRs3g';
    $q_sheet_key['QA'] = '1tcPiMatBKunTeZUyc5z1neOwvh_5hgfoP085P1-rRbU';
    $q_sheet_key['DESIGN'] = '1kofsH1wXqwWrH0aEAnFVf_L_hqDD3FGKdTpQHWyM5WU';
    $q_sheet_key['DMAU'] = '1MWk4ZryYzOmComAGmjep3x833O2vJHdrhejLIsJzaPI';
    $q_sheet_key['DMEU'] = '1mMwOY_UXr-O1Rs_bYtULo8OmTts971W_Dqlme8kHjxQ';
    $q_sheet_key['FRONTEND'] = '1kyOxs5276N3sl5qx15_p-IE1RQXnM2V8Nyux61H21QM';
    $q_sheet_key['TRAFFIC'] = '1Lnodd2A2LK_ZMGYUq-KAYHe0UyWo10DpNM7yQFLPujw'; 

    $arrdata = [
        'action' => 'request_monthly',
        'tab'   => $_tab,
        'dateFrom' => $dateFrom ,
        'dateTo' => $dateTo,
        'uname' => $leaddName,
        'key' => $sheet_key[$_dataLead],
        'sheet' => $q_sheet_key[$_dataLead],
    ];


// Send the data to Google Spreadsheet via HTTP POST request
    // Productivity Query script version1 16
    $post_url = "https://script.google.com/macros/s/AKfycbwOSyiqr_TUISyOamf_kOyuc_oxjxMegj0CdiDohDpzBKZwwGdHnSMKHrVr7TlKFhpW_w/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 80, 'sslverify' => false, 'body' => $arrdata));

    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = json_encode($result);
    echo $result;
    die();
}

add_action( 'init', 'my_script_enqueuer',10);

function my_script_enqueuer() {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;
    $nonce = wp_create_nonce("display_individual_dashboard");

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));


   wp_register_script( "manilav4-tracker-js", get_stylesheet_directory_uri().'/assets/js/gsheetajaxcall.js', array('jquery') );
   wp_localize_script( 'manilav4-tracker-js', 'user_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), "user" => $user->nickname,"display_name" => $getuser[0]["mp_user"]["display_name"], "userid" => $userid,"role"=>$getuser[0]["mp_user_role"],"starttime"=>$getuser[0]["mp_user_start"], "today" => date('Y-m-d'),'nonce' => $nonce,'mp_user_team' => $getuser[0]['mp_user_team']));        
   

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'manilav4-tracker-js' );

}

function guser_quarter_core_comp_production($u_id,$g_year,$quarter) {

    $userid = $u_id;

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $user_firstname = $getuser[0]['mp_user']['display_name'];   

    $g_year = $g_year;



    switch ($quarter) {
        case (1):
            $date1 = $g_year.'-01-01';
            $date2 = $g_year.'-02-01';
            $date3 = $g_year.'-03-01';
            $date4 = $g_year.'-04-01';
        break;
        case (2):
            $date1 = $g_year.'-04-01';
            $date2 = $g_year.'-05-01';
            $date3 = $g_year.'-06-01';
            $date4 = $g_year.'-07-01';
        break;
        case (3):
            $date1 = $g_year.'-07-01';
            $date2 = $g_year.'-08-01';
            $date3 = $g_year.'-09-01';
            $date4 = $g_year.'-10-01';
        break;
        default:
            $date1 = $g_year.'-10-01';
            $date2 = $g_year.'-11-01';
            $date3 = $g_year.'-12-01';
            $date4 = ((int)$g_year + 1).'-01-01';
    }    
    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M'; 


    $arrdata = [
        'action' => 'request_quarterly_productivity',
        'tab'   => 'Productivity Query',
        'qry1' => '=IFERROR(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Avg(Col18) where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\' label Avg(Col18) \'Productivity 1\' "))',
        'qry2' => '=IFERROR(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Avg(Col18) where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\' label Avg(Col18) \'Productivity 2\'"))',
        'qry3' => '=IFERROR(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Avg(Col18) where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\' label Avg(Col18) \'Productivity 3\'"))',
        'qry4' => '=IFERROR(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Avg(Col36) where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\' label Avg(Col36) \'Schedule Adherence 1\'"))',
        'qry5' => '=IFERROR(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Avg(Col36) where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\' label Avg(Col36) \'Schedule Adherence 2\'"))',
        'qry6' => '=IFERROR(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Avg(Col36) where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\' label Avg(Col36) \'Schedule Adherence 3\'"))',        
    ];

// Send the data to Google Spreadsheet via HTTP POST request
    $post_url = "https://script.google.com/macros/s/AKfycbyjcwU8KmijpL03bd4BXer_ogrNPvJrt834EcyNjaNRQdQqeca6un4oYHWj3i8yVZh0DA/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $result['type'] = "success";
    $result['data'] = $json;
    $result = $json;//json_encode($result);
    return $result;
}