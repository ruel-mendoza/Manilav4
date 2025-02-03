<?php

// USER Core Comp
//add_action( 'gform_pre_process_18', 'mp_after_validate_corecomp');
function mp_after_validate_corecomp($q){


    $userid = isset( $q[0]['uid'] ) ? (int) $q[0]['uid'] : 0;
    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

    $sheet_key = [];
    $sheet_key['WPDEV'] = '1Ukn32YtyAp6-8c9RuUXcwvREqX9uyG4CTDTz_d9W-j8';
    $sheet_key['QA'] = '1p2RLPyHPSfrBzxHOLoobySbleWLYzN-JcMrsDOxY6Yg';
    $sheet_key['DESIGN'] = '1Cw9URK2i6rBiYt6joiHS8_5Q9JOLbtSdh5mkL0hbR0g';
    $sheet_key['DMAU'] = '19inS7RT55SaVyIuUDSHIuG4ya7AQdqgZ6kIIfiD-m_0';
    $sheet_key['DMEU'] = '1i_QmxkMh26peChh8BrMk_s_BZbP1J1lUdSDRS5wbPXw';
    $sheet_key['FRONTEND'] = '13ds6a4lmATOS0vN_zb4-VBwPHFaCYuhq1KaDmN5cQBE';
    $sheet_key['TRAFFIC'] = '1-NL7tLDUKc2dSxLaKAnlBEB8_DXCOFOAJw0cyxnZi5M';         

            $datetime = date('Y-m-d');
            $user_firstname = $getuser[0]['mp_user']['display_name'];

                switch (substr($q[0]['querykey'],5,2)) {
                case ('Q1'):
                    $date1 = substr($q[0]['querykey'],0,4).'-01-01';
                    $date2 = substr($q[0]['querykey'],0,4).'-02-01';
                    $date3 = substr($q[0]['querykey'],0,4).'-03-01';
                    $date4 = substr($q[0]['querykey'],0,4).'-04-01';
                break;
                case ('Q2'):
                    $date1 = substr($q[0]['querykey'],0,4).'-04-01';
                    $date2 = substr($q[0]['querykey'],0,4).'-05-01';
                    $date3 = substr($q[0]['querykey'],0,4).'-06-01';
                    $date4 = substr($q[0]['querykey'],0,4).'-07-01';
                break;
                case ('Q3'):
                    $date1 = substr($q[0]['querykey'],0,4).'-07-01';
                    $date2 = substr($q[0]['querykey'],0,4).'-08-01';
                    $date3 = substr($q[0]['querykey'],0,4).'-09-01';
                    $date4 = substr($q[0]['querykey'],0,4).'-10-01';
                break;
                default:
                    $date1 = substr($q[0]['querykey'],0,4).'-10-01';
                    $date2 = substr($q[0]['querykey'],0,4).'-11-01';
                    $date3 = substr($q[0]['querykey'],0,4).'-12-01';
                    $date4 = ((int)substr($q[0]['querykey'],0,4) + 1).'-01-01';
                }

                if($q[0]['role'] == "Team Leader" && $q[0]['team'] != 'TRAFFIC' && $q[0]['team'] != 'FRONTEND'){                

                    $arrdata = [
                        'action'                                    => 'add_entry',
                        'QueryKey'                                  => $q[0]['querykey'],
                        'Timestamp'                                 => $datetime,
                        'Reviewer'                                  => $q[0]['reviewer'],
                        'Reviewee Name'                             => $q[0]['udname'],
                        'Team'                                      => $q[0]['team'],
                        'Role'                                      => $q[0]['role'],
                        'Team Culture Lead Score'                   => $q[0]['teamCultureLeadScore'],
                        'Team Culture Member Score'                 => $q[0]['teamCultureMemberScore'],
                        'Communication Management Lead Score'       => $q[0]['communicationManagementLeadScore'],
                        'Communication Management Member Score'     => $q[0]['communicationManagementMemberScore'],
                        'Innovation Lead Score'                     => $q[0]['innovationLeadScore'],
                        'Innovation Member Score'                   => $q[0]['innovationMemberScore'],
                        'Change Management Lead Score'              => $q[0]['changeManagementLeadScore'],
                        'Change Management Member Score'            => $q[0]['changeManagementMemberScore'],
                        'Learning & Development Lead Score'         => $q[0]['learningDevelopmentLeadScore'],
                        'Learning & Development Member Score'       => $q[0]['learningDevelopmentMemberScore'],
                        'Conflict Management Lead Score'            => $q[0]['conflictManagementLeadScore'],
                        'Conflict Management MemberScore'           => $q[0]['conflictManagementMemberscore'],
                        'FEEDBACK1'                                 => $q[0]['feedback1'],
                        'FEEDBACK2'                                 => $q[0]['feedback2'],
                        'Overall Feedback'                          => $q[0]['overallFeedback'],
                        'Productivity 1'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 2'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 3'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',

                        'Schedule Adherence 1'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 2'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 3'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 1' =>  '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 2' =>  '=Average(BFnewRow:BHnewRow)',                        
                        'Overall KPI' =>  '=IFERROR(IFS(AND($E$newRow = "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "TRAFFIC",$F$newRow <> "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow = "TRAFFIC",$F$newRow = "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($G$newRow:$P$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($Q$newRow:$AB$newRow)),0)',
                        'Row ID' =>  '=IF(ISBLANK(AnewRow),"",ROW())',
                        ];
                }else if($q[0]['team'] == 'TRAFFIC'){
                     $arrdata = [
                        'action'                                    => 'add_entry',
                        'QueryKey'                                  => $q[0]['querykey'],
                        'Timestamp'                                 => $datetime,
                        'Reviewer'                                  => $q[0]['reviewer'],
                        'Reviewee Name'                             => $q[0]['udname'],
                        'Team'                                      => $q[0]['team'],
                        'Role'                                      => $q[0]['role'],
                        'Administration Team'                       => $q[0]['administrationTeam'],
                        'Administration Self'                       => $q[0]['administrationSelf'],
                        'Dependability Team'                        => $q[0]['dependabilityTeam'],
                        'Dependability Self'                        => $q[0]['dependabilitySelf'],

                        'Initiative Team'                           => $q[0]['initiativeTeam'],
                        'Initiative Self'                           => $q[0]['initiativeSelf'],

                        'Attendance & Punctuality Team'                => $q[0]['attendancePunctualityTeam'],
                        'Attendance & Punctuality Self'                => $q[0]['attendancePunctualityTeam'],

                        'Volume of Work Team'                         => $q[0]['volumeOfWorkTeam'],
                        'Volume of Work Self'                         => $q[0]['volumeOfWorkSelf'],

                        'Rigour Team'                               => $q[0]['rigourTeam'],
                        'Rigour Self'                               => $q[0]['rigourSelf'],

                        'Knowledge of the Job Team'                    => $q[0]['knowledgeOfTheJobTeam'],
                        'Knowledge of the Job Self'                    => $q[0]['knowledgeOfTheJobSelf'],

                        'Transparency Team'                         => $q[0]['transparencyTeam'],
                        'Transparency Self'                         => $q[0]['transparencySelf'],

                        'Decision Making/Problem Solving Team'         => $q[0]['decisionMakingproblemSolvingTeam'],
                        'Decision Making/Problem Solving Self'         => $q[0]['decisionMakingproblemSolvingSelf'],

                        'Teamwork Team'                             => $q[0]['teamworkTeam'],
                        'Teamwork Self'                             => $q[0]['teamworkSelf'],

                        'Coaching Team'                             => $q[0]['coachingTeam'],
                        'Coaching Self'                             => $q[0]['coachingSelf'],

                        'Communication Team'                        => $q[0]['communicationTeam'],
                        'Communication Self'                        => $q[0]['communicationSelf'],

                        'Overal feeling Team'                        => $q[0]['overalFeelingTeam'],
                        'Overal feeling Self'                        => $q[0]['overalFeelingSelf'],       
                        
                        'FEEDBACK1'                                 => $q[0]['feedback1'],
                        'FEEDBACK2'                                 => $q[0]['feedback2'],
                        'Overall Feedback'                          => $q[0]['overallFeedback'],
                        'Productivity 1'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 2'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 3'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 1'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 2'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 3'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 1' =>  '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 2' =>  '=Average(BFnewRow:BHnewRow)',
                        'Overall KPI' =>  '=IFERROR(IFS(AND($E$newRow = "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "TRAFFIC",$F$newRow <> "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow = "TRAFFIC",$F$newRow = "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($G$newRow:$P$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($Q$newRow:$AB$newRow)),0)',
                        'Row ID' =>  '=IF(ISBLANK(AnewRow),"",ROW())',                        
                    ];   
                }else if($q[0]['team'] == 'FRONTEND'){
                     $arrdata = [
                        'action'                                    => 'add_entry',
                        'QueryKey'                                  => $q[0]['querykey'],
                        'Timestamp'                                 => $datetime,
                        'Reviewer'                                  => $q[0]['reviewer'],
                        'Reviewee Name'                             => $q[0]['udname'],
                        'Team'                                      => $q[0]['team'],
                        'Role'                                      => $q[0]['role'],
                        
                        'Technical skills Team'                     => $q[0]['technicalSkillsTeam'],
                        'Technical skills Self'                     => $q[0]['technicalSkillsSelf'],

                        'Project contributions Team'                => $q[0]['projectContributionsTeam'],
                        'Project contributions Self'                => $q[0]['projectContributionsSelf'],

                        'Problem solving Team'                      => $q[0]['problemSolvingTeam'],
                        'Problem solving Self'                      => $q[0]['problemSolvingSelf'],

                        'Soft skills Team'                          => $q[0]['softSkillsTeam'],
                        'Soft skills Self'                          => $q[0]['softSkillsSelf'],

                        'Self-Development Team'                     => $q[0]['selfdevelopmentTeam'],
                        'Self-Development Self'                     => $q[0]['selfdevelopmentSelf'],

                        'FEEDBACK1'                                 => $q[0]['feedback1'],
                        'FEEDBACK2'                                 => $q[0]['feedback2'],
                        'Overall Feedback'                          => $q[0]['overallFeedback'],
                        'Productivity 1'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 2'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 3'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 1'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 2'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 3'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 1' =>  '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 2' =>  '=Average(BFnewRow:BHnewRow)',
                        'Overall KPI' =>  '=IFERROR(IFS(AND($E$newRow = "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "TRAFFIC",$F$newRow <> "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow = "TRAFFIC",$F$newRow = "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($G$newRow:$P$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($Q$newRow:$AB$newRow)),0)',
                        'Row ID' =>  '=IF(ISBLANK(AnewRow),"",ROW())',                        
                    ];   
                }else{
                    $arrdata = [
                        'action'                                    => 'add_entry',
                        'QueryKey'                                  => $q[0]['querykey'],
                        'Timestamp'                                 => $datetime,
                        'Reviewer'                                  => $q[0]['reviewer'],
                        'Reviewee Name'                             => $q[0]['udname'],
                        'Team'                                      => $q[0]['team'],
                        'Role'                                      => $q[0]['role'],
                        'Integrity Lead Score'                      => $q[0]['integrityLeadScore'],
                        'Integrity Member Score'                    => $q[0]['integrityMemberScore'],
                        'Communication Lead Score'                  => $q[0]['communicationLeadScore'],
                        'Communication Member Score'                => $q[0]['communicationMemberScore'],
                        'Work Standards Lead Score'                 => $q[0]['workStandardsLeadScore'],
                        'Work Standards Member Score'               => $q[0]['workStandardsMemberScore'],
                        'Teamwork Lead Score'                       => $q[0]['teamworkLeadScore'],
                        'Teamwork Member Score'                     => $q[0]['teamworkMemberScore'],
                        'Self-Development Lead Score'               => $q[0]['selfdevelopmentLeadScore'],
                        'Self-Development Member Score'             => $q[0]['selfdevelopmentMemberScore'],
                        'FEEDBACK1'                                 => $q[0]['feedback1'],
                        'FEEDBACK2'                                 => $q[0]['feedback2'],
                        'Overall Feedback'                          => $q[0]['overallFeedback'],
                        'Productivity 1'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 2'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Productivity 3'                            => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 1'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date2.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 2'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date2.'\' and Col1 < date \''.$date3.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'Schedule Adherence 3'                      => '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:AJ"), "Select Col36 where Col1 >= date \''.$date3.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 1' =>  '=IFERROR(AVERAGE(QUERY(IMPORTRANGE("'.$sheet_key[$getuser[0]['mp_user_team']].'","AT Tracker!A:R"), "Select Col18 where Col1 >= date \''.$date1.'\' and Col1 < date \''.$date4.'\' and Col2 = \''.$user_firstname.'\'")),0)',
                        'ACTUAL SCORE 2' =>  '=Average(BFnewRow:BHnewRow)',
                        'Overall KPI' =>  '=IFERROR(IFS(AND($E$newRow = "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($BV$newRow:$CE$newRow),AND($E$newRow = "TRAFFIC",$F$newRow <> "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow = "TRAFFIC",$F$newRow = "Team Leader"),AVERAGE($AC$newRow:$BB$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow <> "Team Leader"),AVERAGE($G$newRow:$P$newRow),AND($E$newRow <> "TRAFFIC",$E$newRow <> "FRONTEND",$F$newRow = "Team Leader"),AVERAGE($Q$newRow:$AB$newRow)),0)',
                        'Row ID' =>  '=IF(ISBLANK(AnewRow),"",ROW())',                        
                    ];
                }
                
            //$post_url = "https://script.google.com/macros/s/AKfycbzCgP9to6gFUzMiZn-arnljxRO55HKmCE9-Gc8cOwS-A6DQG2Y657sXkNveUEBzNQHj/exec";
            //$post_url = "https://script.google.com/macros/s/AKfycbxRix66lWm6UeUGaKM70aGSptO0Xe4BMzhQ3HIbiN29AldMmPYz4fR7002mdOqvgbuW/exec";

            $post_url = "https://script.google.com/macros/s/AKfycbxeEi28ZvyrJthpFQdwHF3IiiIbuKxHZqq9BxSr6HAbQ3XrfVR5iZFD4aLJqUH76fevMg/exec";
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

            return;

            
        }   