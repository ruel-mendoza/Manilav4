<?php

// [current_user_display_name]
function display_current_user_display_name () {
    $user = wp_get_current_user();
    $display_name = $user->display_name;
    return $user->display_name;
}

add_shortcode('current_user_display_name', 'display_current_user_display_name');

function display_current_user_job_description(){
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));
    $job_description = "";
    if($getuser){
        $job_description = $getuser[0]['job_description'];
    }
    return $job_description;
}

add_shortcode('user_job_description', 'display_current_user_job_description');

function display_current_user_team(){
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));
    $job_description = "";
    if($getuser){
        $job_description = $getuser[0]['mp_user_team'];
    }
    return $job_description;
}
add_shortcode('user_team', 'display_current_user_team');


function display_current_user_reports_to(){
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));
    $job_description = "";
    if($getuser){
        $job_description = $getuser[0]['reports_to']['display_name'];
    }
    return $job_description;
}

add_shortcode('reports_to', 'display_current_user_reports_to');

add_shortcode('get_user_daily_production', 'user_daily_production');

function user_daily_production() {
    $totProdTime = 0;
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;

    $date_time = date('Y-m-d');

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

    $arrdata = [
        'action' => 'request_daily',
        'tab'   => 'Daily Production',
        'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
        'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$mydata['mp_user_team']].'","Task TAT!A:L"),"Select Col12,Col6,Col3,Col4,Col7,Col11,Col10 where Col2 = \''.$user->display_name.'\' and Col1 = \''.$date_time.'\' Label Col6 \'Issue Key\', Col3 \'Request Type\', Col7 \'Status\'")',
    ];


// Send the data to Google Spreadsheet via HTTP POST request
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    ob_start();
    ?>
        <div class="user_dashboard_daily_task">
        <div class="caption" style="text-align: left"><?=$user->display_name?> Daily Production Summary</div>
        <table id="table-list">
          <thead>
            <tr>
              <!--th scope="col" width="7%">#</th-->
              <th scope="col">Tasks</th>
              <th scope="col">Status</th>
              <th scope="col">Time Spent</th>
              <th scope="col">Complexity</th>
              <th scope="col">Acceptable Duration (mins)</th>
              <th scope="col">Productivity</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($json as $task) { 
                if (empty($task->timeSpent) || $task->timeSpent = "" || $task->timeSpent = " "){
                    $hours = 0;    
                }else{
                    $hours = $task->timeSpent;
                }
                $hours = $hours * 24;
                $h = $hours;
                $hwhole = floor($h);      // 1
                $minfraction = $h - $hwhole; // .25

                $minutes = $minfraction * 60;
                $m = $minutes;
                $mwhole = floor($m);      // 1
                $secfraction = $m - $mwhole; // .25

                $secods = $secfraction * 60;
                $s = $secods;
                $swhole = floor($s);      // 1
                if($task->requestType <> "Idle Time"){
                    $totProdTime = $totProdTime + $task->timeSpent;
                }
                $text = (trim($task->issueKey) != "") ? $task->issueKey . " | " . $task->requestType : $task->requestType;
            ?>    
            <tr>
              <!--td data-label="#" rel="<?=$task->timeSpent?>"><strong><?= $task->rowId; ?></strong></td-->
              <td data-label="tasks"><?= $text; ?></td>
              <td data-label="status"><?= $task->status; ?></td>
              <td data-label="timespent"><?= $hwhole . ":" . $mwhole .":" . $swhole ?></td>
              <td data-label="complexity"><?= $task->priority ?></td>
              <td data-label="complexity"><?= $task->tatref ?></td>
              <td data-label="productivity"><?= $task->tatReach; ?></td>
            </tr>
            <?php }
            ?>
          </tbody>
        </table>
        </div>
        <script>
            var totProdTime = <?=$totProdTime;?>;
        </script>
    <?php
    return ob_get_clean();    
}

//=SUM(E2,E3,E4) * 86400 /60 / 540 * 100
function user_daily_productivity() {
    $user = wp_get_current_user();
    $userid = isset( $user->ID ) ? (int) $user->ID : 0;

    $date_time .= date('Y-m-d');

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

    
    $arrdata = [
        'action' => 'request_daily',
        'tab'   => 'Productivity',
        'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
        'qry' => '=QUERY(IMPORTRANGE("'.$sheet_key[$mydata['mp_user_team']].'","AT Tracker!A:R"),"Select Col118 where Col2 = \''.$user->display_name.'\' and Col1 = date \''.$date_time.'\'")',
    ];

    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));
    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    $pdata = $json[0];
    echo number_format((float)($pdata->productivity * 100), 2, '.', '') . "%";
}

add_shortcode('show_team_list', 'team_memberlist');

function team_memberlist($attributes){

    $a = shortcode_atts( array(
        'type' => 'a',
        'name' => true,
        'date' =>false,
        'month' =>false,
        'year' =>false,
        'quarter' =>false,
        'title' =>false,
        'team'=>false,
    ), $attributes );

    $userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));
    $nonce = wp_create_nonce("guser_daily_production");

    //print_r($useropts[]);

    $form_type = $a['type'];

    $str = "";


    if($getuser[0]['mp_user_role'] === 'Team Leader'){
        $filterBy = $getuser[0]['mp_user_team'];

        if($a['title']){
        $str_title = "<h3>{$getuser[0]['mp_user_team']} Members</h3>";
        }else{
        $str_title = "";
        }

        
        foreach($useropts as $user){
            if($user['mp_user_team'] == $filterBy || $user['reports_to']['ID'] == $userid){
                $udisplay_name =  $user['mp_user']['display_name'];
                $udisplay_nname =  $user['mp_user']['display_nickname'];
                $udisplay_id =  $user['mp_user']['ID'];
                if($form_type == 'a'){
                    $str .= sprintf('<div class="userlist"><a href="#" data-id="%d" data-nonce="%s">%s</div>',$udisplay_id,$nonce,$udisplay_name);
                }else{
                        if($userid == $udisplay_id){
                            $str .= sprintf('<option rel="'.$user['mp_user_role'].'" value="%d" selected>%s</option>',$udisplay_id,$udisplay_name);
                        }else{
                            iF($getuser[0]['mp_user_role'] != $user['mp_user_role']){
                                $str .= sprintf('<option rel="'.$user['mp_user_role'].'" value="%d">%s</option>',$udisplay_id,$udisplay_name);
                            }
                        }
                }
            }
        }
    }

    if($getuser[0]['mp_user_role'] === 'Manager'){
        $filterBy = $getuser[0]['mp_user']['display_name'];
        if($a['title']){
        $str_title = "<h3>Manila Team List</h3>";
        }else{
        $str_title = "";
        }

        //echo "<pre rel='okok' style='display:none'>";
        //print_r($useropts);
        //echo "</pre>";

        $str .= sprintf('<option rel="'.$getuser[0]['mp_user_role'].'" rol="0" value="%d" selected>%s</option>',$getuser[0]['mp_user']['ID'],$getuser[0]['mp_user']['display_name']);

        foreach($useropts as $user){
            $userunder = get_field('mp_user_options','option',true);

            if($user['mp_user_role'] == 'Team Leader'){
                $udisplay_name =  $user['mp_user']['display_name'];
                $udisplay_nname =  $user['mp_user']['display_nickname'];
                $udisplay_id =  $user['mp_user']['ID'];
                $getundermember  = array_values(array_filter($userunder, function($userunder) use ($udisplay_id) { return $userunder['reports_to']['ID'] == $udisplay_id; }));


                if($form_type == 'a'){
                    $str .= sprintf('<div class="userlist"><a href="#" data-id="%d" data-nonce="%s">%s</div>',$udisplay_id,$nonce,$udisplay_name);
                }else{
                        if($userid == $udisplay_id){
                            $str .= sprintf('<option rel="'.$user['mp_user_role'].'" rol="0" value="%d" selected>%s</option>',$udisplay_id,$udisplay_name);
                        }else{
                            iF($getuser[0]['mp_user_role'] != $user['mp_user_role']){
                                $str .= sprintf('<option rel="'.$user['mp_user_role'].'" rol="0" value="%d">%s</option>',$udisplay_id,$udisplay_name);
                            }
                        }
                }
                foreach($getundermember as $user_under){
                    $udisplay_uname =  $user_under['mp_user']['display_name'];
                    $udisplay_unname =  $user_under['mp_user']['display_nickname'];
                    $udisplay_uid =  $user_under['mp_user']['ID'];

                    if($form_type == 'a'){
                        $str .= sprintf('<div class="userlist"><a href="#" data-id="%d" data-nonce="%s">- - %s</div>',$udisplay_uid,$nonce,$udisplay_uname);
                    }else{
                        $str .= sprintf('<option rel="'.$user_under['mp_user_role'].'" rol="0" value="%d">- - %s</option>',$udisplay_uid,$udisplay_uname);
                    }                    
                }                
            }else{
                if($user['reports_to']['ID'] == $userid){
                    if($form_type == 'a'){
                        $str .= sprintf('<div class="userlist"><a href="#" data-id="%d" data-nonce="%s">- - - %s</div>',$user['mp_user']['ID'],$nonce,$user['mp_user']['display_name']);
                    }else{
                        $str .= sprintf('<option rel="'.$user_under['mp_user_role'].'" rol="0" value="%d">- - - %s</option>',$user['mp_user']['ID'],$user['mp_user']['display_name']);
                    }
                }
            }
        }
    }

    if($getuser[0]['mp_user_role'] === 'Director'){
        $filterBy = $getuser[0]['mp_user']['display_name'];
        if($a['title']){
        $str_title = "<h3>Manila Team List</h3>";
        }else{
        $str_title = "";
        }

        //echo "<pre rel='okok' style='display:none'>";
        //print_r($useropts);
        //echo "</pre>";
        $str .= "";

        //$str .= sprintf('<option rel="'.$getuser[0]['mp_user_role'].'" rol="0" value="%d" selected>%s</option>',$getuser[0]['mp_user']['ID'],$getuser[0]['mp_user']['display_name']);

        foreach($useropts as $user){
            $userunder = get_field('mp_user_options','option',true);

            if($user['mp_user_role'] == 'Manager'){
                $udisplay_name =  $user['mp_user']['display_name'];
                $udisplay_nname =  $user['mp_user']['display_nickname'];
                $udisplay_id =  $user['mp_user']['ID'];
                $getundermember  = array_values(array_filter($userunder, function($userunder) use ($udisplay_id) { return $userunder['reports_to']['ID'] == $udisplay_id; }));

                if($form_type == 'a'){
                    $str .= sprintf('<div class="userlist"><a href="#" data-id="%d" data-nonce="%s">%s</div>',$udisplay_id,$nonce,$udisplay_name);
                }else{
                        if($userid == $udisplay_id){
                            $str .= sprintf('<option rel="'.$user['mp_user_role'].'" rol="0" value="%d" selected>%s</option>',$udisplay_id,$udisplay_name);
                        }else{
                            iF($getuser[0]['mp_user_role'] != $user['mp_user_role']){
                                $str .= sprintf('<option rel="'.$user['mp_user_role'].'" rol="0" value="%d">%s</option>',$udisplay_id,$udisplay_name);
                            }
                        }
                }

                foreach($getundermember as $user_under){
                    $userunderunder = get_field('mp_user_options','option',true);
                    $udisplay_uname =  $user_under['mp_user']['display_name'];
                    $udisplay_unname =  $user_under['mp_user']['display_nickname'];
                    $udisplay_uid =  $user_under['mp_user']['ID'];

                    if($form_type == 'a'){
                        $str .= sprintf('<div class="userlist"><a href="#" data-id="%d" data-nonce="%s">- - %s</div>',$udisplay_uid,$nonce,$udisplay_uname);
                    }else{
                        $str .= sprintf('<option rel="'.$user_under['mp_user_role'].'" rol="0" value="%d">- - %s</option>',$udisplay_uid,$udisplay_uname);
                    }  

                    $getundermemberlist  = array_values(array_filter($userunderunder, function($userunderunder) use ($udisplay_uid) { return $userunderunder['reports_to']['ID'] == $udisplay_uid; }));


                    foreach($getundermemberlist as $user_uunder){
                        $udisplay_uuname =  $user_uunder['mp_user']['display_name'];
                        $udisplay_uunname =  $user_uunder['mp_user']['display_nickname'];
                        $udisplay_uuid =  $user_uunder['mp_user']['ID'];

                        if($form_type == 'a'){
                            $str .= sprintf('<div class="userlist"><a href="#" data-id="%d" data-nonce="%s">- - - - %s</div>',$udisplay_uuid,$nonce,$udisplay_uuname);
                        }else{
                            $str .= sprintf('<option rel="'.$user_uunder['mp_user_role'].'" rol="0" value="%d">- - - - %s</option>',$udisplay_uuid,$udisplay_uuname);
                        }                    
                    } 

                }                
            }
        }
        
    }


    if($form_type == 'option'){
        if($a['name'] === true){
            if($getuser[0]['mp_user_role'] !== 'Member') {
                $strbody = '<label for="form_fields[name]" class="left"><span>Name</span><br><select name="form_fields[name]" id="team_memberlist" class="elementor-field-textual elementor-size-md left" data-nonce="'.$nonce.'"><option value="">Select Member</option>'.$str.'</select></label>';
            }
        }
        if($a['team']){
                    if($getuser[0]['mp_user_role'] === 'Director' || $getuser[0]['mp_user_role'] === 'Manager'){
                        $strbody .= '<label for="form_fields[team]" class="left"><span>Team</span><br><select name="form_fields[team]" id="team-list" class="elementor-field-textual elementor-size-md left">';
                                $strbody .= '<option value="">Select Team</option>';
                                $strbody .= '<option value="DMAU">DMAU</option>';
                                $strbody .= '<option value="DMEU">DMEU</option>';
                                //$strbody .= '<option value="DMEU" '. ($getuser[0]['mp_user_team'] == 'DMEU' ? 'selected="selected"' : ""  )  .'>DMEU</option>';
                                $strbody .= '<option value="DESIGN">DESIGN</option>';
                                $strbody .= '<option value="QA">QA</option>';
                                $strbody .= '<option value="WPDEV">WPDEV</option>';
                                $strbody .= '<option value="FRONTEND">FRONTEND</option>';
                                $strbody .= '<option value="TRAFFIC">TRAFFIC</option>';
                                $strbody .= '</select></label>';
                    }else{
                        $strbody .= '<label for="form_fields[team]" class="left"><span>Team</span><br><select name="form_fields[team]" id="team-list" class="elementor-field-textual elementor-size-md left">';
                        $strbody .= '<option value="" selected="selected">Select Team</option>';
                        $userunder = get_field('mp_user_options','option',true);

                        $udisplay_name =  $getuser[0]['mp_user']['display_name'];
                        $udisplay_nname =  $getuser[0]['mp_user']['display_nickname'];
                        $udisplay_id =  $getuser[0]['mp_user']['ID'];
                        $getundermember  = array_values(array_filter($userunder, function($userunder) use ($udisplay_id) { return $userunder['reports_to']['ID'] == $udisplay_id; }));       

                        
                        $teams_ls = (array) null;
                        $cnt = 0;
                        foreach($getundermember as $user_under){
                            array_push($teams_ls, $user_under['mp_user_team']);
                        }
                        foreach(array_unique($teams_ls) as $f_team){
                                $strbody .= '<option value="'.$f_team.'">'.$f_team.'</option>';    
                        }
                        $strbody .= '</select></label>'; 
                        if(empty($teams_ls)){
                        $strbody = '';    
                        }
                    }
        }

        if($a['year']){
            $strbody .= '<label for="form_fields[year]" class="left"><span>Year</span><br><select name="form_fields[year]" id="form-field-year" class="elementor-field-textual elementor-size-md left">';
            $cur_year = date('Y');
            for($year = 2023; $year <= ($cur_year); $year++) {
                if ($year == $cur_year) {
                    $strbody .= '<option value="'.$year.'" selected="selected">'.$year.'</option>';
                } else {
                    $strbody .= '<option value="'.$year.'">'.$year.'</option>';
                }
            }               
            $strbody .= '</select></label>';
        }
        if($a['month']){
            $strbody .= '<label for="form_fields[month]" class="left"><span>Month</span><br><select name="form_fields[month]" id="form-field-month" class="elementor-field-textual elementor-size-md left">';
            $cur_month = date('m');
            for($month = 1; $month <= 12; $month++) {
                $monthName = date("F", mktime(0, 0, 0, $month, 1));                
                if ($month == $cur_month) {
                    $strbody .= '<option value="'.$month.'" selected="selected">'.$monthName.'</option>';
                } else {
                    $strbody .= '<option value="'.$month.'">'.$monthName.'</option>';
                }
            }   
            $strbody .= '</select></label>';         
        }
        if($a['quarter']){
            $strbody .= '<label for="form_fields[quarter]" class="left"><span>Trimesters</span><br><select name="form_fields[quarter]" id="form-field-quarter" class="elementor-field-textual elementor-size-md left">';
                    $strbody .= '<option value="" selected="selected">Select Trimesters</option>';
                    $strbody .= '<option value="Q1">Q1</option>';
                    $strbody .= '<option value="Q2">Q2</option>';
                    $strbody .= '<option value="Q3">Q3</option>';
                    $strbody .= '<option value="Q4">Q4</option>';
            $strbody .= '</select></label>';         
        }
                
        if($a['date']){
            $currentDate = date('Y-m-d');
            $strbody .= '<div class="datecontainer"></div>';
        }
        return $str_title . $strbody;
    }else{
        return $str_title . $str;
    }
    
}

add_action( 'wp_ajax_nopriv_gf_display_get_form', 'gf_display_get_form' );
add_action( 'wp_ajax_gf_display_get_form', 'gf_display_get_form' );

add_filter( 'gform_shortcode_display', 'gf_display_shortcode', 10, 3 );

// Add the "display" action to the gravityforms shortcode
// e.g. [gravityforms action="display" id=1]


function gf_display_shortcode( $shortcode_string, $attributes, $content ){
    $a = shortcode_atts( array(
        'id' => 0,
    ), $attributes );

    $form_id = absint( $a['id'] );

    if ( $form_id < 1 ) {
        return 'Missing the ID attribute.';
    }

    $html = sprintf( '<div id="gf_button_form_container_%d" style="display:none;"></div>', $form_id );
    return $html;
}


add_action( 'wp_ajax_nopriv_gf_button_get_form', 'gf_button_ajax_get_form' );
add_action( 'wp_ajax_gf_button_get_form', 'gf_button_ajax_get_form' );

add_filter( 'gform_shortcode_button', 'gf_button_shortcode', 10, 3 );


// Add the "button" action to the gravityforms shortcode
// e.g. [gravityforms action="button" id=1 text="button text"]

function gf_button_shortcode( $shortcode_string, $attributes, $content ){
    $a = shortcode_atts( array(
        'id' => 0,
        'text' => 'Show me the form!',
        'button_class' => ''
    ), $attributes );

    $form_id = absint( $a['id'] );

    if ( $form_id < 1 ) {
        return 'Missing the ID attribute.';
    }

    // Enqueue the scripts and styles
    gravity_form_enqueue_scripts( $form_id, true );

    $ajax_url = admin_url( 'admin-ajax.php' );

    $html = sprintf( '<button id="gf_button_get_form_%d" class="%s">%s</button>', $form_id, $a['button_class'], $a['text'] );

    $html .= "<script>
                    jQuery(document).ready( function() {
                        jQuery('.warning_red, .warning_yellow').hide();
                        jQuery('.warning_green .elementor-alert-title').html('Ready for a new task');
                        jQuery('.warning_green .elementor-alert-description').html('Click on the ADD NEW TASK button to add new task.');
                    });
                    (function () {
                        var initAjaxButton = function() {
                            jQuery('#gf_button_get_form_{$form_id}').click(function(){
                                var button = jQuery(this);
                                jQuery.get('{$ajax_url}?action=gf_button_get_form&form_id={$form_id}',function(response){
                                    jQuery('#gf_button_form_container_{$form_id}').html(response).fadeIn();
                                    //button.remove();
                                    jQuery('.warning_green').hide();                                    
                                    button.hide();
                                    if(window['gformInitDatepicker']) {gformInitDatepicker();}
                                });
                            });
                        };
                        window.addEventListener('DOMContentLoaded', initAjaxButton);
                    }());
            </script>";
    return $html;
}

function gf_button_ajax_get_form(){
    $form_id = isset( $_GET['form_id'] ) ? absint( $_GET['form_id'] ) : 0;
    gravity_form( $form_id,true, false, false, false, true );
    die();
}
function gf_display_get_form(){
    $form_id = isset( $_GET['form_id'] ) ? absint( $_GET['form_id'] ) : 0;
    gravity_form( $form_id,true, false, false, false, true );
    die();
}

add_shortcode('individual_dashboard', 'team_individual_dashboard');

function team_individual_dashboard(){

    if(isset($_POST["u_id"])){
        $userid = $_POST["u_id"];    
    }else{
        $userobj = wp_get_current_user();
        $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    }
    if(isset($_POST["g_year"])){
        $gyear = $_POST["g_year"];
    }else{
        $gyear = date('Y');
    }    

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));
        $user_role = $getuser[0]["mp_user_role"];
        $user_dname = $getuser[0]["mp_user"]["display_name"];
        $searchstr = $gyear.'-% '.$user_dname.'%';

        $mp_user_team = $getuser[0]['mp_user_team'];
        $job_description = $getuser[0]['job_description'];
        $reports_to = $getuser[0]['reports_to']['display_name'];
    
    $arrdata = [
        'action' => 'core competencies',
        'tab'   => 'Core Comp',
        'sheet' => '1m4ER7ip9X6_1iaXZTseRipK15Jk0p1F6OPgp-pfUTUs',
        'qry' => '=QUERY(IMPORTRANGE("1mcQlCOKX-pagywbq_zEMpL-EllE3axj0xmORYK1VnZE","Score!A:CE"),"Select * where Col1 like \''.$searchstr.'\'")',
    ];
    /*Query Result script*/
    $post_url = "https://script.google.com/macros/s/AKfycbz3n4hgXgAT209ekFlN70r-y7jqDqSkyJmKfY599zc1bIpda0C6se02KKqiFWBu8H0J/exec";
    $request = new WP_Http();
    $response = $request->request($post_url, array('method' => 'GET','timeout' => 50, 'sslverify' => false, 'body' => $arrdata));


    if ($has_return_value && (bool) $response === false || is_wp_error($response) || isset($response['response']['code']) && $response['response']['code'] > 400) {
        return;
    }

    $json = json_decode($response['body']);
    //print_r($json);
    //die();
    if((($mp_user_team != 'TRAFFIC') && ($mp_user_team != 'FRONTEND')) && ($user_role == "Team Leader" || $user_role == "Manager")){
        //echo "1";
        if(count($json) <> 0) {
            foreach($json as $data){
                $data->undefined = $userid;
                $str_table .= get_teamlead_table($data);
            }
        }else{
            $attr =  array("gyear"=>$gyear,"q" => "", "user" => $userid);
            for ($x = count($json) + 1; $x <= 4; $x++) {
              $attr['q'] =  $gyear."-Q" . $x;
              //$str_table .= get_teamlead_table($attr);
              $str_table =  '<div class="norecord"><div class="py-1 px-2 text-center">No Record found</div></div>';
            }            
        }
    }else if(($mp_user_team != 'TRAFFIC') && ($mp_user_team != 'FRONTEND')){
        //echo "2";
        if(count($json) <> 0) {
            foreach($json as $data){
                $data->undefined = $userid;
                $str_table .= get_teammember_table($data);
            }
        }else{
            $attr =  array("gyear"=>$gyear,"q" => "", "user" => $userid);
            for ($x = count($json) + 1; $x <= 4; $x++) {
              $attr['q'] =  $gyear."-Q" . $x;
              //$str_table .= get_teamlead_table($attr);
              $str_table =  '<div class="norecord"><div class="py-1 px-2 text-center">No Record found</div></div>';
            }            
        }
    }else{
        if($mp_user_team == 'TRAFFIC'){
            //echo "3";
            if(count($json) <> 0) {
                foreach($json as $data){
                    $data->undefined = $userid;
                    $str_table .= get_traffic_table($data);                
                }
            }else{
                $attr =  array("gyear"=>$gyear,"q" => "", "user" => $userid);
                for ($x = count($json) + 1; $x <= 4; $x++) {
                  $attr['q'] =  $gyear."-Q" . $x;
                  //$str_table .= get_teammember_table($attr);
                  $str_table =  '<div class="norecord"><div class="py-1 px-2 text-center">No Record found</div></div>';
                }            
            }  
        }else{
            //echo "4";
            if(count($json) <> 0) {
                foreach($json as $data){
                    $data->undefined = $userid;
                    $str_table .= get_frontend_table($data);                
                }
            }else{
                $attr =  array("gyear"=>$gyear,"q" => "", "user" => $userid);
                for ($x = count($json) + 1; $x <= 4; $x++) {
                  $attr['q'] =  $gyear."-Q" . $x;
                  //$str_table .= get_teammember_table($attr);
                  $str_table =  '<div class="norecord"><div class="py-1 px-2 text-center">No Record found</div></div>';
                }            
            }
        }
        
        
    }
    if ( wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
        if(count($json) == 0){
            $result['type'] = "failed";
        }else{
            $result['type'] = "success";
        }
        $result["ctr"] = count($json);
        $result["role"] = $user_role;
        $result["user_dname"] = $user_dname;
        $result["mp_user_team"] = $mp_user_team;
        $result["job_description"] = $job_description;
        $result["reports_to"] = $reports_to;
        $result['data'] = $str_table;
        $result = json_encode($result);
        echo $result;
        return ;
    }else{
        return $str_table;
    }
    
}

function user_new_quarter_entry(){
    $userobj = wp_get_current_user();    

    if(isset($_POST["u_id"]) && !empty(trim($_POST["u_id"]))){
        $userid = $_POST["u_id"];
    }else{
        $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;
    }

    if(isset($_POST["g_year"])){
        $gyear = $_POST["g_year"];
    }else{
        $gyear = date('Y');
    }    

    if(isset($_POST["q"])){
        $quarter = $_POST["q"];
    }else{
        $quarter = 1;
    }    
    
    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));
    $user_role = $getuser[0]["mp_user_role"];
    $user_dname = $getuser[0]["mp_user"]["display_name"];
    $mp_user_team = $getuser[0]['mp_user_team'];
    if((($mp_user_team != 'TRAFFIC') && ($mp_user_team != 'FRONTEND')) && ($user_role == "Team Leader" || $user_role == "Manager")){
            $attr =  array("gyear"=>$gyear,"q" => $gyear."-Q" . $quarter, "user" => $userid);
            $dataq = guser_quarter_core_comp_production($userid,$gyear,$quarter);
            $str_table = get_teamlead_table($attr,$dataq);
    }else if(($mp_user_team != 'TRAFFIC') && ($mp_user_team != 'FRONTEND')){
            $attr =  array("gyear"=>$gyear,"q" => $gyear."-Q" . $quarter, "user" => $userid);
            $dataq = guser_quarter_core_comp_production($userid,$gyear,$quarter);
            $str_table = get_teammember_table($attr,$dataq);
    }else if($mp_user_team == 'TRAFFIC'){
            $attr =  array("gyear"=>$gyear,"q" => $gyear."-Q" . $quarter, "user" => $userid);
            $dataq = guser_quarter_core_comp_production($userid,$gyear,$quarter);
            $str_table = get_traffic_table($attr,$dataq);
    }else{
            $attr =  array("gyear"=>$gyear,"q" => $gyear."-Q" . $quarter, "user" => $userid);
            $dataq = guser_quarter_core_comp_production($userid,$gyear,$quarter);
            $str_table = get_frontend_table($attr,$dataq);
    }

    if ( wp_verify_nonce( $_POST['nonce'], "display_individual_dashboard")) {
        $result['type'] = "success";
        $result['data'] = $str_table;
        $result = json_encode($result);
        echo $result;
        return ;
    }else{
        return $str_table;
    }

}