<?

function get_frontend_table($attr,$dataq = Null){
	//print_r($attr);
	//die();
	if(!isset($attr->undefined)){
		$userid = $attr['user'];
	}else{
		$userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;		
	}

  $useropts = get_field('mp_user_options','option',true);
  $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

	$reviewer = isset($attr->reviewer) ? $attr->reviewer : $getuser[0]["reports_to"]['display_name'];
	$revieweeName = isset($attr->revieweeName) ? $attr->revieweeName : $getuser[0]["mp_user"]["display_name"];
	$team = isset($attr->team) ? $attr->team : $getuser[0]["mp_user_team"];
	$role = isset($attr->role) ? $attr->role : $getuser[0]["mp_user_role"];
	$rowId = isset($attr->rowId) ? $attr->rowId : 0;


	$dateValue = isset($attr->querykey) ? strtotime(substr($attr->querykey,0,4) . '-10-13T16:00:00.000Z') : strtotime($attr['gyear'] . '-10-13T16:00:00.000Z');
	$quarterValue = isset($attr->querykey) ? substr($attr->querykey,5,2) : substr($attr['q'],5,2);

  $querykey = isset($attr->querykey) ? $attr->querykey : date("Y", $dateValue) . "-" . $quarterValue . " " .$getuser[0]["mp_user"]["display_name"];

	if(is_numeric($dataq[0]->productivity1)){
		$productivity1 = number_format((float)$dataq[0]->productivity1,2,'.','');
	}else{
		$productivity1 = isset($attr->productivity1) ? number_format((float)$attr->productivity1,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity2)){
		$productivity2 = number_format((float)$dataq[0]->productivity2,2,'.','');
	}else{
		$productivity2 = isset($attr->productivity2) ? number_format((float)$attr->productivity2,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity3)){
		$productivity3 = number_format((float)$dataq[0]->productivity3,2,'.','');
	}else{
		$productivity3 = isset($attr->productivity3) ? number_format((float)$attr->productivity3,2,'.','') : 0;
	}

	$tot_productivity = floor(($productivity1 + $productivity2 + $productivity3) / 3);
	$tot_productivity = number_format((float)$tot_productivity,2,'.','');

	if(is_numeric($dataq[0]->scheduleAdherence1)){
		$scheduleAdherence1 = round($dataq[0]->scheduleAdherence1);
	}else{
		$scheduleAdherence1 = isset($attr->scheduleAdherence1) ? number_format((float)$attr->scheduleAdherence1,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence2)){
		$scheduleAdherence2 = round($dataq[0]->scheduleAdherence2);
	}else{
		$scheduleAdherence2 = isset($attr->scheduleAdherence2) ? number_format((float)$attr->scheduleAdherence2,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence3)){
		$scheduleAdherence3 = round($dataq[0]->scheduleAdherence3);
	}else{
		$scheduleAdherence3 = isset($attr->scheduleAdherence3) ? number_format((float)$attr->scheduleAdherence3,2,'.','') : 0;	
	}

	$tot_scheduleAdherence = floor(($scheduleAdherence1 + $scheduleAdherence2 + $scheduleAdherence3) / 3);

	if(isset($attr->actualScore1)){
		$actualScore1  = isset($attr->actualScore1) ? number_format((float)$attr->actualScore1,2,'.','') : 0;	
	}else{
		$actualScore1 = number_format((float)$tot_productivity,2,'.','');

	}

	if(isset($attr->actualScore2)){
		$actualScore2  = isset($attr->actualScore2) ? number_format((float)$attr->actualScore2,2,'.','') : 0;	
	}else{
		$actualScore2 = number_format((float)$tot_scheduleAdherence,2,'.','');
	}

	switch (true) {
	  case ($actualScore2 <= 2.39):
	    $actualScore3 = 1;
	    break;
	  case ($actualScore2 > 2.39 && $actualScore2 <= 2.4 - 2.99):
	    $actualScore3 = 2;
	    break;
	  case ($actualScore2 > 2.99 && $actualScore2 <= 3.67):
	    $actualScore3 = 3;
	    break;
	  case ($actualScore2 > 3.67 && $actualScore2 <= 4.66):
	    $actualScore3 = 4;
	    break;
	  default:
	  	$actualScore3 = 5;
	}	

	$overallFeedback  = isset($attr->overallFeedback) ? $attr->overallFeedback : '-';
	$feedback1  = isset($attr->feedback1) ? $attr->feedback1 : '-';
	$feedback2  = isset($attr->feedback2) ? $attr->feedback2 : '-';

	$technicalSkillsTeam = isset($attr->technicalSkillsTeam) ? number_format((float)$attr->technicalSkillsTeam) : 0;
	$technicalSkillsSelf = isset($attr->technicalSkillsSelf) ? number_format((float)$attr->technicalSkillsSelf) : 0;

	if(isset($attr->technicalSkillsSelf)){
		$small_score = ($technicalSkillsTeam + $technicalSkillsSelf) / 2;
	}else{
		$small_score = 0;
	}

	$projectContributionsTeam = isset($attr->projectContributionsTeam) ? number_format((float)$attr->projectContributionsTeam) : 0;
	$projectContributionsSelf = isset($attr->projectContributionsSelf) ? number_format((float)$attr->projectContributionsSelf) : 0;

	if(isset($attr->projectContributionsTeam)){
		$small_score += ($projectContributionsTeam + $projectContributionsSelf) / 2;
	}else{
		$small_score = 0;
	}
	
	$problemSolvingTeam = isset($attr->problemSolvingTeam) ? number_format((float)$attr->problemSolvingTeam) : 0;
	$problemSolvingSelf = isset($attr->problemSolvingSelf) ? number_format((float)$attr->problemSolvingSelf) : 0;

	if(isset($attr->problemSolvingTeam)){
		$small_score += ($problemSolvingTeam + $problemSolvingSelf) / 2;
	}else{
		$small_score = 0;
	}	

	$softSkillsTeam = isset($attr->softSkillsTeam) ? number_format((float)$attr->softSkillsTeam) : 0;
	$softSkillsSelf = isset($attr->softSkillsSelf) ? number_format((float)$attr->softSkillsSelf) : 0;

	if(isset($attr->softSkillsTeam)){
		$small_score += ($softSkillsTeam + $softSkillsSelf) / 2;
	}else{
		$small_score = 0;
	}	


	$selfdevelopmentTeam = isset($attr->selfdevelopmentTeam) ? number_format((float)$attr->selfdevelopmentTeam) : 0;
	$selfdevelopmentSelf = isset($attr->selfdevelopmentSelf) ? number_format((float)$attr->selfdevelopmentSelf) : 0;

	if(isset($attr->selfdevelopmentTeam)){
		$small_score += ($selfdevelopmentTeam + $selfdevelopmentSelf) / 2;
		$small_score = $small_score / 5;		
	}else{
		$small_score = 0;
	}	

	switch(true){
		case($tot_productivity < 1):
			$productivity_kpi = 0;
		break;
		case($tot_productivity < 79):
			$productivity_kpi = 1;
		break;
		case($tot_productivity < 85):
			$productivity_kpi = 2;
		break;
		case($tot_productivity < 91):
			$productivity_kpi = 3;
		break;
		case($tot_productivity < 96):
			$productivity_kpi = 4;
		break;
		default:
			$productivity_kpi = 5;
	}
	$productivity_kpi = number_format((float)$productivity_kpi,2,'.','');

	$do_score = (number_format((float)round($actualScore2),2,'.','') + number_format((float)$productivity_kpi,2,'.','')) / 2;

	$total_kpi = ($small_score + $do_score) / 2;	

	switch ($quarterValue) {
	  case "Q1":
	  	$month1 = "JAN";
	  	$month2 = "FEB";
	    $month3 = "MAR";
	    break;
	  case "Q2":
	  	$month1 = "APR";
	  	$month2 = "MAY";
	    $month3 = "JUN";
	    break;
	  case "Q3":
   	  	$month1 = "JUL";
	  	$month2 = "AUG";
	    $month3 = "SEP";
	    break;
	  default:
   	  	$month1 = "OCT";
	  	$month2 = "NOV";
	    $month3 = "DEC";	    
	}
	ob_start();
	?>
<form id="corecomp-<?=date('Y',$dateValue) . "-" .$quarterValue?>" action="">
<input type="hidden" id="udname" name="udname" value="<?=$revieweeName?>">
<input type="hidden" id="row" name="row" value="<?=$rowId?>">
<input type="hidden" id="team" name="team" value="<?=$team?>">
<input type="hidden" id="querykey" name="querykey" value="<?=$querykey?>">
<input type="hidden" id="role" name="role" value="<?=$role?>">
<input type="hidden" id="reviewer" name="reviewer" value="<?=$reviewer?>">
<?php
$GLOBALS['m1'] = $month1;
$GLOBALS['m2'] = $month2;
$GLOBALS['m3'] = $month3;

$GLOBALS['monthOne'] = !empty(trim($attr->confirm1)) ? $attr->confirm1 : 'unchecked';
$GLOBALS['monthTwo'] = !empty(trim($attr->confirm2)) ? $attr->confirm2 : 'unchecked';
$GLOBALS['monthThree'] = !empty(trim($attr->confirm3)) ? $attr->confirm3 : 'unchecked';

$GLOBALS['yaerval'] = date("Y", $dateValue);
$GLOBALS['revieweeName'] = $revieweeName;

$GLOBALS['dateAcknowledgedone'] = !empty(trim($attr->dateAcknowledged1)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged1 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgetwo'] = !empty(trim($attr->dateAcknowledged2)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged2 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgethree'] = !empty(trim($attr->dateAcknowledged3)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged3 . ' + 8 hours')) : '';

echo do_shortcode('[elementor-template id="4314"]');
?>
<table class="individual-dashboard">
  <thead>
    <colgroup>
        <col style="width: 3%;"/>
        <col style="width: 15%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 13%;"/>
        <col style="width: 20%;"/>
        <col style="width: 7%;"/>
    </colgroup>
    <tr>
      <th scope="col" colspan="10" class="quater-heading"><?=$quarterValue?> KPI</th>
      <th scope="col" class="quarter-score"><strong><?=number_format((float)$total_kpi,2,'.','')?></strong></th>
    </tr>
    <tr>
      <th scope="col" colspan="2" rowspan="2">Objectives</th>
      <th scope="col" rowspan="2" width="5%"><?=$month1?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month2?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month3?></th>
      <th scope="col" colspan="2"><?=$quarterValue?> <?=date("Y", $dateValue)?></th>
      <th scope="col" colspan="3" rowspan="2">Feedback</th>
      <th scope="col" rowspan="2">Score</th>
    </tr>
     <tr>
      <th scope="col">Actual Score</th>
      <th scope="col">KPI</th>
    </tr>
  </thead>
  <tbody>
    <tr scope="col" class="heading-container">
      <td data-label="Development Objectives (50%)" colspan="11"><p><em>Development Objectives (50%)</em></p></td>
    </tr>
    <tr class="productivity">
      <td data-label="#"><strong>1</strong></td>
      <td data-label="Objectives">Productivity</td>
      <td data-label="<?=$month1?>"><?=$productivity1?></td>
      <td data-label="<?=$month2?>"><?=$productivity2?></td>
      <td data-label="<?=$month3?>"><?=$productivity3?></td>
      <td data-label="Actual Score"><?=$actualScore1?></td>
      <td data-label="KPI"><?=number_format($productivity_kpi)?></td>
      <td data-label="FEEDBACK1" colspan="3" class="feedback1 fields" rel="<?=$feedback1?>"><?=$feedback1?></td>
      <td data-label="Score" rowspan="2"><?=number_format((float)$do_score,2,'.','')?></td>
    </tr>
    <tr class="scheduleadherence">
      <td data-label="#"><strong>2</strong></td>
      <td data-label="Objectives">Schedule Adherence</td>
      <td data-label="<?=$month1?>"><?=$scheduleAdherence1?></td>
      <td data-label="<?=$month2?>"><?=$scheduleAdherence2?></td>
      <td data-label="<?=$month3?>"><?=$scheduleAdherence3?></td>
      <td data-label="Actual Score"><?=$actualScore2?></td>
      <td data-label="KPI"><?=number_format((float)floor($actualScore3),2,'.','')?></td>
      <td data-label="FEEDBACK2" colspan="3" class="feedback2 fields" rel="<?=$feedback2?>"><?=$feedback2?></td>
    </tr>
    <tr scope="col" class="heading-container">
      <td data-label="Core Competency" colspan="2"><strong>Core Competency</strong></td>
      <td data-label="Team Lead Score">Team Lead Score</td>
      <td data-label="Your Score">Your Score</td>
      <td data-label="Actual Score">Actual Score</td>
      <td data-label="Overall Feedback" colspan="5">Overall Feedback</td>
      <td data-label="Score">Score</td>
    </tr>
    <tr scope="col" class="technicalSkills">
      <td data-label="#" width="3%"><strong>1</strong></td>
      <td data-label="Core Competency">Technical Skills</td>
      <td data-label="Technical skills Lead Score" class="technicalSkillsTeam fields" data-type="number" rel="<?=$technicalSkillsTeam?>"><?=$technicalSkillsTeam?></td>
      <td data-label="Technical skills Member Score" class="technicalSkillsSelf fields" data-type="number" rel="<?=$technicalSkillsSelf?>"><?=$technicalSkillsSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($technicalSkillsTeam + $technicalSkillsSelf) / 2),2,'.','')?></td>
      <td data-label="Overall Feedback" rowspan="5" colspan="5" class="overallFeedback fields" rel="<?=$overallFeedback?>"><?=$overallFeedback?></td>
      <td data-label="Score" data-score rowspan="5"><?=number_format((float)$small_score,2,'.','')?></td>
    </tr>

    <tr scope="col" colspan="9" class="projectContributions">
      <td data-label="#" width="3%"><strong>2</strong></td>
      <td data-label="Core Competency">Project Contributions</td>
      <td data-label="Project Contributions Lead Score" class="projectContributionsTeam fields" data-type="number" rel="<?=$projectContributionsTeam?>"><?=$projectContributionsTeam?></td>
      <td data-label="Project Contributions Member Score" class="projectContributionsSelf fields" data-type="number" rel="<?=$projectContributionsSelf?>"><?=$projectContributionsSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($projectContributionsTeam + $projectContributionsSelf) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="problemSolving">
      <td data-label="#" width="3%"><strong>3</strong></td>
      <td data-label="Core Competency">Problem Solving</td>
      <td data-label="Problem solving Lead Score" class="problemSolvingTeam fields" data-type="number" rel="<?=$problemSolvingTeam?>"><?=$problemSolvingTeam?></td>
      <td data-label="Problem solving Member Score" class="problemSolvingSelf fields" data-type="number" rel="<?=$problemSolvingSelf?>"><?=$problemSolvingSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($problemSolvingTeam + $problemSolvingSelf) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="softSkills">
      <td data-label="#" width="3%"><strong>4</strong></td>
      <td data-label="Core Competency">Soft Skills</td>
      <td data-label="Soft skills Lead Score" class="softSkillsTeam fields" data-type="number" rel="<?=$softSkillsTeam?>"><?=$softSkillsTeam?></td>
      <td data-label="Soft skills Member Score" class="softSkillsSelf fields" data-type="number" rel="<?=$softSkillsSelf?>"><?=$softSkillsSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($softSkillsTeam + $softSkillsSelf) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="selfDevelopmentFrontend">
      <td data-label="#" width="3%"><strong>5</strong></td>
      <td data-label="Core Competency">Self-development</td>
      <td data-label="Self-Development Lead Score" class="selfdevelopmentTeam fields" data-type="number" rel="<?=$selfdevelopmentTeam?>"><?=$selfdevelopmentTeam?></td>
      <td data-label="Self-Development Member Score" class="selfdevelopmentSelf fields" data-type="number" rel="<?=$selfdevelopmentSelf?>"><?=$selfdevelopmentSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($selfdevelopmentTeam + $selfdevelopmentSelf) / 2),2,'.','')?></td>
    </tr>
  </tbody>
</table>
<?php
echo do_shortcode('[elementor-template id="4313"]'); 
?>
</form>
	<?php
	return ob_get_clean();
}

function get_traffic_table($attr,$dataq = Null){

	$newarry = $dataq->data;
	if(!isset($attr->undefined)){
		$userid = $attr['user'];
	}else{
		$userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;		
	}

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

	$reviewer = isset($attr->reviewer) ? $attr->reviewer : $getuser[0]["reports_to"]['display_name'];
	$revieweeName = isset($attr->revieweeName) ? $attr->revieweeName : $getuser[0]["mp_user"]["display_name"];
	$team = isset($attr->team) ? $attr->team : $getuser[0]["mp_user_team"];
	$role = isset($attr->role) ? $attr->role : $getuser[0]["mp_user_role"];
	$rowId = isset($attr->rowId) ? $attr->rowId : 0;

	$dateValue = isset($attr->querykey) ? strtotime(substr($attr->querykey,0,4) . '-10-13T16:00:00.000Z') : strtotime($attr['gyear'] . '-10-13T16:00:00.000Z');
	$quarterValue = isset($attr->querykey) ? substr($attr->querykey,5,2) : substr($attr['q'],5,2);

  $querykey = isset($attr->querykey) ? $attr->querykey : date("Y", $dateValue) . "-" . $quarterValue . " " .$getuser[0]["mp_user"]["display_name"];

	if(is_numeric($dataq[0]->productivity1)){
		$productivity1 = number_format((float)$dataq[0]->productivity1,2,'.','');
	}else{
		$productivity1 = isset($attr->productivity1) ? number_format((float)$attr->productivity1,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity2)){
		$productivity2 = number_format((float)$dataq[0]->productivity2,2,'.','');
	}else{
		$productivity2 = isset($attr->productivity2) ? number_format((float)$attr->productivity2,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity3)){
		$productivity3 = number_format((float)$dataq[0]->productivity3,2,'.','');
	}else{
		$productivity3 = isset($attr->productivity3) ? number_format((float)$attr->productivity3,2,'.','') : 0;
	}

	$tot_productivity = floor(($productivity1 + $productivity2 + $productivity3) / 3);
	$tot_productivity = number_format((float)$tot_productivity,2,'.','');

	if(is_numeric($dataq[0]->scheduleAdherence1)){
		$scheduleAdherence1 = round($dataq[0]->scheduleAdherence1);
	}else{
		$scheduleAdherence1 = isset($attr->scheduleAdherence1) ? number_format((float)$attr->scheduleAdherence1,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence2)){
		$scheduleAdherence2 = round($dataq[0]->scheduleAdherence2);
	}else{
		$scheduleAdherence2 = isset($attr->scheduleAdherence2) ? number_format((float)$attr->scheduleAdherence2,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence3)){
		$scheduleAdherence3 = round($dataq[0]->scheduleAdherence3);
	}else{
		$scheduleAdherence3 = isset($attr->scheduleAdherence3) ? number_format((float)$attr->scheduleAdherence3,2,'.','') : 0;	
	}

	$tot_scheduleAdherence = floor(($scheduleAdherence1 + $scheduleAdherence2 + $scheduleAdherence3) / 3);

	if(isset($attr->actualScore1)){
		$actualScore1  = isset($attr->actualScore1) ? number_format((float)$attr->actualScore1,2,'.','') : 0;	
	}else{
		$actualScore1 = number_format((float)$tot_productivity,2,'.','');
		
	}

	if(isset($attr->actualScore2)){
		$actualScore2  = isset($attr->actualScore2) ? number_format((float)$attr->actualScore2,2,'.','') : 0;	
	}else{
		$actualScore2 = number_format((float)$tot_scheduleAdherence,2,'.','');
	}

	switch (true) {
	  case ($actualScore2 <= 2.39):
	    $actualScore3 = 1;
	    break;
	  case ($actualScore2 > 2.39 && $actualScore2 <= 2.4 - 2.99):
	    $actualScore3 = 2;
	    break;
	  case ($actualScore2 > 2.99 && $actualScore2 <= 3.67):
	    $actualScore3 = 3;
	    break;
	  case ($actualScore2 > 3.67 && $actualScore2 <= 4.66):
	    $actualScore3 = 4;
	    break;
	  default:
	  	$actualScore3 = 5;
	}

	$overallFeedback  = isset($attr->overallFeedback) ? $attr->overallFeedback : '-';
	$feedback1  = isset($attr->feedback1) ? $attr->feedback1 : '-';
	$feedback2  = isset($attr->feedback2) ? $attr->feedback2 : '-';

	

   $administrationTeam = isset($attr->administrationTeam) ? number_format((float)$attr->administrationTeam) : 0;
	 $administrationSelf = isset($attr->administrationSelf) ? number_format((float)$attr->administrationSelf) : 0;
	 $small_score = ($administrationSelf + $administrationTeam) / 2;

	 $dependabilityTeam = isset($attr->dependabilityTeam) ? number_format((float)$attr->dependabilityTeam) : 0;
	 $dependabilitySelf = isset($attr->dependabilitySelf) ? number_format((float)$attr->dependabilitySelf) : 0;
	 $small_score += ($dependabilityTeam + $dependabilitySelf) / 2;

	 $initiativeTeam = isset($attr->initiativeTeam) ? number_format((float)$attr->initiativeTeam) : 0;
	 $initiativeSelf = isset($attr->initiativeSelf) ? number_format((float)$attr->initiativeSelf) : 0;

	 $small_score += ($initiativeTeam + $initiativeSelf) / 2;

	 $attendancePunctualityTeam = isset($attr->attendancePunctualityTeam) ? number_format((float)$attr->attendancePunctualityTeam) : 0;
	 $attendancePunctualitySelf = isset($attr->attendancePunctualitySelf) ? number_format((float)$attr->attendancePunctualitySelf) : 0;
		$small_score += ($attendancePunctualityTeam + $attendancePunctualitySelf) / 2;
	 $volumeOfWorkTeam = isset($attr->volumeOfWorkTeam) ? number_format((float)$attr->volumeOfWorkTeam) : 0;
	 $volumeOfWorkSelf = isset($attr->volumeOfWorkSelf) ? number_format((float)$attr->volumeOfWorkSelf) : 0;
$small_score += ($volumeOfWorkTeam + $volumeOfWorkTeam) / 2;
	 $rigourTeam = isset($attr->rigourTeam) ? number_format((float)$attr->rigourTeam) : 0;
	 $rigourSelf = isset($attr->rigourSelf) ? number_format((float)$attr->rigourSelf) : 0;
$small_score += ($rigourTeam + $rigourSelf) / 2;
	 $knowledgeOfTheJobTeam = isset($attr->knowledgeOfTheJobTeam) ? number_format((float)$attr->knowledgeOfTheJobTeam) : 0;
	 $knowledgeOfTheJobSelf = isset($attr->knowledgeOfTheJobSelf) ? number_format((float)$attr->knowledgeOfTheJobSelf) : 0;
$small_score += ($knowledgeOfTheJobTeam + $knowledgeOfTheJobSelf) / 2;
	 $transparencyTeam = isset($attr->transparencyTeam) ? number_format((float)$attr->transparencyTeam) : 0;
	 $transparencySelf = isset($attr->transparencySelf) ? number_format((float)$attr->transparencySelf) : 0;
$small_score += ($transparencyTeam + $transparencySelf) / 2;
	 $decisionMakingproblemSolvingTeam = isset($attr->decisionMakingproblemSolvingTeam) ? number_format((float)$attr->decisionMakingproblemSolvingTeam) : 0;
	 $decisionMakingproblemSolvingSelf = isset($attr->decisionMakingproblemSolvingSelf) ? number_format((float)$attr->decisionMakingproblemSolvingSelf) : 0;
$small_score += ($decisionMakingproblemSolvingTeam + $decisionMakingproblemSolvingSelf) / 2;
	 $teamworkTeam = isset($attr->teamworkTeam) ? number_format((float)$attr->teamworkTeam) : 0;
	 $teamworkSelf = isset($attr->teamworkSelf) ? number_format((float)$attr->teamworkSelf) : 0;
$small_score += ($teamworkTeam + $teamworkSelf) / 2;
	 $coachingTeam = isset($attr->coachingTeam) ? number_format((float)$attr->coachingTeam) : 0;
	 $coachingSelf = isset($attr->coachingSelf) ? number_format((float)$attr->coachingSelf) : 0;
$small_score += ($coachingTeam + $coachingSelf) / 2;
	 $communicationTeam = isset($attr->communicationTeam) ? number_format((float)$attr->communicationTeam) : 0;
	 $communicationSelf = isset($attr->communicationSelf) ? number_format((float)$attr->communicationSelf) : 0;
$small_score += ($communicationTeam + $communicationSelf) / 2;
	 $overalFeelingTeam = isset($attr->overalFeelingTeam) ? number_format((float)$attr->overalFeelingTeam) : 0;
	 $overalFeelingSelf = isset($attr->overalFeelingSelf) ? number_format((float)$attr->overalFeelingSelf) : 0;
$small_score += ($overalFeelingTeam + $overalFeelingSelf) / 2;
	//$small_score += ($communicationManagementLeadScore + $communicationManagementMemberScore) / 2;

	//$innovationLeadScore = isset($attr->innovationLeadScore) ? number_format((float)$attr->innovationLeadScore) : 0;
	//$innovationMemberScore = isset($attr->innovationMemberScore) ? number_format((float)$attr->innovationMemberScore) : 0;

	//$small_score += ($innovationLeadScore + $innovationMemberScore) / 2;

	//$conflictManagementLeadScore = isset($attr->conflictManagementLeadScore) ? number_format((float)$attr->conflictManagementLeadScore) : 0;
	///$conflictManagementMemberscore = isset($attr->conflictManagementMemberscore) ? number_format((float)$attr->conflictManagementMemberscore) : 0;

	//$small_score += ($conflictManagementLeadScore + $conflictManagementMemberscore) / 2;

	//$changeManagementLeadScore = isset($attr->changeManagementLeadScore) ? number_format((float)$attr->changeManagementLeadScore) : 0;
	//$changeManagementMemberScore = isset($attr->changeManagementMemberScore) ? number_format((float)$attr->changeManagementMemberScore) : 0;

	//$small_score += ($changeManagementLeadScore + $changeManagementMemberScore) / 2;

	//$learningDevelopmentLeadScore = isset($attr->learningDevelopmentLeadScore) ? number_format((float)$attr->learningDevelopmentLeadScore) : 0;
	//$learningDevelopmentMemberScore = isset($attr->learningDevelopmentMemberScore) ? number_format((float)$attr->learningDevelopmentMemberScore) : 0;

	//$small_score += ($learningDevelopmentLeadScore + $learningDevelopmentMemberScore) / 2;

	$small_score = $small_score / 13;

	switch(true){
		case($tot_productivity < 1):
			$productivity_kpi = 0;
		break;
		case($tot_productivity < 79):
			$productivity_kpi = 1;
		break;
		case($tot_productivity < 85):
			$productivity_kpi = 2;
		break;
		case($tot_productivity < 91):
			$productivity_kpi = 3;
		break;
		case($tot_productivity < 96):
			$productivity_kpi = 4;
		break;
		default:
			$productivity_kpi = 5;
	}
	$productivity_kpi = number_format((float)$productivity_kpi,2,'.','');
	$do_score = (number_format((float)round($actualScore2),2,'.','') + number_format((float)$productivity_kpi,2,'.','')) / 2;

	$total_kpi = ($small_score + $do_score) / 2;


	switch ($quarterValue) {
	  case "Q1":
	  	$month1 = "JAN";
	  	$month2 = "FEB";
	    $month3 = "MAR";
	    break;
	  case "Q2":
	  	$month1 = "APR";
	  	$month2 = "MAY";
	    $month3 = "JUN";
	    break;
	  case "Q3":
   	  	$month1 = "JUL";
	  	$month2 = "AUG";
	    $month3 = "SEP";
	    break;
	  default:
   	  	$month1 = "OCT";
	  	$month2 = "NOV";
	    $month3 = "DEC";	    
	}

	ob_start();
	?>
<form id="corecomp-<?=date('Y',$dateValue) . "-" .$quarterValue?>" action="">
<input type="hidden" id="udname" name="udname" value="<?=$revieweeName?>">
<input type="hidden" id="row" name="row" value="<?=$rowId?>">
<input type="hidden" id="team" name="team" value="<?=$team?>">
<input type="hidden" id="querykey" name="querykey" value="<?=$querykey?>">
<input type="hidden" id="role" name="role" value="<?=$role?>">
<input type="hidden" id="reviewer" name="reviewer" value="<?=$reviewer?>">
<?php
$GLOBALS['m1'] = $month1;
$GLOBALS['m2'] = $month2;
$GLOBALS['m3'] = $month3;

$GLOBALS['monthOne'] = !empty(trim($attr->confirm1)) ? $attr->confirm1 : 'unchecked';
$GLOBALS['monthTwo'] = !empty(trim($attr->confirm2)) ? $attr->confirm2 : 'unchecked';
$GLOBALS['monthThree'] = !empty(trim($attr->confirm3)) ? $attr->confirm3 : 'unchecked';

$GLOBALS['yaerval'] = date("Y", $dateValue);
$GLOBALS['revieweeName'] = $revieweeName;
$GLOBALS['dateAcknowledgedone'] = !empty(trim($attr->dateAcknowledged1)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged1 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgetwo'] = !empty(trim($attr->dateAcknowledged2)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged2 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgethree'] = !empty(trim($attr->dateAcknowledged3)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged3 . ' + 8 hours')) : '';

echo do_shortcode('[elementor-template id="4314"]');
?>
<table class="individual-dashboard">
  <thead>
    <colgroup>
        <col style="width: 3%;"/>
        <col style="width: 15%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 13%;"/>
        <col style="width: 20%;"/>
        <col style="width: 7%;"/>
    </colgroup>
    <tr>
      <th scope="col" colspan="10" class="quater-heading"><?=$quarterValue?> KPI</th>
      <th scope="col" class="quarter-score"><strong><?=number_format((float)$total_kpi,2,'.','')?></strong></th>
    </tr>
    <tr>
      <th scope="col" colspan="2" rowspan="2">Objectives</th>
      <th scope="col" rowspan="2" width="5%"><?=$month1?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month2?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month3?></th>
      <th scope="col" colspan="2"><?=$quarterValue?> <?=date("Y", $dateValue)?></th>
      <th scope="col" colspan="3" rowspan="2">Feedback</th>
      <th scope="col" rowspan="2">Score</th>
    </tr>
     <tr>
      <th scope="col">Actual Score</th>
      <th scope="col">KPI</th>
    </tr>
  </thead>
  <tbody>
    <tr scope="col" class="heading-container">
      <td data-label="Development Objectives (50%)" colspan="11"><p><em>Development Objectives (50%)</em></p></td>
    </tr>
    <tr class="productivity">
      <td data-label="#"><strong>1</strong></td>
      <td data-label="Objectives">Productivity</td>
      <td data-label="<?=$month1?>"><?=$productivity1?></td>
      <td data-label="<?=$month2?>"><?=$productivity2?></td>
      <td data-label="<?=$month3?>"><?=$productivity3?></td>
      <td data-label="ACTUAL SCORE 1"><?=$actualScore1?></td>
      <td data-label="KPI"><?=number_format($productivity_kpi)?></td>
      <td data-label="FEEDBACK1" colspan="3" class="feedback1 fields" name="FEEDBACK1" rel="<?=$feedback1?>"><?=$feedback1?></td>
      <td data-label="Score" rowspan="2"><?=number_format((float)$do_score,2,'.','')?></td>
    </tr>
    <tr class="scheduleadherence">
      <td data-label="#"><strong>2</strong></td>
      <td data-label="Objectives">Schedule Adherence</td>
      <td data-label="<?=$month1?>"><?=$scheduleAdherence1?></td>
      <td data-label="<?=$month2?>"><?=$scheduleAdherence2?></td>
      <td data-label="<?=$month3?>"><?=$scheduleAdherence3?></td>
      <td data-label="ACTUAL SCORE 2"><?=$actualScore2?></td>
      <td data-label="KPI"><?=number_format((float)floor($actualScore3),2,'.','')?></td>
      <td data-label="FEEDBACK2" colspan="3"  class="feedback2 fields" rel="<?=$feedback2?>"><?=$feedback2?></td>
    </tr>
    <tr scope="col" class="heading-container">
      <td data-label="Performance Factors" colspan="2"><strong>Core Competency</strong></td>
      <td data-label="Team Lead Score">Team Lead Score</td>
      <td data-label="Your Score">Your Score</td>
      <td data-label="Actual Score">Actual Score</td>
      <td data-label="Overall Feedback" colspan="5">Overall Feedback</td>
      <td data-label="Score">Score</td>
    </tr>
    <tr scope="col" class="teamCulture SelfManagement">
      <td data-label="Self Management" colspan="5">Self Management</td>
      <td data-label="Overall Feedback" rowspan="18" colspan="5" class="overallFeedback fields" rel="<?=$overallFeedback?>"><?=$overallFeedback?></td>
      <td data-label="Score" data-score rowspan="18"><?=number_format((float)$small_score,2,'.','')?></td>
    </tr>
		<tr scope="col" colspan="9" class="administration">
      <td data-label="#" width="3%"><strong>1</strong></td>
      <td data-label="Administration">Administration</td>
      <td data-label="Administration Lead Score" class="administrationTeam fields" data-type="number" rel="<?=$administrationTeam?>"><?=$administrationTeam?></td>
      <td data-label="Administration Member Score" class="administrationSelf fields" data-type="number" rel="<?=$administrationSelf?>"><?=$administrationSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($administrationTeam + $administrationSelf) / 2),2,'.','')?></td>
    </tr>
    <tr scope="col" colspan="9" class="dependability">
      <td data-label="#" width="3%"><strong>2</strong></td>
      <td data-label="Dependability">Dependability</td>
      <td data-label="Communication Management Lead Score" class="dependabilityTeam fields" data-type="number" rel="<?=$dependabilityTeam?>"><?=$dependabilityTeam?></td>
      <td data-label="Dependability Management Member Score" class="dependabilitySelf fields" data-type="number" rel="<?=$dependabilitySelf?>"><?=$dependabilitySelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($dependabilityTeam + $dependabilitySelf) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="initiative">
      <td data-label="#" width="3%"><strong>3</strong></td>
      <td data-label="Initiative">Initiative</td>
      <td data-label="Initiative Lead Score" class="initiativeTeam fields" data-type="number" rel="<?=$initiativeTeam?>"><?=$initiativeTeam?></td>
      <td data-label="Initiative Member Score" class="initiativeSelf fields" data-type="number" rel="<?=$initiativeSelf?>"><?=$initiativeSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($initiativeTeam + $initiativeSelf) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="attendancePunctuality">
      <td data-label="#" width="3%"><strong>4</strong></td>
      <td data-label="Attendance Punctuality">Attendance Punctuality</td>
      <td data-label="Attendance Punctuality Lead Score" class="attendancePunctualityTeam fields" data-type="number" rel="<?=$attendancePunctualityTeam?>"><?=$attendancePunctualityTeam?></td>
      <td data-label="Attendance Punctuality MemberScore" class="attendancePunctualitySelf fields" data-type="number" rel="<?=$attendancePunctualitySelf?>"><?=$attendancePunctualitySelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($attendancePunctualityTeam + $attendancePunctualitySelf) / 2),2,'.','')?></td>
    </tr>
    <tr scope="col" class="teamCulture Results">
      <td data-label="Results" colspan="5">Results</td>
    </tr>
    <tr scope="col" class="volumeOfWork">
      <td data-label="#" width="3%"><strong>1</strong></td>
      <td data-label="Volume Of Work">Volume Of Work</td>
      <td data-label="Volume Of Work Lead Score" class="volumeOfWorkTeam fields" data-type="number" rel="<?=$volumeOfWorkTeam?>"><?=$volumeOfWorkTeam?></td>
      <td data-label="Volume Of Work Member Score" class="volumeOfWorkSelf fields" data-type="number" rel="<?=$volumeOfWorkSelf?>"><?=$volumeOfWorkSelf?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($volumeOfWorkTeam + $volumeOfWorkSelf) / 2),2,'.','')?></td>
    </tr>

	    <tr scope="col" class="rigour">
	      <td data-label="#" width="3%"><strong>2</strong></td>
	      <td data-label="Rigour">Rigour</td>
	      <td data-label="Rigour Lead Score" class="rigourTeam fields" data-type="number" rel="<?=$rigourTeam?>"><?=$rigourTeam?></td>
	      <td data-label="Rigour Member Score" class="rigourSelf fields" data-type="number" rel="<?=$rigourSelf?>"><?=$rigourSelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($rigourTeam + $rigourSelf) / 2),2,'.','')?></td>
	    </tr>
    <tr scope="col" class="teamCulture Thought">
      <td data-label="Thought" colspan="5">Thought</td>
    </tr>

	    <tr scope="col" class="knowledgeOfTheJob">
	      <td data-label="#" width="3%"><strong>1</strong></td>
	      <td data-label="Knowledge Of The Job">Knowledge Of The Job</td>
	      <td data-label="knowledgeOfTheJobTeam Lead Score" class="knowledgeOfTheJobTeam fields" data-type="number" rel="<?=$knowledgeOfTheJobTeam?>"><?=$knowledgeOfTheJobTeam?></td>
	      <td data-label="knowledgeOfTheJobSelf Member Score" class="knowledgeOfTheJobSelf fields" data-type="number" rel="<?=$knowledgeOfTheJobSelf?>"><?=$knowledgeOfTheJobSelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($knowledgeOfTheJobTeam + $knowledgeOfTheJobSelf) / 2),2,'.','')?></td>
	    </tr>
	     <tr scope="col" class="transparency">
	      <td data-label="#" width="3%"><strong>2</strong></td>
	      <td data-label="Transparency">Transparency</td>
	      <td data-label="Transparency Lead Score" class="transparencyTeam fields" data-type="number" rel="<?=$transparencyTeam?>"><?=$transparencyTeam?></td>
	      <td data-label="Transparency Member Score" class="transparencySelf fields" data-type="number" rel="<?=$transparencySelf?>"><?=$transparencySelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($transparencyTeam + $transparencySelf) / 2),2,'.','')?></td>
	    <tr scope="col" class="decisionMakingproblemSolving">
	      <td data-label="#" width="3%"><strong>3</strong></td>
	      <td data-label="Decision Making Problem Solving">Decision Making Problem Solving</td>
	      <td data-label="Decision Making Problem Solving Lead Score" class="decisionMakingproblemSolvingTeam fields" data-type="number" rel="<?=$decisionMakingproblemSolvingTeam?>"><?=$decisionMakingproblemSolvingTeam?></td>
	      <td data-label="Decision Making Problem Solving Member Score" class="decisionMakingproblemSolvingSelf fields" data-type="number" rel="<?=$decisionMakingproblemSolvingSelf?>"><?=$decisionMakingproblemSolvingSelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($decisionMakingproblemSolvingTeam + $decisionMakingproblemSolvingSelf) / 2),2,'.','')?></td>  
	    </tr>

	  <tr scope="col" class="teamCulture People">
      <td data-label="People" colspan="5">People</td>
    </tr>

	    <tr scope="col" class="trafficteamwork">
	      <td data-label="#" width="3%"><strong>1</strong></td>
	      <td data-label="Teamwork">Teamwork</td>
	      <td data-label="Teamwork Lead Score" class="teamworkTeam fields" data-type="number" rel="<?=$teamworkTeam?>"><?=$teamworkTeam?></td>
	      <td data-label="Teamwork Member Score" class="teamworkSelf fields" data-type="number" rel="<?=$teamworkSelf?>"><?=$teamworkSelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($teamworkTeam + $teamworkSelf) / 2),2,'.','')?></td>
	    </tr>
	     <tr scope="col" class="coaching">
	      <td data-label="#" width="3%"><strong>2</strong></td>
	      <td data-label="Coaching">Coaching</td>
	      <td data-label="Coaching Lead Score" class="coachingTeam fields" data-type="number" rel="<?=$coachingTeam?>"><?=$coachingTeam?></td>
	      <td data-label="Coaching Member Score" class="coachingSelf fields" data-type="number" rel="<?=$coachingSelf?>"><?=$coachingSelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($coachingTeam + $coachingSelf) / 2),2,'.','')?></td>
	    <tr scope="col" class="trafficcommunication">
	      <td data-label="#" width="3%"><strong>3</strong></td>
	      <td data-label="Communication">Communication</td>
	      <td data-label="Communication Lead Score" class="communicationTeam fields" data-type="number" rel="<?=$communicationTeam?>"><?=$communicationTeam?></td>
	      <td data-label="Communication Member Score" class="communicationSelf fields" data-type="number" rel="<?=$communicationSelf?>"><?=$communicationSelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($communicationTeam + $communicationSelf) / 2),2,'.','')?></td>  
	    </tr>
	   <tr scope="col" class="teamCulture OveralMarking">
      <td data-label="Overal Marking" colspan="5">Overal Marking</td>
    </tr>

	    <tr scope="col" class="overalFeeling">
	      <td data-label="#" width="3%"><strong>1</strong></td>
	      <td data-label="Overal Feeling">Overal Feeling</td>
	      <td data-label="Overal Feeling Lead Score" class="overalFeelingTeam fields" data-type="number" rel="<?=$overalFeelingTeam?>"><?=$overalFeelingTeam?></td>
	      <td data-label="Overal Feeling Member Score" class="overalFeelingSelf fields" data-type="number" rel="<?=$overalFeelingSelf?>"><?=$overalFeelingSelf?></td>
	      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($overalFeelingTeam + $overalFeelingSelf) / 2),2,'.','')?></td>
	    </tr> 	    	    
  </tbody>
</table>
<?php
echo do_shortcode('[elementor-template id="4313"]'); 
?>
</form>
	<?php
	return ob_get_clean();
}

function get_teamlead_table($attr,$dataq = Null){

	$newarry = $dataq->data;
	if(!isset($attr->undefined)){
		$userid = $attr['user'];
	}else{
		$userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;		
	}

    $useropts = get_field('mp_user_options','option',true);
    $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

	$reviewer = isset($attr->reviewer) ? $attr->reviewer : $getuser[0]["reports_to"]['display_name'];
	$revieweeName = isset($attr->revieweeName) ? $attr->revieweeName : $getuser[0]["mp_user"]["display_name"];
	$team = isset($attr->team) ? $attr->team : $getuser[0]["mp_user_team"];
	$role = isset($attr->role) ? $attr->role : $getuser[0]["mp_user_role"];
	$rowId = isset($attr->rowId) ? $attr->rowId : 0;

	$dateValue = isset($attr->querykey) ? strtotime(substr($attr->querykey,0,4) . '-10-13T16:00:00.000Z') : strtotime($attr['gyear'] . '-10-13T16:00:00.000Z');
	$quarterValue = isset($attr->querykey) ? substr($attr->querykey,5,2) : substr($attr['q'],5,2);

  $querykey = isset($attr->querykey) ? $attr->querykey : date("Y", $dateValue) . "-" . $quarterValue . " " .$getuser[0]["mp_user"]["display_name"];

	if(is_numeric($dataq[0]->productivity1)){
		$productivity1 = number_format((float)$dataq[0]->productivity1,2,'.','');
	}else{
		$productivity1 = isset($attr->productivity1) ? number_format((float)$attr->productivity1,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity2)){
		$productivity2 = number_format((float)$dataq[0]->productivity2,2,'.','');
	}else{
		$productivity2 = isset($attr->productivity2) ? number_format((float)$attr->productivity2,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity3)){
		$productivity3 = number_format((float)$dataq[0]->productivity3,2,'.','');
	}else{
		$productivity3 = isset($attr->productivity3) ? number_format((float)$attr->productivity3,2,'.','') : 0;
	}

	$tot_productivity = floor(($productivity1 + $productivity2 + $productivity3) / 3);
	$tot_productivity = number_format((float)$tot_productivity,2,'.','');

	if(is_numeric($dataq[0]->scheduleAdherence1)){
		$scheduleAdherence1 = round($dataq[0]->scheduleAdherence1);
	}else{
		$scheduleAdherence1 = isset($attr->scheduleAdherence1) ? number_format((float)$attr->scheduleAdherence1,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence2)){
		$scheduleAdherence2 = round($dataq[0]->scheduleAdherence2);
	}else{
		$scheduleAdherence2 = isset($attr->scheduleAdherence2) ? number_format((float)$attr->scheduleAdherence2,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence3)){
		$scheduleAdherence3 = round($dataq[0]->scheduleAdherence3);
	}else{
		$scheduleAdherence3 = isset($attr->scheduleAdherence3) ? number_format((float)$attr->scheduleAdherence3,2,'.','') : 0;	
	}

	$tot_scheduleAdherence = floor(($scheduleAdherence1 + $scheduleAdherence2 + $scheduleAdherence3) / 3);

	if(isset($attr->actualScore1)){
		$actualScore1  = isset($attr->actualScore1) ? number_format((float)$attr->actualScore1,2,'.','') : 0;	
	}else{
		$actualScore1 = number_format((float)$tot_productivity,2,'.','');
		
	}

	if(isset($attr->actualScore2)){
		$actualScore2  = isset($attr->actualScore2) ? number_format((float)$attr->actualScore2,2,'.','') : 0;	
	}else{
		$actualScore2 = number_format((float)$tot_scheduleAdherence,2,'.','');
	}

	switch (true) {
	  case ($actualScore2 <= 2.39):
	    $actualScore3 = 1;
	    break;
	  case ($actualScore2 > 2.39 && $actualScore2 <= 2.4 - 2.99):
	    $actualScore3 = 2;
	    break;
	  case ($actualScore2 > 2.99 && $actualScore2 <= 3.67):
	    $actualScore3 = 3;
	    break;
	  case ($actualScore2 > 3.67 && $actualScore2 <= 4.66):
	    $actualScore3 = 4;
	    break;
	  default:
	  	$actualScore3 = 5;
	}

	$overallFeedback  = isset($attr->overallFeedback) ? $attr->overallFeedback : '-';
	$feedback1  = isset($attr->feedback1) ? $attr->feedback1 : '-';
	$feedback2  = isset($attr->feedback2) ? $attr->feedback2 : '-';

	$teamCultureLeadScore = (isset($attr->teamCultureLeadScore) || $attr->teamCultureLeadScore != "") ? number_format((float)$attr->teamCultureLeadScore) : 0;
	$teamCultureMemberScore = (isset($attr->teamCultureMemberScore) || $attr->teamCultureMemberScore != "") ? number_format((float)$attr->teamCultureMemberScore) : 0;

	$small_score = ($teamCultureLeadScore + $teamCultureMemberScore) / 2;

	$communicationManagementLeadScore = isset($attr->communicationManagementLeadScore) ? number_format((float)$attr->communicationManagementLeadScore) : 0;
	$communicationManagementMemberScore = isset($attr->communicationManagementMemberScore) ? number_format((float)$attr->communicationManagementMemberScore) : 0;

	$small_score += ($communicationManagementLeadScore + $communicationManagementMemberScore) / 2;

	$innovationLeadScore = isset($attr->innovationLeadScore) ? number_format((float)$attr->innovationLeadScore) : 0;
	$innovationMemberScore = isset($attr->innovationMemberScore) ? number_format((float)$attr->innovationMemberScore) : 0;

	$small_score += ($innovationLeadScore + $innovationMemberScore) / 2;

	$conflictManagementLeadScore = isset($attr->conflictManagementLeadScore) ? number_format((float)$attr->conflictManagementLeadScore) : 0;
	$conflictManagementMemberscore = isset($attr->conflictManagementMemberscore) ? number_format((float)$attr->conflictManagementMemberscore) : 0;

	$small_score += ($conflictManagementLeadScore + $conflictManagementMemberscore) / 2;

	$changeManagementLeadScore = isset($attr->changeManagementLeadScore) ? number_format((float)$attr->changeManagementLeadScore) : 0;
	$changeManagementMemberScore = isset($attr->changeManagementMemberScore) ? number_format((float)$attr->changeManagementMemberScore) : 0;

	$small_score += ($changeManagementLeadScore + $changeManagementMemberScore) / 2;

	$learningDevelopmentLeadScore = isset($attr->learningDevelopmentLeadScore) ? number_format((float)$attr->learningDevelopmentLeadScore) : 0;
	$learningDevelopmentMemberScore = isset($attr->learningDevelopmentMemberScore) ? number_format((float)$attr->learningDevelopmentMemberScore) : 0;

	$small_score += ($learningDevelopmentLeadScore + $learningDevelopmentMemberScore) / 2;

	$small_score = $small_score / 6;

	switch(true){
		case($tot_productivity < 1):
			$productivity_kpi = 0;
		break;
		case($tot_productivity < 79):
			$productivity_kpi = 1;
		break;
		case($tot_productivity < 85):
			$productivity_kpi = 2;
		break;
		case($tot_productivity < 91):
			$productivity_kpi = 3;
		break;
		case($tot_productivity < 96):
			$productivity_kpi = 4;
		break;
		default:
			$productivity_kpi = 5;
	}
	$productivity_kpi = number_format((float)$productivity_kpi,2,'.','');
	$do_score = (number_format((float)round($actualScore2),2,'.','') + number_format((float)$productivity_kpi,2,'.','')) / 2;

	$total_kpi = ($small_score + $do_score) / 2;


	switch ($quarterValue) {
	  case "Q1":
	  	$month1 = "JAN";
	  	$month2 = "FEB";
	    $month3 = "MAR";
	    break;
	  case "Q2":
	  	$month1 = "APR";
	  	$month2 = "MAY";
	    $month3 = "JUN";
	    break;
	  case "Q3":
   	  	$month1 = "JUL";
	  	$month2 = "AUG";
	    $month3 = "SEP";
	    break;
	  default:
   	  	$month1 = "OCT";
	  	$month2 = "NOV";
	    $month3 = "DEC";	    
	}

	ob_start();
	?>
<form id="corecomp-<?=date('Y',$dateValue) . "-" .$quarterValue?>" action="">
<input type="hidden" id="udname" name="udname" value="<?=$revieweeName?>">
<input type="hidden" id="row" name="row" value="<?=$rowId?>">
<input type="hidden" id="team" name="team" value="<?=$team?>">
<input type="hidden" id="querykey" name="querykey" value="<?=$querykey?>">
<input type="hidden" id="role" name="role" value="<?=$role?>">
<input type="hidden" id="reviewer" name="reviewer" value="<?=$reviewer?>">
<?php
$GLOBALS['m1'] = $month1;
$GLOBALS['m2'] = $month2;
$GLOBALS['m3'] = $month3;

$GLOBALS['monthOne'] = !empty(trim($attr->confirm1)) ? $attr->confirm1 : 'unchecked';
$GLOBALS['monthTwo'] = !empty(trim($attr->confirm2)) ? $attr->confirm2 : 'unchecked';
$GLOBALS['monthThree'] = !empty(trim($attr->confirm3)) ? $attr->confirm3 : 'unchecked';

$GLOBALS['yaerval'] = date("Y", $dateValue);
$GLOBALS['revieweeName'] = $revieweeName;
$GLOBALS['dateAcknowledgedone'] = !empty(trim($attr->dateAcknowledged1)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged1 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgetwo'] = !empty(trim($attr->dateAcknowledged2)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged2 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgethree'] = !empty(trim($attr->dateAcknowledged3)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged3 . ' + 8 hours')) : '';

echo do_shortcode('[elementor-template id="4314"]');
?>
<table class="individual-dashboard">
  <thead>
    <colgroup>
        <col style="width: 3%;"/>
        <col style="width: 15%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 13%;"/>
        <col style="width: 20%;"/>
        <col style="width: 7%;"/>
    </colgroup>
    <tr>
      <th scope="col" colspan="10" class="quater-heading"><?=$quarterValue?> KPI</th>
      <th scope="col" class="quarter-score"><strong><?=number_format((float)$total_kpi,2,'.','')?></strong></th>
    </tr>
    <tr>
      <th scope="col" colspan="2" rowspan="2">Objectives</th>
      <th scope="col" rowspan="2" width="5%"><?=$month1?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month2?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month3?></th>
      <th scope="col" colspan="2"><?=$quarterValue?> <?=date("Y", $dateValue)?></th>
      <th scope="col" colspan="3" rowspan="2">Feedback</th>
      <th scope="col" rowspan="2">Score</th>
    </tr>
     <tr>
      <th scope="col">Actual Score</th>
      <th scope="col">KPI</th>
    </tr>
  </thead>
  <tbody>
    <tr scope="col" class="heading-container">
      <td data-label="Development Objectives (50%)" colspan="11"><p><em>Development Objectives (50%)</em></p></td>
    </tr>
    <tr class="productivity">
      <td data-label="#"><strong>1</strong></td>
      <td data-label="Objectives">Productivity</td>
      <td data-label="<?=$month1?>"><?=$productivity1?></td>
      <td data-label="<?=$month2?>"><?=$productivity2?></td>
      <td data-label="<?=$month3?>"><?=$productivity3?></td>
      <td data-label="ACTUAL SCORE 1"><?=$actualScore1?></td>
      <td data-label="KPI"><?=number_format($productivity_kpi)?></td>
      <td data-label="FEEDBACK1" colspan="3" class="feedback1 fields" name="FEEDBACK1" rel="<?=$feedback1?>"><?=$feedback1?></td>
      <td data-label="Score" rowspan="2"><?=number_format((float)$do_score,2,'.','')?></td>
    </tr>
    <tr class="scheduleadherence">
      <td data-label="#"><strong>2</strong></td>
      <td data-label="Objectives">Schedule Adherence</td>
      <td data-label="<?=$month1?>"><?=$scheduleAdherence1?></td>
      <td data-label="<?=$month2?>"><?=$scheduleAdherence2?></td>
      <td data-label="<?=$month3?>"><?=$scheduleAdherence3?></td>
      <td data-label="ACTUAL SCORE 2"><?=$actualScore2?></td>
      <td data-label="KPI"><?=number_format((float)floor($actualScore3),2,'.','')?></td>
      <td data-label="FEEDBACK2" colspan="3"  class="feedback2 fields" rel="<?=$feedback2?>"><?=$feedback2?></td>
    </tr>
    <tr scope="col" class="heading-container">
      <td data-label="Core Competency" colspan="2"><strong>Core Competency</strong></td>
      <td data-label="Team Lead Score">Team Lead Score</td>
      <td data-label="Your Score">Your Score</td>
      <td data-label="Actual Score">Actual Score</td>
      <td data-label="Overall Feedback" colspan="5">Overall Feedback</td>
      <td data-label="Score">Score</td>
    </tr>
    <tr scope="col" class="teamCulture">
      <td data-label="#" width="3%"><strong>1</strong></td>
      <td data-label="Core Competency">Team Culture</td>
      <td data-label="Team Culture Lead Score" class="teamCultureLeadScore fields" data-type="number" rel="<?=$teamCultureLeadScore?>"><?=$teamCultureLeadScore?></td>
      <td data-label="Team Culture Member Score" class="teamCultureMemberScore fields" data-type="number" rel="<?=$teamCultureMemberScore?>"><?=$teamCultureMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($teamCultureLeadScore + $teamCultureMemberScore) / 2),2,'.','')?></td>
      <td data-label="Overall Feedback" rowspan="6" colspan="5" class="overallFeedback fields" rel="<?=$overallFeedback?>"><?=$overallFeedback?></td>
      <td data-label="Score" data-score rowspan="6"><?=number_format((float)$small_score,2,'.','')?></td>
    </tr>

    <tr scope="col" colspan="9" class="communicationManagement">
      <td data-label="#" width="3%"><strong>2</strong></td>
      <td data-label="Core Competency">Communication Management</td>
      <td data-label="Communication Management Lead Score" class="communicationManagementLeadScore fields" data-type="number" rel="<?=$communicationManagementLeadScore?>"><?=$communicationManagementLeadScore?></td>
      <td data-label="Communication Management Member Score" class="communicationManagementMemberScore fields" data-type="number" rel="<?=$communicationManagementMemberScore?>"><?=$communicationManagementMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($communicationManagementLeadScore + $communicationManagementMemberScore) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="innovation">
      <td data-label="#" width="3%"><strong>3</strong></td>
      <td data-label="Core Competency">Innovation</td>
      <td data-label="Innovation Lead Score" class="innovationLeadScore fields" data-type="number" rel="<?=$innovationLeadScore?>"><?=$innovationLeadScore?></td>
      <td data-label="Innovation Member Score" class="innovationMemberScore fields" data-type="number" rel="<?=$innovationMemberScore?>"><?=$innovationMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($innovationLeadScore + $innovationMemberScore) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="conflictManagement">
      <td data-label="#" width="3%"><strong>4</strong></td>
      <td data-label="Core Competency">Conflict Management</td>
      <td data-label="Conflict Management Lead Score" class="conflictManagementLeadScore fields" data-type="number" rel="<?=$conflictManagementLeadScore?>"><?=$conflictManagementLeadScore?></td>
      <td data-label="Conflict Management MemberScore" class="conflictManagementMemberscore fields" data-type="number" rel="<?=$conflictManagementMemberscore?>"><?=$conflictManagementMemberscore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($conflictManagementLeadScore + $conflictManagementMemberscore) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="changeManagement">
      <td data-label="#" width="3%"><strong>5</strong></td>
      <td data-label="Core Competency">Change Management</td>
      <td data-label="Change Management Lead Score" class="changeManagementLeadScore fields" data-type="number" rel="<?=$changeManagementLeadScore?>"><?=$changeManagementLeadScore?></td>
      <td data-label="Change Management Member Score" class="changeManagementMemberScore fields" data-type="number" rel="<?=$changeManagementMemberScore?>"><?=$changeManagementMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($changeManagementLeadScore + $changeManagementMemberScore) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="learningDevelopment">
      <td data-label="#" width="3%"><strong>6</strong></td>
      <td data-label="Core Competency">Learning & Development</td>
      <td data-label="Learning & Development Lead Score" class="learningDevelopmentLeadScore fields" data-type="number" rel="<?=$learningDevelopmentLeadScore?>"><?=$learningDevelopmentLeadScore?></td>
      <td data-label="Learning & Development Member Score" class="learningDevelopmentMemberScore fields" data-type="number" rel="<?=$learningDevelopmentMemberScore?>"><?=$learningDevelopmentMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($learningDevelopmentLeadScore + $learningDevelopmentMemberScore) / 2),2,'.','')?></td>
    </tr>
  </tbody>
</table>
<?php
echo do_shortcode('[elementor-template id="4313"]'); 
?>
</form>
	<?php
	return ob_get_clean();
}

function get_teammember_table($attr,$dataq = Null){
	if(!isset($attr->undefined)){
		$userid = $attr['user'];
	}else{
		$userobj = wp_get_current_user();
    $userid = isset( $userobj->ID ) ? (int) $userobj->ID : 0;		
	}
  $useropts = get_field('mp_user_options','option',true);
  $getuser  = array_values(array_filter($useropts, function($user) use ($userid) { return $user['mp_user']['ID'] == $userid; }));

	$reviewer = isset($attr->reviewer) ? $attr->reviewer : $getuser[0]["reports_to"]['display_name'];
	$revieweeName = isset($attr->revieweeName) ? $attr->revieweeName : $getuser[0]["mp_user"]["display_name"];
	$team = isset($attr->team) ? $attr->team : $getuser[0]["mp_user_team"];
	$role = isset($attr->role) ? $attr->role : $getuser[0]["mp_user_role"];
	$rowId = isset($attr->rowId) ? $attr->rowId : 0;

	$dateValue = isset($attr->querykey) ? strtotime(substr($attr->querykey,0,4) . '-10-13T16:00:00.000Z') : strtotime($attr['gyear'] . '-10-13T16:00:00.000Z');
	
	$quarterValue = isset($attr->querykey) ? substr($attr->querykey,5,2) : substr($attr['q'],5,2);

  $querykey = isset($attr->querykey) ? $attr->querykey : date("Y", $dateValue) . "-" . $quarterValue . " " .$getuser[0]["mp_user"]["display_name"];

	if(is_numeric($dataq[0]->productivity1)){
		$productivity1 = number_format((float)$dataq[0]->productivity1,2,'.','');
	}else{
		$productivity1 = isset($attr->productivity1) ? number_format((float)$attr->productivity1,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity2)){
		$productivity2 = number_format((float)$dataq[0]->productivity2,2,'.','');
	}else{
		$productivity2 = isset($attr->productivity2) ? number_format((float)$attr->productivity2,2,'.','') : 0;
	}
	if(is_numeric($dataq[0]->productivity3)){
		$productivity3 = number_format((float)$dataq[0]->productivity3,2,'.','');
	}else{
		$productivity3 = isset($attr->productivity3) ? number_format((float)$attr->productivity3,2,'.','') : 0;
	}

	$tot_productivity = floor(($productivity1 + $productivity2 + $productivity3) / 3);
	$tot_productivity = number_format((float)$tot_productivity,2,'.','');

	if(is_numeric($dataq[0]->scheduleAdherence1)){
		$scheduleAdherence1 = round($dataq[0]->scheduleAdherence1);
	}else{
		$scheduleAdherence1 = isset($attr->scheduleAdherence1) ? number_format((float)$attr->scheduleAdherence1,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence2)){
		$scheduleAdherence2 = round($dataq[0]->scheduleAdherence2);
	}else{
		$scheduleAdherence2 = isset($attr->scheduleAdherence2) ? number_format((float)$attr->scheduleAdherence2,2,'.','') : 0;
	}

	if(is_numeric($dataq[0]->scheduleAdherence3)){
		$scheduleAdherence3 = round($dataq[0]->scheduleAdherence3);
	}else{
		$scheduleAdherence3 = isset($attr->scheduleAdherence3) ? number_format((float)$attr->scheduleAdherence3,2,'.','') : 0;	
	}

	$tot_scheduleAdherence = floor(($scheduleAdherence1 + $scheduleAdherence2 + $scheduleAdherence3) / 3);

	if(isset($attr->actualScore1)){
		$actualScore1  = isset($attr->actualScore1) ? number_format((float)$attr->actualScore1,2,'.','') : 0;	
	}else{
		$actualScore1 = number_format((float)$tot_productivity,2,'.','');

	}

	if(isset($attr->actualScore2)){
		$actualScore2  = isset($attr->actualScore2) ? number_format((float)$attr->actualScore2,2,'.','') : 0;	
	}else{
		$actualScore2 = number_format((float)$tot_scheduleAdherence,2,'.','');
	}

	switch (true) {
	  case ($actualScore2 <= 2.39):
	    $actualScore3 = 1;
	    break;
	  case ($actualScore2 > 2.39 && $actualScore2 <= 2.4 - 2.99):
	    $actualScore3 = 2;
	    break;
	  case ($actualScore2 > 2.99 && $actualScore2 <= 3.67):
	    $actualScore3 = 3;
	    break;
	  case ($actualScore2 > 3.67 && $actualScore2 <= 4.66):
	    $actualScore3 = 4;
	    break;
	  default:
	  	$actualScore3 = 5;
	}	

	$overallFeedback  = isset($attr->overallFeedback) ? $attr->overallFeedback : '-';
	$feedback1  = isset($attr->feedback1) ? $attr->feedback1 : '-';
	$feedback2  = isset($attr->feedback2) ? $attr->feedback2 : '-';

	$integrityLeadScore = isset($attr->integrityLeadScore) ? number_format((float)$attr->integrityLeadScore) : 0;
	$integrityMemberScore = isset($attr->integrityMemberScore) ? number_format((float)$attr->integrityMemberScore) : 0;

	if(isset($attr->integrityMemberScore)){
		$small_score = ($integrityLeadScore + $integrityMemberScore) / 2;
	}else{
		$small_score = 0;
	}

	$communicationLeadScore = isset($attr->communicationLeadScore) ? number_format((float)$attr->communicationLeadScore) : 0;
	$communicationMemberScore = isset($attr->communicationMemberScore) ? number_format((float)$attr->communicationMemberScore) : 0;

	if(isset($attr->communicationLeadScore)){
		$small_score += ($communicationLeadScore + $communicationMemberScore) / 2;
	}else{
		$small_score = 0;
	}
	
	$workStandardsLeadScore = isset($attr->workStandardsLeadScore) ? number_format((float)$attr->workStandardsLeadScore) : 0;
	$workStandardsMemberScore = isset($attr->workStandardsMemberScore) ? number_format((float)$attr->workStandardsMemberScore) : 0;

	if(isset($attr->workStandardsLeadScore)){
		$small_score += ($workStandardsLeadScore + $workStandardsMemberScore) / 2;
	}else{
		$small_score = 0;
	}	

	$teamworkLeadScore = isset($attr->teamworkLeadScore) ? number_format((float)$attr->teamworkLeadScore) : 0;
	$teamworkMemberScore = isset($attr->teamworkMemberScore) ? number_format((float)$attr->teamworkMemberScore) : 0;

	if(isset($attr->teamworkLeadScore)){
		$small_score += ($teamworkLeadScore + $teamworkMemberScore) / 2;
	}else{
		$small_score = 0;
	}	


	$selfdevelopmentLeadScore = isset($attr->selfdevelopmentLeadScore) ? number_format((float)$attr->selfdevelopmentLeadScore) : 0;
	$selfdevelopmentMemberScore = isset($attr->selfdevelopmentMemberScore) ? number_format((float)$attr->selfdevelopmentMemberScore) : 0;

	if(isset($attr->selfdevelopmentLeadScore)){
		$small_score += ($selfdevelopmentLeadScore + $selfdevelopmentMemberScore) / 2;
		$small_score = $small_score / 5;		
	}else{
		$small_score = 0;
	}	

	switch(true){
		case($tot_productivity < 1):
			$productivity_kpi = 0;
		break;
		case($tot_productivity < 79):
			$productivity_kpi = 1;
		break;
		case($tot_productivity < 85):
			$productivity_kpi = 2;
		break;
		case($tot_productivity < 91):
			$productivity_kpi = 3;
		break;
		case($tot_productivity < 96):
			$productivity_kpi = 4;
		break;
		default:
			$productivity_kpi = 5;
	}
	$productivity_kpi = number_format((float)$productivity_kpi,2,'.','');

	$do_score = (number_format((float)round($actualScore2),2,'.','') + number_format((float)$productivity_kpi,2,'.','')) / 2;

	$total_kpi = ($small_score + $do_score) / 2;	

	switch ($quarterValue) {
	  case "Q1":
	  	$month1 = "JAN";
	  	$month2 = "FEB";
	    $month3 = "MAR";
	    break;
	  case "Q2":
	  	$month1 = "APR";
	  	$month2 = "MAY";
	    $month3 = "JUN";
	    break;
	  case "Q3":
   	  	$month1 = "JUL";
	  	$month2 = "AUG";
	    $month3 = "SEP";
	    break;
	  default:
   	  	$month1 = "OCT";
	  	$month2 = "NOV";
	    $month3 = "DEC";	    
	}
	ob_start();
	?>
<form id="corecomp-<?=date('Y',$dateValue) . "-" .$quarterValue?>" action="">
<input type="hidden" id="udname" name="udname" value="<?=$revieweeName?>">
<input type="hidden" id="row" name="row" value="<?=$rowId?>">
<input type="hidden" id="team" name="team" value="<?=$team?>">
<input type="hidden" id="querykey" name="querykey" value="<?=$querykey?>">
<input type="hidden" id="role" name="role" value="<?=$role?>">
<input type="hidden" id="reviewer" name="reviewer" value="<?=$reviewer?>">
<?php
$GLOBALS['m1'] = $month1;
$GLOBALS['m2'] = $month2;
$GLOBALS['m3'] = $month3;

$GLOBALS['monthOne'] = !empty(trim($attr->confirm1)) ? $attr->confirm1 : 'unchecked';
$GLOBALS['monthTwo'] = !empty(trim($attr->confirm2)) ? $attr->confirm2 : 'unchecked';
$GLOBALS['monthThree'] = !empty(trim($attr->confirm3)) ? $attr->confirm3 : 'unchecked';

$GLOBALS['yaerval'] = date("Y", $dateValue);
$GLOBALS['revieweeName'] = $revieweeName;

$GLOBALS['dateAcknowledgedone'] = !empty(trim($attr->dateAcknowledged1)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged1 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgetwo'] = !empty(trim($attr->dateAcknowledged2)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged2 . ' + 8 hours')) : '';
$GLOBALS['dateAcknowledgethree'] = !empty(trim($attr->dateAcknowledged3)) ? date('m/d/Y h:i:s A', strtotime($attr->dateAcknowledged3 . ' + 8 hours')) : '';

echo do_shortcode('[elementor-template id="4314"]');
?>
<table class="individual-dashboard">
  <thead>
    <colgroup>
        <col style="width: 3%;"/>
        <col style="width: 15%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 7%;"/>
        <col style="width: 13%;"/>
        <col style="width: 20%;"/>
        <col style="width: 7%;"/>
    </colgroup>
    <tr>
      <th scope="col" colspan="10" class="quater-heading"><?=$quarterValue?> KPI</th>
      <th scope="col" class="quarter-score"><strong><?=number_format((float)$total_kpi,2,'.','')?></strong></th>
    </tr>
    <tr>
      <th scope="col" colspan="2" rowspan="2">Objectives</th>
      <th scope="col" rowspan="2" width="5%"><?=$month1?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month2?></th>
      <th scope="col" rowspan="2" width="5%"><?=$month3?></th>
      <th scope="col" colspan="2"><?=$quarterValue?> <?=date("Y", $dateValue)?></th>
      <th scope="col" colspan="3" rowspan="2">Feedback</th>
      <th scope="col" rowspan="2">Score</th>
    </tr>
     <tr>
      <th scope="col">Actual Score</th>
      <th scope="col">KPI</th>
    </tr>
  </thead>
  <tbody>
    <tr scope="col" class="heading-container">
      <td data-label="Development Objectives (50%)" colspan="11"><p><em>Development Objectives (50%)</em></p></td>
    </tr>
    <tr class="productivity">
      <td data-label="#"><strong>1</strong></td>
      <td data-label="Objectives">Productivity</td>
      <td data-label="<?=$month1?>"><?=$productivity1?></td>
      <td data-label="<?=$month2?>"><?=$productivity2?></td>
      <td data-label="<?=$month3?>"><?=$productivity3?></td>
      <td data-label="Actual Score"><?=$actualScore1?></td>
      <td data-label="KPI"><?=number_format($productivity_kpi)?></td>
      <td data-label="FEEDBACK1" colspan="3" class="feedback1 fields" rel="<?=$feedback1?>"><?=$feedback1?></td>
      <td data-label="Score" rowspan="2"><?=number_format((float)$do_score,2,'.','')?></td>
    </tr>
    <tr class="scheduleadherence">
      <td data-label="#"><strong>2</strong></td>
      <td data-label="Objectives">Schedule Adherence</td>
      <td data-label="<?=$month1?>"><?=$scheduleAdherence1?></td>
      <td data-label="<?=$month2?>"><?=$scheduleAdherence2?></td>
      <td data-label="<?=$month3?>"><?=$scheduleAdherence3?></td>
      <td data-label="Actual Score"><?=$actualScore2?></td>
      <td data-label="KPI"><?=number_format((float)floor($actualScore3),2,'.','')?></td>
      <td data-label="FEEDBACK2" colspan="3" class="feedback2 fields" rel="<?=$feedback2?>"><?=$feedback2?></td>
    </tr>
    <tr scope="col" class="heading-container">
      <td data-label="Core Competency" colspan="2"><strong>Core Competency</strong></td>
      <td data-label="Team Lead Score">Team Lead Score</td>
      <td data-label="Your Score">Your Score</td>
      <td data-label="Actual Score">Actual Score</td>
      <td data-label="Overall Feedback" colspan="5">Overall Feedback</td>
      <td data-label="Score">Score</td>
    </tr>
    <tr scope="col" class="integrity">
      <td data-label="#" width="3%"><strong>1</strong></td>
      <td data-label="Core Competency">Integrity</td>
      <td data-label="Integrity Lead Score" class="integrityLeadScore fields" data-type="number" rel="<?=$integrityLeadScore?>"><?=$integrityLeadScore?></td>
      <td data-label="Integrity Member Score" class="integrityMemberScore fields" data-type="number" rel="<?=$integrityMemberScore?>"><?=$integrityMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($integrityLeadScore + $integrityMemberScore) / 2),2,'.','')?></td>
      <td data-label="Overall Feedback" rowspan="5" colspan="5" class="overallFeedback fields" rel="<?=$overallFeedback?>"><?=$overallFeedback?></td>
      <td data-label="Score" data-score rowspan="5"><?=number_format((float)$small_score,2,'.','')?></td>
    </tr>

    <tr scope="col" colspan="9" class="communication">
      <td data-label="#" width="3%"><strong>2</strong></td>
      <td data-label="Core Competency">Communication</td>
      <td data-label="Communication Lead Score" class="communicationLeadScore fields" data-type="number" rel="<?=$communicationLeadScore?>"><?=$communicationLeadScore?></td>
      <td data-label="Communication Member Score" class="communicationMemberScore fields" data-type="number" rel="<?=$communicationMemberScore?>"><?=$communicationMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($communicationLeadScore + $communicationMemberScore) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="workstandards">
      <td data-label="#" width="3%"><strong>3</strong></td>
      <td data-label="Core Competency">Work Standards</td>
      <td data-label="Work Standards Lead Score" class="workStandardsLeadScore fields" data-type="number" rel="<?=$workStandardsLeadScore?>"><?=$workStandardsLeadScore?></td>
      <td data-label="Work Standards Member Score" class="workStandardsMemberScore fields" data-type="number" rel="<?=$workStandardsMemberScore?>"><?=$workStandardsMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($workStandardsLeadScore + $workStandardsMemberScore) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="teamwork">
      <td data-label="#" width="3%"><strong>4</strong></td>
      <td data-label="Core Competency">Teamwork</td>
      <td data-label="Teamwork Lead Score" class="teamworkLeadScore fields" data-type="number" rel="<?=$teamworkLeadScore?>"><?=$teamworkLeadScore?></td>
      <td data-label="Teamwork Member Score" class="teamworkMemberScore fields" data-type="number" rel="<?=$teamworkMemberScore?>"><?=$teamworkMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($teamworkLeadScore + $teamworkMemberScore) / 2),2,'.','')?></td>
    </tr>

    <tr scope="col" class="selfdevelopment">
      <td data-label="#" width="3%"><strong>5</strong></td>
      <td data-label="Core Competency">Self-development</td>
      <td data-label="Self-Development Lead Score" class="selfdevelopmentLeadScore fields" data-type="number" rel="<?=$selfdevelopmentLeadScore?>"><?=$selfdevelopmentLeadScore?></td>
      <td data-label="Self-Development Member Score" class="selfdevelopmentMemberScore fields" data-type="number" rel="<?=$selfdevelopmentMemberScore?>"><?=$selfdevelopmentMemberScore?></td>
      <td data-label="Actual Score" data-actualscore><?=number_format((float)(($selfdevelopmentLeadScore + $selfdevelopmentMemberScore) / 2),2,'.','')?></td>
    </tr>
  </tbody>
</table>
<?php
echo do_shortcode('[elementor-template id="4313"]'); 
?>
</form>
	<?php
	return ob_get_clean();
}

function check_first_month( $atts ) {
		echo $GLOBALS['monthOne'];
}
add_shortcode( 'checkMonthOne', 'check_first_month' );

function check_second_month( $atts ) {
   	echo $GLOBALS['monthTwo'];
    
}
add_shortcode( 'checkMonthTwo', 'check_second_month' );

function check_third_month( $atts ) {
   	echo $GLOBALS['monthThree'];
}
add_shortcode( 'checkMonthThree', 'check_third_month' );

function get_first_month( $atts ) {
    echo $GLOBALS['m1'] . " " . $GLOBALS['yaerval'];
}
add_shortcode( 'month1', 'get_first_month' );

function get_second_month( $atts ) {
    echo $GLOBALS['m2'] . " " . $GLOBALS['yaerval'];
}
add_shortcode( 'month2', 'get_second_month' );

function get_third_month( $atts ) {
    echo $GLOBALS['m3'] . " " . $GLOBALS['yaerval'];
}
add_shortcode( 'month3', 'get_third_month' );

function check_confirmation( $atts ) {
    if($GLOBALS['monthOne'] != 'unchecked' || $GLOBALS['monthTwo'] != 'unchecked' || $GLOBALS['monthThree'] != 'unchecked'){
    	echo "checked";
    }else{
    	echo "unchecked";
    }
}
add_shortcode( 'checkConfirmation', 'check_confirmation' );

function notice_confirmation( $atts ) {
    if($GLOBALS['monthOne'] == 'waiting' || $GLOBALS['monthTwo'] == 'waiting' || $GLOBALS['monthThree'] == 'waiting'){
    	echo "waiting";
    }
}
add_shortcode( 'acknowledge_notice', 'notice_confirmation' );

function req_Acknowledgement_month_one( $atts ) {
	if($GLOBALS['monthOne'] == 'unchecked'){
    echo "Request acknowledgment to " . $GLOBALS['revieweeName'];
	}else if($GLOBALS['monthOne'] == 'waiting'){
    echo "Waiting acknowledgment from <b>" . $GLOBALS['revieweeName'] . "</b>";
	}else{
    echo "Acknowledged by <b>" . $GLOBALS['revieweeName'] . "</b>";
	}	
}
add_shortcode( 'get_Acknowledgement_one', 'req_Acknowledgement_month_one' );

function req_acknowledgement_month_two( $atts ) {
	if($GLOBALS['monthTwo'] == 'unchecked'){
    echo "Request acknowledgment to " . $GLOBALS['revieweeName'];
	}else if($GLOBALS['monthTwo'] == 'waiting'){
    echo "Waiting acknowledgment from <b>" . $GLOBALS['revieweeName'] . "</b>";
	}else{
    echo "Acknowledged by <b>" . $GLOBALS['revieweeName'] . "</b>";
	}	
}

add_shortcode( 'get_Acknowledgement_two', 'req_acknowledgement_month_two' );

function req_Acknowledgement_month_three( $atts ) {
	if($GLOBALS['monthThree'] == 'unchecked'){
    echo "Request acknowledgment to <b>" . $GLOBALS['revieweeName'] . "</b>";
	}else if($GLOBALS['monthThree'] == 'waiting'){
    echo "Waiting acknowledgment from <b>" . $GLOBALS['revieweeName'] . "</b>";
	}else{
    echo "Acknowledged by <b>" . $GLOBALS['revieweeName'] . "</b>";
	}	
}
add_shortcode( 'get_Acknowledgement_three', 'req_Acknowledgement_month_three' );

function req_Acknowledgement_time_one( $atts ) {
    echo $GLOBALS['dateAcknowledgedone'];
}
add_shortcode( 'get_acknowledgement_time_one', 'req_Acknowledgement_time_one' );

function req_Acknowledgement_time_two( $atts ) {
    echo $GLOBALS['dateAcknowledgetwo'];
}
add_shortcode( 'get_acknowledgement_time_two', 'req_Acknowledgement_time_two' );

function req_Acknowledgement_time_three( $atts ) {
    echo $GLOBALS['dateAcknowledgethree'];
}
add_shortcode( 'get_acknowledgement_time_three', 'req_Acknowledgement_time_three' );

function sp_corecomp_enqueue() {
	$ver = rand(0,99999999);
	
	if(is_page('individual-dashboard')){

		// GET TASKS
		$tasks_list = [];
		$sheet_url = 'https://script.google.com/macros/s/AKfycbz1MXUSUiFpq4MS0yHfddNVmpKs0KgX5WkjKCh88318DzASZvDIgB3nttlqXS2UeC_p/exec';

		wp_enqueue_style('dashboard_sp',  get_stylesheet_directory_uri() . '/assets/css/jquery-confirm.css',['hello-elementor-child-style'], $ver, false);
		wp_enqueue_script('dashboard_sp', get_stylesheet_directory_uri() . '/assets/js/jquery-confirm.js',['jquery'], $ver,false);			

		wp_localize_script( 'dashboard_sp', 'sp_core_obj', [
			'core_sheet' => $sheet_url
		] );		

	}
}
add_action( 'wp_enqueue_scripts', 'sp_corecomp_enqueue', 20 );