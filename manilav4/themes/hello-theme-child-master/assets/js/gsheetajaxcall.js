jQuery(document).ready( function() {
    var totProdTime = 0;
    if(user_object.role == 'Director'){
        jQuery('.mnltoggle').hide();
    }

    if(user_object.role == 'Member'){
        jQuery('#accMonthOne.unchecked').hide();
        jQuery('#accMonthTwo.unchecked').hide();
        jQuery('#accMonthThree.unchecked').hide();
        jQuery('#notes.unchecked').hide();
        jQuery('#acknotice.waiting').show();
        jQuery('#status.waiting #waiting').css("cursor","pointer");
    }

    if(jQuery('#form-field-dateselect').length){
        var d = new Date();
        var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
        jQuery("#form-field-dateselect").attr('max',strDate);    
        jQuery("#form-field-dateselect").val(strDate);
            setTimeout(function() {
                jQuery("#elementor-tab-title-3833").click();
            },100);    
    }

    jQuery("#sidemenu ul li a").each(function(){
        var loc = jQuery(location).attr('pathname').replace(RegExp('/','g'), '');
        if(jQuery(this).attr('_key') == loc){
           jQuery(this).addClass('highlight'); 
        }
        //if(loc == 'manager-dashboard'){
            //jQuery("#sidemenu ul li a[_key='user-dashboard']").addClass('highlight');
        //}
    });

    if(jQuery('#control_table').length){
        jQuery('#kpi_loading').css('display','none');    
    }

    jQuery('body').on('focus', '[contenteditable]', function() {
        const $this = jQuery(this);
        $this.data('before', $this.html());
    }).on('keypress', 'td[data-type="number"]' , function(e) {
        var self = jQuery(this);
        self.val(self.val().replace(/\D/g, ""));
        if ((e.which < 48 || e.which > 57) && e.which != 46){
            e.preventDefault();
        }
    }).on('keyup change','td[data-type="number"]', function(e){

        if(jQuery.trim(jQuery(this).html()) == ""){
            jQuery(this).html(0);
        }

        var self = jQuery(this);
        var formid = jQuery(this).closest("tr").attr('class');
        //console.log(formid);
        var mformid = jQuery(this).closest("form").attr('id');
        //console.log(this);
        //console.log(mformid);
    
        var tscore = parseInt(jQuery('td[data-label="Team Lead Score"]',jQuery('#' +mformid)).html()); 
        var yscore = parseInt(jQuery('td[data-label="Your Score"]',jQuery('#' +mformid)).html());

        var integrityLeadScore_score = parseInt(jQuery('.integrityLeadScore',jQuery('#' +mformid)).html()); 
        var integrityMemberScore_score = parseInt(jQuery('.integrityMemberScore',jQuery('#' +mformid)).html());

        var communicationLeadScore_score = parseInt(jQuery('.communicationLeadScore',jQuery('#' +mformid)).html()); 
        var communicationMemberScore_score = parseInt(jQuery('.communicationMemberScore',jQuery('#' +mformid)).html());

        var workStandardsLeadScore_score = parseInt(jQuery('.workStandardsLeadScore',jQuery('#' +mformid)).html()); 
        var workStandardsMemberScore_score = parseInt(jQuery('.workStandardsMemberScore',jQuery('#' +mformid)).html());

        var teamworkLeadScore_score = parseInt(jQuery('.teamworkLeadScore',jQuery('#' +mformid)).html()); 
        var teamworkMemberScore_score = parseInt(jQuery('.teamworkMemberScore',jQuery('#' +mformid)).html());

        var selfdevelopmentLeadScore_score = parseInt(jQuery('.selfdevelopmentLeadScore',jQuery('#' +mformid)).html()); 
        var selfdevelopmentMemberScore_score = parseInt(jQuery('.selfdevelopmentMemberScore',jQuery('#' +mformid)).html());

        var administrationTeam_score = parseInt(jQuery('.administrationTeam',jQuery('#' +mformid)).html()); 
        var administrationSelf_score = parseInt(jQuery('.administrationSelf',jQuery('#' +mformid)).html());

        var dependabilityTeam_score = parseInt(jQuery('.dependabilityTeam',jQuery('#' +mformid)).html()); 
        var dependabilitySelf_score = parseInt(jQuery('.dependabilitySelf',jQuery('#' +mformid)).html());

        var initiativeTeam_score = parseInt(jQuery('.initiativeTeam',jQuery('#' +mformid)).html()); 
        var initiativeSelf_score = parseInt(jQuery('.initiativeSelf',jQuery('#' +mformid)).html());

        var attendancePunctualityTeam_score = parseInt(jQuery('.attendancePunctualityTeam',jQuery('#' +mformid)).html()); 
        var attendancePunctualitySelf_score = parseInt(jQuery('.attendancePunctualitySelf',jQuery('#' +mformid)).html());

        var volumeOfWorkTeam_score = parseInt(jQuery('.volumeOfWorkTeam',jQuery('#' +mformid)).html()); 
        var volumeOfWorkSelf_score = parseInt(jQuery('.volumeOfWorkSelf',jQuery('#' +mformid)).html());

        var rigourTeam_score = parseInt(jQuery('.rigourTeam',jQuery('#' +mformid)).html()); 
        var rigourSelf_score = parseInt(jQuery('.rigourSelf',jQuery('#' +mformid)).html());

        var knowledgeOfTheJobTeam_score = parseInt(jQuery('.knowledgeOfTheJobTeam',jQuery('#' +mformid)).html()); 
        var knowledgeOfTheJobSelf_score = parseInt(jQuery('.knowledgeOfTheJobSelf',jQuery('#' +mformid)).html());

        var transparencyTeam_score = parseInt(jQuery('.transparencyTeam',jQuery('#' +mformid)).html()); 
        var transparencySelf_score = parseInt(jQuery('.transparencySelf',jQuery('#' +mformid)).html());        

        var decisionMakingproblemSolvingTeam_score = parseInt(jQuery('.decisionMakingproblemSolvingTeam',jQuery('#' +mformid)).html()); 
        var decisionMakingproblemSolvingSelf_score = parseInt(jQuery('.decisionMakingproblemSolvingSelf',jQuery('#' +mformid)).html()); 

        var teamworkTeam_score = parseInt(jQuery('.teamworkTeam',jQuery('#' +mformid)).html()); 
        var teamworkSelf_score = parseInt(jQuery('.teamworkSelf',jQuery('#' +mformid)).html()); 

        var coachingTeam_score = parseInt(jQuery('.coachingTeam',jQuery('#' +mformid)).html()); 
        var coachingSelf_score = parseInt(jQuery('.coachingSelf',jQuery('#' +mformid)).html()); 

        var communicationTeam_score = parseInt(jQuery('.communicationTeam',jQuery('#' +mformid)).html()); 
        var communicationSelf_score = parseInt(jQuery('.communicationSelf',jQuery('#' +mformid)).html());

        var overalFeelingTeam_score = parseInt(jQuery('.overalFeelingTeam',jQuery('#' +mformid)).html()); 
        var overalFeelingSelf_score = parseInt(jQuery('.overalFeelingSelf',jQuery('#' +mformid)).html()); 

        var technicalSkillsTeam_score = parseInt(jQuery('.technicalSkillsTeam',jQuery('#' +mformid)).html()); 
        var technicalSkillsSelf_score = parseInt(jQuery('.technicalSkillsSelf',jQuery('#' +mformid)).html()); 

        var projectContributionsTeam_score = parseInt(jQuery('.projectContributionsTeam',jQuery('#' +mformid)).html()); 
        var projectContributionsSelf_score = parseInt(jQuery('.projectContributionsSelf',jQuery('#' +mformid)).html()); 

        var problemSolvingTeam_score = parseInt(jQuery('.problemSolvingTeam',jQuery('#' +mformid)).html()); 
        var problemSolvingSelf_score = parseInt(jQuery('.problemSolvingSelf',jQuery('#' +mformid)).html()); 

        var softSkillsTeam_score = parseInt(jQuery('.softSkillsTeam',jQuery('#' +mformid)).html()); 
        var softSkillsSelf_score = parseInt(jQuery('.softSkillsSelf',jQuery('#' +mformid)).html());

        var selfdevelopmentTeam_score = parseInt(jQuery('.selfdevelopmentTeam',jQuery('#' +mformid)).html()); 
        var selfdevelopmentSelf_score = parseInt(jQuery('.selfdevelopmentSelf',jQuery('#' +mformid)).html());


        var ascore = tscore + yscore
            ascore = ascore / 2;
    
        integrityAScore = integrityLeadScore_score + integrityMemberScore_score;
        integrityAScore = integrityAScore / 2;

        communicationAScore = communicationLeadScore_score + communicationMemberScore_score;
        communicationAScore = communicationAScore / 2;

        workstandardsAScore = workStandardsLeadScore_score + workStandardsMemberScore_score;
        workstandardsAScore = workstandardsAScore / 2;

        teamworkAScore = teamworkLeadScore_score + teamworkMemberScore_score;
        teamworkAScore = teamworkAScore / 2;

        selfdevelopmentAScore = selfdevelopmentLeadScore_score + selfdevelopmentMemberScore_score;
        selfdevelopmentAScore = selfdevelopmentAScore / 2;

        administrationAScore = administrationTeam_score + administrationSelf_score;
        administrationAScore = administrationAScore / 2;

        dependabilityAScore = dependabilityTeam_score + dependabilitySelf_score;
        dependabilityAScore = dependabilityAScore / 2;

        dependabilityAScore = dependabilityTeam_score + dependabilitySelf_score;
        dependabilityAScore = dependabilityAScore / 2;

        initiativeAScore = initiativeTeam_score + initiativeSelf_score;
        initiativeAScore = initiativeAScore / 2;

        attendancePunctualityAScore = attendancePunctualityTeam_score + attendancePunctualitySelf_score;
        attendancePunctualityAScore = attendancePunctualityAScore / 2;

        volumeOfWorkAScore = volumeOfWorkTeam_score + volumeOfWorkSelf_score;
        volumeOfWorkAScore = volumeOfWorkAScore / 2;

        rigourAScore = rigourTeam_score + rigourSelf_score;
        rigourAScore = rigourAScore / 2;

        knowledgeOfTheJobAScore = knowledgeOfTheJobTeam_score + knowledgeOfTheJobSelf_score;
        knowledgeOfTheJobAScore = knowledgeOfTheJobAScore / 2;

        transparencyAScore = transparencyTeam_score + transparencySelf_score;
        transparencyAScore = transparencyAScore / 2;

        decisionMakingproblemSolvingAScore = decisionMakingproblemSolvingTeam_score + decisionMakingproblemSolvingSelf_score;
        decisionMakingproblemSolvingAScore = decisionMakingproblemSolvingAScore / 2;

        trafficteamworkAScore = teamworkTeam_score + teamworkSelf_score;
        trafficteamworkAScore = trafficteamworkAScore / 2; 

        coachingAScore = coachingTeam_score + coachingSelf_score;
        coachingAScore = coachingAScore / 2; 

        trafficcommunicationAScore = communicationTeam_score + communicationSelf_score;
        trafficcommunicationAScore = trafficcommunicationAScore / 2; 

        overalFeelingAScore = overalFeelingTeam_score + overalFeelingSelf_score;
        overalFeelingAScore = overalFeelingAScore / 2;

        teamworkAscore = teamworkTeam_score + teamworkSelf_score;
        teamworkAscore = teamworkAscore / 2;  

        coachingAscore = coachingTeam_score + coachingSelf_score;
        coachingAscore = coachingAscore / 2;

        communicationAscore = communicationTeam_score + communicationSelf_score;
        communicationAscore = communicationAscore / 2;

        overalFeelingAscore  = overalFeelingTeam_score + overalFeelingSelf_score;
        overalFeelingAscore = overalFeelingAscore / 2;

        technicalSkillsAscore  = technicalSkillsTeam_score + technicalSkillsSelf_score;
        technicalSkillsAscore = technicalSkillsAscore / 2;

        projectContributionsAscore  = projectContributionsTeam_score + projectContributionsSelf_score;
        projectContributionsAscore = projectContributionsAscore / 2;

        problemSolvingAscore  = problemSolvingTeam_score + problemSolvingSelf_score;
        problemSolvingAscore = problemSolvingAscore / 2;

        softSkillsAscore  = softSkillsTeam_score + softSkillsSelf_score;
        softSkillsAscore = softSkillsAscore / 2;

        selfdevelopmentFAscore  = selfdevelopmentTeam_score + selfdevelopmentSelf_score;
        selfdevelopmentFAscore = selfdevelopmentFAscore / 2;

        jQuery('td[data-actualscore]',jQuery('.' +formid)).html(function(){
            switch(formid) {
              case "administration":
                return administrationAScore;
                break;
              case "dependability":
                return dependabilityAScore;
                break;     
              case "initiative":
                return initiativeAScore;
                break;     
              case "attendancePunctuality":
                return attendancePunctualityAScore;
                break;     
              case "volumeOfWork":
                return volumeOfWorkAScore;
                break;     
              case "rigour":
                return rigourAScore;
                break;     
              case "knowledgeOfTheJob":
                return knowledgeOfTheJobAScore;
                break;     
              case "transparency":
                return transparencyAScore;
                break;     
              case "decisionMakingproblemSolving":
                return decisionMakingproblemSolvingAScore;
                break;                 
              case "trafficteamwork":
                return trafficteamworkAScore;
                break;                 
              case "coaching":
                return coachingAScore;
                break;                             
              case "trafficcommunication":
                return trafficcommunicationAScore;
                break;                             
              case "overalFeeling":
                return overalFeelingAScore;
                break;
              case "integrity":
                return integrityAScore;
                break;
              case "communication":
                return communicationAScore;
                break;
              case "workstandards":
                return workstandardsAScore;
                break;  
              case "teamwork":
                return teamworkAScore;
                break;  
              case "technicalSkills":
                return technicalSkillsAscore;
                break;  
              case "projectContributions":
                return projectContributionsAscore;
                break;
              case "problemSolving":
                return problemSolvingAscore;
                break;
              case "softSkills":
                return softSkillsAscore;
                break;
              case "selfDevelopmentFrontend":
                return selfdevelopmentFAscore;
                break;
              default:
                return selfdevelopmentAScore;
            }
        }); 

    var score = 0;
    var quarterscore = 0;
    //jQuery('td[data-actualscore]',jQuery('.' +formid)).html(ascore.toFixed(2));  
   //console.log(mformid);
   jQuery('td[data-actualscore]',jQuery('#' +mformid)).each(function(){
        score += parseFloat(jQuery(this).html());
    })
    score = score / parseInt(jQuery('td[data-actualscore]',jQuery('#' +mformid)).length);
    //console.log(score);
    jQuery('td[data-score]',jQuery('#' +mformid)).html(score.toFixed(2))
    
    jQuery('td[data-label="Score"]',jQuery('#' +mformid)).each(function(){
        if(isNaN(parseFloat(jQuery(this).html()))) {
        }else{
            quarterscore += parseFloat(jQuery(this).html());
        }
    })

    quarterscore = parseFloat(quarterscore) / 2;
    jQuery('.quarter-score',jQuery('#' +mformid)).html('<strong>'+ quarterscore.toFixed(2) +'</strong>');

    var kpiscore = 0;
    jQuery(".quarter-score>strong").each(function(){
        kpiscore  += parseFloat(jQuery(this).html());
    });

    kpiscore = kpiscore / jQuery(".quarter-score>strong").length;
    jQuery('.kpi-score') .html(kpiscore.toFixed(2));

});


if(jQuery('.datecontainer').length){
    jQuery('.datecontainer').append(jQuery('#date_picks'));
}

jQuery(document).on('click','form.allowedit #accMonthOne.unchecked #status.unchecked #unchecked svg path', function(e){
var cb = jQuery(jQuery(this).parents('form.allowedit'));
var array = [];
var element= {};
var confirmOneDate = jQuery('.cMonth1 p',cb).text();
//console.log(confirmOneDate);

    element['QueryKey'] = jQuery('#querykey',cb).val();
    element['Confirm 1'] = 'waiting';


    jQuery.confirm({
        title: 'EMPLOYEE ACKNOWLEDGMENT',
        content: 'I hereby confirm that during our session, I have thoroughly discussed all the data and<br/>information for '+confirmOneDate+' with no further questions or concerns.',
        buttons: {
            confirm: function () {
            jQuery.get(sp_core_obj.core_sheet, {action:'add_ack',data:JSON.stringify(element)}, function(response, textStatus, jqXHR){
                if(response.success){
                    //console.log(response)
                    jQuery('#accMonthOne, #accMonthOne #status ',cb).removeClass('unchecked').addClass('waiting');
                }
            });

            },
            cancel: function () {
                //console.log('cancel');
            }
        }
    });
});

jQuery(document).on('click','form:not(.allowedit) #accMonthOne.waiting #status.waiting #waiting svg path', function(e){
    //console.log(e);

var cb = jQuery(jQuery(this).parents('form:not(.allowedit)'));
var array = [];
var element= {};

var tmstmp = new Date();
var tmp_ZONE = {timeZone: 'Asia/Manila'};
var tmstmp_PST = tmstmp.toLocaleString('en-US', tmp_ZONE);
var udname = jQuery('#udname',cb).val();

var confirmOneDate = jQuery('.cMonth1 p',cb).text();
//console.log(confirmOneDate);

    element['QueryKey'] = jQuery('#querykey',cb).val();
    element['Confirm 1'] = 'acknowledged';
    element['Date Acknowledged 1'] = tmstmp_PST;

    jQuery.confirm({
        title: 'EMPLOYEE ACKNOWLEDGMENT',
        content: 'I would like to confirm that the agenda and KPI scores for '+confirmOneDate+' were comprehensively<br/>discussed during our session with no further questions or concerns.',
        buttons: {
            confirm: function () {
            jQuery.get(sp_core_obj.core_sheet, {action:'add_ack',data:JSON.stringify(element)}, function(response, textStatus, jqXHR){
                if(response.success){
                    //console.log(response)
                    jQuery('#accMonthOne, #accMonthOne #status ',cb).removeClass('waiting').addClass('acknowledged');
                    jQuery('#accMonthOne #ackTime > div',cb).html(tmstmp_PST);
                    jQuery('#accMonthOne #ackName1 > div',cb).html('Acknowledged');
                    
                }
            });

            },
            cancel: function () {
                //console.log('cancel');
            }
        }
    });
});

jQuery(document).on('click','form.allowedit #accMonthTwo.unchecked #status.unchecked #unchecked svg path', function(e){
var cb = jQuery(jQuery(this).parents('form.allowedit'));
var array = [];
var element= {};

var tmstmp = new Date();
var tmp_ZONE = {timeZone: 'Asia/Manila'};
var tmstmp_PST = tmstmp.toLocaleString('en-US', tmp_ZONE);
var confirmOneDate = jQuery('.cMonth2 p',cb).text();
//console.log(confirmOneDate);

    element['QueryKey'] = jQuery('#querykey',cb).val();
    element['Confirm 2'] = 'waiting';

    jQuery.confirm({
        title: 'EMPLOYEE ACKNOWLEDGMENT',
        content: 'I hereby confirm that during our session, I have thoroughly discussed all the data and<br/>information for '+confirmOneDate+' with no further questions or concerns.',
        buttons: {
            confirm: function () {
            jQuery.get(sp_core_obj.core_sheet, {action:'add_ack',data:JSON.stringify(element)}, function(response, textStatus, jqXHR){
                if(response.success){
                    jQuery('#accMonthTwo, #accMonthTwo #status ',cb).removeClass('unchecked').addClass('waiting');
                }
            });

                
            },
            cancel: function () {
                //console.log('cancel');
            }
        }
    });
});

jQuery(document).on('click','form:not(.allowedit) #accMonthTwo.waiting #status.waiting #waiting svg path', function(e){
    //console.log(e);

var cb = jQuery(jQuery(this).parents('form:not(.allowedit)'));
var array = [];
var element= {};

var tmstmp = new Date();
var tmp_ZONE = {timeZone: 'Asia/Manila'};
var tmstmp_PST = tmstmp.toLocaleString('en-US', tmp_ZONE);
var udname = jQuery('#udname',cb).val();
var confirmOneDate = jQuery('.cMonth2 p',cb).text();
//console.log(confirmOneDate);

    element['QueryKey'] = jQuery('#querykey',cb).val();
    element['Confirm 2'] = 'acknowledged';
    element['Date Acknowledged 2'] = tmstmp_PST;

    jQuery.confirm({
        title: 'EMPLOYEE ACKNOWLEDGMENT',
        content: 'I would like to confirm that the agenda and KPI scores for '+confirmOneDate+' were comprehensively<br/>discussed during our session with no further questions or concerns.',
        buttons: {
            confirm: function () {
            jQuery.get(sp_core_obj.core_sheet, {action:'add_ack',data:JSON.stringify(element)}, function(response, textStatus, jqXHR){
                if(response.success){
                    //console.log(response)
                    jQuery('#accMonthTwo, #accMonthTwo #status ',cb).removeClass('waiting').addClass('acknowledged');
                    jQuery('#accMonthTwo #ackTime > div',cb).html(tmstmp_PST);
                    jQuery('#accMonthTwo #ackName2 > div',cb).html('Acknowledged');
                }
            });

            },
            cancel: function () {
                //console.log('cancel');
            }
        }
    });
});

jQuery(document).on('click','form.allowedit #accMonthThree.unchecked #status.unchecked #unchecked svg path', function(e){
var cb = jQuery(jQuery(this).parents('form.allowedit'));
var array = [];
var element= {};

var tmstmp = new Date();
var tmp_ZONE = {timeZone: 'Asia/Manila'};
var tmstmp_PST = tmstmp.toLocaleString('en-US', tmp_ZONE);
var confirmOneDate = jQuery('.cMonth3 p',cb).text();
//console.log(confirmOneDate);

    element['QueryKey'] = jQuery('#querykey',cb).val();
    element['Confirm 3'] = 'waiting';

    jQuery.confirm({
        title: 'EMPLOYEE ACKNOWLEDGMENT',
        content: 'I hereby confirm that during our session, I have thoroughly discussed all the data and<br/>information for '+confirmOneDate+' with no further questions or concerns.',
        buttons: {
            confirm: function () {
            jQuery.get(sp_core_obj.core_sheet, {action:'add_ack',data:JSON.stringify(element)}, function(response, textStatus, jqXHR){
                if(response.success){
                    jQuery('#accMonthThree, #accMonthThree #status ',cb).removeClass('unchecked').addClass('waiting');
                }
            });

                
            },
            cancel: function () {
                //console.log('cancel');
            }
        }
    });
});

jQuery(document).on('click','form:not(.allowedit) #accMonthThree.waiting #status.waiting #waiting svg path', function(e){
    //console.log(e);

var cb = jQuery(jQuery(this).parents('form:not(.allowedit)'));
var array = [];
var element= {};

var tmstmp = new Date();
var tmp_ZONE = {timeZone: 'Asia/Manila'};
var tmstmp_PST = tmstmp.toLocaleString('en-US', tmp_ZONE);
var udname = jQuery('#udname',cb).val();
var confirmOneDate = jQuery('.cMonth3 p',cb).text();
//console.log(confirmOneDate);

    element['QueryKey'] = jQuery('#querykey',cb).val();
    element['QueryKey'] = jQuery('#querykey',cb).val();
    element['Confirm 3'] = 'acknowledged';
    element['Date Acknowledged 3'] = tmstmp_PST;

    jQuery.confirm({
        title: 'EMPLOYEE ACKNOWLEDGMENT',
        content: 'I would like to confirm that the agenda and KPI scores for '+confirmOneDate+' were comprehensively<br/>discussed during our session with no further questions or concerns.',
        buttons: {
            confirm: function () {
            jQuery.get(sp_core_obj.core_sheet, {action:'add_ack',data:JSON.stringify(element)}, function(response, textStatus, jqXHR){
                if(response.success){
                   // console.log(response)
                    jQuery('#accMonthThree, #accMonthThree #status ',cb).removeClass('waiting').addClass('acknowledged');
                    jQuery('#accMonthThree #ackTime > div',cb).html(tmstmp_PST);
                    jQuery('#accMonthThree #ackName3 > div',cb).html('Acknowledged');
                }
            });

            },
            cancel: function () {
               // console.log('cancel');
            }
        }
    });
});

jQuery(document).on('click','form.allowedit .btn-cancel',function(e){

        var cb = jQuery(this).parents('form.allowedit');
        jQuery('.fields',jQuery(this).parents('form.allowedit')).each(function(){
           //  console.log(jQuery(this));
            jQuery(this).removeAttr('contenteditable');
            jQuery(this).html(jQuery(this).attr('rel'))
            cb.find('.control_bar').remove();
        })

});

jQuery(document).on('click','form.allowedit .btn-save',function(e){
     var cb = jQuery(jQuery(this).parents('form.allowedit'));
     var array = [];
     var element= {};

        element['uid'] = jQuery('#individual_dashboard #team_memberlist').find("option:selected").attr('value');
        element['udname'] = jQuery('#udname',jQuery(this).parents('form.allowedit')).val();
        element['team'] = jQuery('#team',jQuery(this).parents('form.allowedit')).val();
        element['querykey'] = jQuery('#querykey',jQuery(this).parents('form.allowedit')).val();
        element['role'] = jQuery('#role',jQuery(this).parents('form.allowedit')).val();
        element['reviewer'] = jQuery('#reviewer',jQuery(this).parents('form.allowedit')).val();

        jQuery('.fields',jQuery(this).parents('form.allowedit')).each(function(){
            jQuery(this).removeAttr('contenteditable');
            jQuery(this).attr('rel',jQuery(this).html().replace(/(<([^>]+)>)/ig,""))
            if(jQuery(this).html() == "-"){
            element[jQuery(this).attr('class').split(' ')[0]] = "";
            }else{
            //element[jQuery(this).attr('class').split(' ')[0]] = jQuery(this).html().replace(/(<([^>]+)>)/ig,"");
            element[jQuery(this).attr('class').split(' ')[0]] = jQuery(this).html();
            }
            cb.find('.control_bar').remove();
        })
        array.push(element);   

        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "new_core_comp_entry", data : array,nonce: user_object.nonce},
             success: function(response) {
                       // console.log(response);
                        Object.keys(response.data).map(k => {
                           // console.log(response.data[k].updatedrow);
                        });                        

                      }
        }); 

    
});

jQuery(document).on('click','form.allowedit table',function(e){
    e.preventDefault();
    if(jQuery(this).parents('form.allowedit').children(".control_bar").length === 0){
        var mainform = jQuery(this).parents('form.allowedit');
        var cb = jQuery('<div class="control_bar">')
        cb.append('<div class="py-1 px-2 text-center"><button type="button" class="btn-save">Save</button></div><button type="button" class="btn-cancel">Cancel</button>')
        mainform.append(cb)        
    }
    
    if(jQuery(e.target).hasClass('fields')){
        jQuery(e.target).attr('contenteditable','true');
    }
    /*
    if(e.target.className == "btn-cancel"){
        var cb = jQuery(jQuery(this)).parent();
        console.log(cb);
        jQuery('.fields',jQuery(this)).each(function(){
            jQuery(this).removeAttr('contenteditable');
            jQuery(this).html(jQuery(this).attr('rel'))
            cb.find('.control_bar').remove();
        })
    }
    if(e.target.className == "btn-save"){
        var cb = jQuery(jQuery(this));
        var array = [];
        var element= {};

        element['uid'] = jQuery('#individual_dashboard #team_memberlist').find("option:selected").attr('value');
        element['udname'] = jQuery('#udname',jQuery(this)).val();
        element['team'] = jQuery('#team',jQuery(this)).val();
        element['querykey'] = jQuery('#querykey',jQuery(this)).val();
        element['role'] = jQuery('#role',jQuery(this)).val();
        element['reviewer'] = jQuery('#reviewer',jQuery(this)).val();

        jQuery('.fields',jQuery(this)).each(function(){
            jQuery(this).removeAttr('contenteditable');
            jQuery(this).attr('rel',jQuery(this).html().replace(/(<([^>]+)>)/ig,""))
            if(jQuery(this).html() == "-"){
            element[jQuery(this).attr('class').split(' ')[0]] = "";
            }else{
            element[jQuery(this).attr('class').split(' ')[0]] = jQuery(this).html().replace(/(<([^>]+)>)/ig,"");
            }
            cb.find('.control_bar').remove();
        })
        array.push(element);   

        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "new_core_comp_entry", data : array,nonce: user_object.nonce},
             success: function(response) {
                        console.log(response);
                        Object.keys(response.data).map(k => {
                            console.log(response.data[k].updatedrow);
                        });                        

                      }
        });        
    }
    */
})

jQuery(document).on("click",".add_kpi_entry a",function(e){
    e.preventDefault();

    var table = jQuery('#control_table');
    table.find('.norecord').remove()
    table.find('.add_kpi_entry').remove()

     var tr = jQuery('<div>')
        jQuery('#kpi_loading').css('display','');
        jQuery('#kpi_loading').css('position','absolute');
        jQuery('#kpi_loading').css('z-index','9999');
        jQuery('#kpi_loading').css('background','#ffffff');
        jQuery('#kpi_loading').css('width','96%');

     tr.append();
     table.find('.elementor-shortcode').append(tr)



    jQuery.ajax({
         type : "post",
         dataType : "json",
         url : user_object.ajaxurl,
         data : {action: "new_quarter_entry", u_id : jQuery('#individual_dashboard #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#individual_dashboard #form-field-year').find("option:selected").attr('value'), nonce: user_object.nonce, q: (jQuery(".quarter-score>strong").length + 1) },
         success: function(response) {
                    if(response.type == "success") {
                        var table = jQuery('#control_table');
                        table.find('.loading').remove()
                        table.find('.elementor-shortcode').append(response.data);

                        jQuery('#kpi_loading').css('display','none');
                        jQuery('#kpi_loading').css('position');
                        jQuery('#kpi_loading').css('z-index');
                        jQuery('#kpi_loading').css('background');
                        jQuery('#kpi_loading').css('width');                        

                        if(jQuery(".quarter-score>strong").length != 4){
                            var bt = jQuery("<div class='add_kpi_entry'>")
                            bt.append('<a href="#" class="lnk_new_entry">Add KPI Quarter '+(jQuery(".quarter-score>strong").length + 1)+'</a>')
                            table.find('.elementor-shortcode').append(bt)
                        }
                        jQuery('#control_table .elementor-shortcode form').each(function(){
                            jQuery(this).addClass('allowedit');
                        })                        
                    }
                  }
    });

});

jQuery(document).on("change","#individual_dashboard #team_memberlist,#individual_dashboard #form-field-year",function(e){
//jQuery('#team_memberlist,#form-field-year').change(function(e){
    e.preventDefault();
            var table = jQuery('#control_table');
               // Emptying the Table items
               table.find('.elementor-shortcode').html('');

             var tr = jQuery('<div>')
             jQuery('#kpi_loading').css('display','');
             tr.append();
             table.find('.elementor-shortcode').html(tr)

    jQuery.ajax({
         type : "post",
         dataType : "json",
         url : user_object.ajaxurl,
         data : {action: "display_individual_dashboard", u_id : jQuery('#individual_dashboard #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#individual_dashboard #form-field-year').find("option:selected").attr('value'), nonce: user_object.nonce},
            success: function(response) {
                if(response.type == "success") {
                    table.find('.elementor-shortcode').html('');
                    table.find('.elementor-shortcode').html(response.data);
                    jQuery('#kpi_loading').css('display','none');
                    jQuery('#display_name .elementor-widget-container .elementor-heading-title').html(response.user_dname);
                    jQuery('#other_info .elementor-widget-container .elementor-icon-list-item:nth-child(1) .elementor-icon-list-text').html(response.mp_user_team);
                    jQuery('#other_info .elementor-widget-container .elementor-icon-list-item:nth-child(2) .elementor-icon-list-text').html(response.job_description);
                    jQuery('#other_info .elementor-widget-container .elementor-icon-list-item:nth-child(3) .elementor-icon-list-text').html(response.reports_to);
                    if(jQuery('.kpi-score').length){
                        var kpiscore = 0;
                            jQuery(".quarter-score>strong").each(function(){
                            kpiscore  += parseFloat(jQuery(this).html());
                            //console.log(parseFloat(jQuery(this).html()));
                        });
                        kpiscore = kpiscore / jQuery(".quarter-score>strong").length;
                        jQuery('.kpi-score') .html(kpiscore.toFixed(2));
                        //console.log(jQuery(".quarter-score>strong").length)
                        if(jQuery(".quarter-score>strong").length <= 4 && response.role !== user_object.role){
                            var bt = jQuery("<div class='add_kpi_entry'>")
                            bt.append('<a href="#" class="lnk_new_entry">Add KPI Quarter '+(jQuery(".quarter-score>strong").length + 1)+'</a>')
                            jQuery('#kpi_loading').css('display','none');
                            table.find('.elementor-shortcode').append(bt)
                            jQuery('#control_table .elementor-shortcode form').each(function(){
                                jQuery(this).addClass('allowedit');
                            })                                
                        }
                    }
                }else{
                 table.find('.elementor-shortcode').html('');      
                 jQuery('#kpi_loading').css('display','none');
                    jQuery('#display_name .elementor-widget-container .elementor-heading-title').html(response.user_dname);
                    jQuery('#other_info .elementor-widget-container .elementor-icon-list-item:nth-child(1) .elementor-icon-list-text').html(response.mp_user_team);
                    jQuery('#other_info .elementor-widget-container .elementor-icon-list-item:nth-child(2) .elementor-icon-list-text').html(response.job_description);
                    jQuery('#other_info .elementor-widget-container .elementor-icon-list-item:nth-child(3) .elementor-icon-list-text').html(response.reports_to);
                 var ntr = jQuery('<div class="norecord">')
                 ntr.append('<div class="py-1 px-2 text-center">No Record found</div>')
                 table.find('.elementor-shortcode').html(ntr)
                    if(jQuery(".quarter-score>strong").length <= 4 && response.role !== user_object.role){
                        var bt = jQuery("<div class='add_kpi_entry'>")
                        bt.append('<a href="#" class="lnk_new_entry">Add KPI Quarter '+(jQuery(".quarter-score>strong").length + 1)+'</a>')
                        jQuery('#kpi_loading').css('display','none');
                        table.find('.elementor-shortcode').append(bt)
                        jQuery('#control_table .elementor-shortcode form').each(function(){
                            jQuery(this).addClass('allowedit');
                        })                            
                    }

                }
                detectform();
            }
    });                
    
});

if( jQuery('#elproductivity').length )         // use this if you are using id to check
{
     var productivity = totProdTime * 86400 / 60 / 540 * 100;

     if(productivity > 100){
      productivity = 100;
     }

     var nonprod = 100 - productivity;
     jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2) + "%");
     jQuery('#bxnonprod > div.elementor-widget-container').html(nonprod.toFixed(2) + "%");
}

   jQuery("#elementor-tab-title-3833").click( function(e) {
      e.preventDefault(); 
      if(jQuery('#team_memberlist').length){
      u_id = jQuery('#daily_memselect #team_memberlist').find("option:selected").attr('value');
      }else{
      u_id = user_object.userid;
      }
      nonce = user_object.nonce;
      jQuery('.caption').html(jQuery('#daily_memselect #team_memberlist').find("option:selected").text()+' Daily Production Summary');

     jQuery('#elproductivity > div.elementor-widget-container').html(0 + "%");
     jQuery('#bxnonprod > div.elementor-widget-container').html(100 + "%");              

      var table = jQuery('#table-list');
           // Emptying the Table items
       table.find('tbody').html('');

     var tr = jQuery('<tr>')
     tr.append('<th class="py-1 px-2 text-center" colspan="6">Loading Data...</th>')
     table.find('tbody').append(tr)

      totProdTime = 0;
      efficiency = 0;
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : user_object.ajaxurl,
         data : {action: "guser_daily_production", u_id : u_id, nonce: nonce,date:jQuery('#date_picks #form-field-dateselect').val()},
         success: function(response) {
            if(response.type == "success") {

          table = jQuery('#table-list');
              // Emptying the Table items
          table.find('tbody').html('');

               if (response.data.length > 0) {
                 // If returned json data is not empty
                 var i = 1;
                 // looping the returned data
                 Object.keys(response.data).map(k => {
                     // creating new table row element
                     var tr = jQuery('<tr>');

                     if(response.data[k].requestType != "Idle Time"){
                        //console.log(response.data[k].timeSpent);
                        if(response.data[k].timeSpent == " "){
                            totProdTime += 0;
                        }else{
                            totProdTime += parseFloat(response.data[k].timeSpent);
                        }

                        if(response.data[k].tatReach == "Within TAT" || response.data[k].tatReach == "Exeeds TAT"){
                           efficiency += parseFloat(response.data[k].tatref) / parseFloat(response.data[k].tatref) * 100;
                           console.log(parseFloat(response.data[k].tatref) / parseFloat(response.data[k].tat) * 100);
                           console.log(efficiency);
                        }
                       
                     }
                      var text = (jQuery.trim(response.data[k].issueKey) != '') ? response.data[k].issueKey + ' | ' + response.data[k].requestType : response.data[k].requestType;

                         // first column data
                     //tr.append('<td class="py-1 px-2">' + response.data[k].rowId + '</td>')
                         // third column data
                     tr.append('<td class="py-1 px-2">' + text +'</td>')
                         // fourth column data
                     tr.append('<td class="py-1 px-2">' + response.data[k].status + '</td>')
                         // fifth column data
                     tr.append('<td class="py-1 px-2" rel="'+response.data[k].timeSpent+'">' + time_stamp_to_hms(response.data[k].timeSpent) + '</td>')
                         // sixth column data
                     tr.append('<td class="py-1 px-2">' + response.data[k].priority + '</td>')
                     tr.append('<td class="py-1 px-2">' + response.data[k].tatref + '</td>')                      

                     tr.append('<td class="py-1 px-2">' + response.data[k].tatReach + '</td>')
                     // Append table row item to table body
                     table.find('tbody').append(tr)
                 });
                 console.log(totProdTime);
                 var productivity = totProdTime * 24;

                 //if(productivity > 100){
                  //productivity = 100;
                 //}
                 var nonprod = 9 - productivity;
                 jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2));
                 if(user_object.role == "Member"){
                    if(efficiency > 100){
                        efficiency = 100;
                    }
                    jQuery('#bxnonprod > div.elementor-widget-container').html(efficiency.toFixed(2));
                 }else{
                    jQuery('#bxnonprod > div.elementor-widget-container').html(efficiency.toFixed(2));
                 }

               } else {
                 // If returned json data is empty
                 tr = jQuery('<tr>')
                 tr.append('<th class="py-1 px-2 text-center" colspan="6">No data to display</th>')
                 table.find('tbody').append(tr)
               }

            }
            else {
                table = jQuery('#table-list');
                    // Emptying the Table items
                table.find('tbody').html('');
                 tr = jQuery('<tr>')
                 tr.append('<td class="py-1 px-2 text-center" colspan="6">No data to display</td>')
                 table.find('tbody').append(tr)
            }
         }
      });  

   });

    jQuery("#elementor-tab-title-3832").click( function(e) {
      e.preventDefault();
      jQuery('#m_prod_rate').css('display','none');
      jQuery('#m_nonprod_rate').css('display','none');
      jQuery('#m_unplanned_leave_rate').css('display','none');
      jQuery('#m_schedule_adherance').css('display','none');

      jQuery('#m_prod_rate').removeClass('card-target-meet').removeClass('card-target-not-meet');
      jQuery('#m_nonprod_rate').removeClass('card-target-meet').removeClass('card-target-not-meet');
      jQuery('#m_unplanned_leave_rate').removeClass('card-target-meet').removeClass('card-target-not-meet');      
      jQuery('#m_schedule_adherance').removeClass('card-target-meet').removeClass('card-target-not-meet');

        jQuery("#tot_tat .elementor-widget-container p").html(0);
        jQuery("#avg_tat_min .elementor-widget-container p").html(0);
        jQuery("#tot_exeed_tat .elementor-widget-container p").html(0);
        jQuery("#tot_within_tat .elementor-widget-container p").html(0);
        jQuery("#tot_completed_task .elementor-widget-container p").html(0);
        jQuery("#daily_avg_completed_tast .elementor-widget-container p").html(0);
        jQuery("#hourly_avg_completed_task .elementor-widget-container p").html(0);
        
      
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "guser_montly_production", u_id : jQuery('#monthly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#monthly_memselect #form-field-year').find("option:selected").attr('value'),month:jQuery('#monthly_memselect #form-field-month').find("option:selected").attr('value'), nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                Object.keys(response.data).map(k => {
                                 // creating new table row element
                                 if(parseFloat(response.data[k].productivity) > 71){
                                    jQuery('#m_prod_rate').addClass('card-target-meet');
                                 }else{
                                    jQuery('#m_prod_rate').addClass('card-target-not-meet');
                                 }
                                 if(parseFloat(response.data[k].nonproductiveRate) < 10){
                                    jQuery('#m_nonprod_rate').addClass('card-target-meet');
                                 }else{
                                    jQuery('#m_nonprod_rate').addClass('card-target-not-meet');
                                 }
                                 if(parseFloat(response.data[k].unplannedLeaveRate) < 3){
                                    jQuery('#m_unplanned_leave_rate').addClass('card-target-meet');
                                 }else{
                                    jQuery('#m_unplanned_leave_rate').addClass('card-target-not-meet');
                                 }
                                 if(parseFloat(response.data[k].scheduleAdherence) > 3){
                                    jQuery('#m_schedule_adherance').addClass('card-target-meet');
                                 }else{
                                    jQuery('#m_schedule_adherance').addClass('card-target-not-meet');
                                 }
                                 jQuery('#m_prod_rate .target-score .elementor-widget-container p').html(response.data[k].productivity.toFixed(2));
                                 jQuery('#m_nonprod_rate .target-score .elementor-widget-container p').html(response.data[k].nonproductiveRate.toFixed(2));
                                 jQuery('#m_unplanned_leave_rate .target-score .elementor-widget-container p').html(response.data[k].unplannedLeaveRate.toFixed(2));
                                 jQuery('#m_schedule_adherance .target-score .elementor-widget-container p').html(response.data[k].scheduleAdherence.toFixed(2));
                                
                                    jQuery("#tot_tat .elementor-widget-container p").html(response.data[k].totalTaskWithTat.toFixed(0));
                                    jQuery("#avg_tat_min .elementor-widget-container p").html(response.data[k].avgTatInMin.toFixed(2));

                                    jQuery("#tot_exeed_tat .elementor-widget-container p").html(response.data[k].totalTaskExeedsTat.toFixed(0));
                                    jQuery("#tot_within_tat .elementor-widget-container p").html(response.data[k].totalTaskWithinTat.toFixed(0));
                                    jQuery("#tot_completed_task .elementor-widget-container p").html(response.data[k].totalCompletedTask.toFixed(0));
                                    jQuery("#daily_avg_completed_tast .elementor-widget-container p").html(response.data[k].dailyAvgCompletedTask.toFixed(0));
                                    jQuery("#hourly_avg_completed_task .elementor-widget-container p").html(response.data[k].hourlyAvgCompletedTask.toFixed(2));                                    

                                });
                            }
                              jQuery('#m_prod_rate').css('display','');
                              jQuery('#m_nonprod_rate').css('display','');
                              jQuery('#m_unplanned_leave_rate').css('display','');
                              jQuery('#m_schedule_adherance').css('display','');                                
                        }
                      }
        }); 

    });


jQuery("#elementor-tab-title-3831").click( function(e) {
      e.preventDefault();
      jQuery('#q_prod_rate').css('display','none');
      jQuery('#q_nonprod_rate').css('display','none');
      jQuery('#q_unplanned_leave_rate').css('display','none');
      jQuery('#q_schedule_adherance').css('display','none');

      jQuery('#q_prod_rate').removeClass('card-target-meet').removeClass('card-target-not-meet');
      jQuery('#q_nonprod_rate').removeClass('card-target-meet').removeClass('card-target-not-meet');
      jQuery('#q_unplanned_leave_rate').removeClass('card-target-meet').removeClass('card-target-not-meet');      
      jQuery('#q_schedule_adherance').removeClass('card-target-meet').removeClass('card-target-not-meet');

        jQuery("#tot_tat .elementor-widget-container p").html(0);
        jQuery("#avg_tat_min .elementor-widget-container p").html(0);
        jQuery("#tot_exeed_tat .elementor-widget-container p").html(0);
        jQuery("#tot_within_tat .elementor-widget-container p").html(0);
        jQuery("#tot_completed_task .elementor-widget-container p").html(0);
        jQuery("#daily_avg_completed_tast .elementor-widget-container p").html(0);
        jQuery("#hourly_avg_completed_task .elementor-widget-container p").html(0);
        jQuery("#q_one_kpi .elementor-widget-container p").html(0.00);
        jQuery("#q_two_kpi .elementor-widget-container p").html(0.00);
        jQuery("#q_three_kpi .elementor-widget-container p").html(0.00);
        jQuery("#q_four_kpi .elementor-widget-container p").html(0.00);
        
        
      
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "guser_quarter_production", u_id : jQuery('#quarterly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#quarterly_memselect #form-field-year').find("option:selected").attr('value'),quarter:jQuery('#quarterly_memselect #form-field-quarter').find("option:selected").attr('value'), nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                Object.keys(response.data).map(k => {
                                 // creating new table row element
                                 if(parseFloat(response.data[k].productivity) > 71){
                                    jQuery('#q_prod_rate').addClass('card-target-meet');
                                 }else{
                                    jQuery('#q_prod_rate').addClass('card-target-not-meet');
                                 }
                                 if(parseFloat(response.data[k].nonproductiveRate) < 10){
                                    jQuery('#q_nonprod_rate').addClass('card-target-meet');
                                 }else{
                                    jQuery('#q_nonprod_rate').addClass('card-target-not-meet');
                                 }
                                 if(parseFloat(response.data[k].unplannedLeaveRate) < 3){
                                    jQuery('#q_unplanned_leave_rate').addClass('card-target-meet');
                                 }else{
                                    jQuery('#q_unplanned_leave_rate').addClass('card-target-not-meet');
                                 }
                                 if(parseFloat(response.data[k].scheduleAdherence) > 3){
                                    jQuery('#q_schedule_adherance').addClass('card-target-meet');
                                 }else{
                                    jQuery('#q_schedule_adherance').addClass('card-target-not-meet');
                                 }
                                 jQuery('#q_prod_rate .target-score .elementor-widget-container p').html(response.data[k].productivity.toFixed(2));
                                 jQuery('#q_nonprod_rate .target-score .elementor-widget-container p').html(response.data[k].nonproductiveRate.toFixed(2));
                                 jQuery('#q_unplanned_leave_rate .target-score .elementor-widget-container p').html(response.data[k].unplannedLeaveRate.toFixed(2));
                                 jQuery('#q_schedule_adherance .target-score .elementor-widget-container p').html(response.data[k].scheduleAdherence.toFixed(1));
                                
                                    jQuery("#q_tot_tat .elementor-widget-container p").html(response.data[k].totalTaskWithTat.toFixed(0));
                                    jQuery("#q_avg_tat_min .elementor-widget-container p").html(response.data[k].avgTatInMin.toFixed(2));

                                    jQuery("#q_tot_exeed_tat .elementor-widget-container p").html(response.data[k].totalTaskExeedsTat.toFixed(0));
                                    jQuery("#q_tot_within_tat .elementor-widget-container p").html(response.data[k].totalTaskWithinTat.toFixed(0));
                                    jQuery("#q_tot_completed_task .elementor-widget-container p").html(response.data[k].totalCompletedTask.toFixed(0));
                                    jQuery("#q_daily_avg_completed_tast .elementor-widget-container p").html(response.data[k].dailyAvgCompletedTask.toFixed(0));
                                    jQuery("#q_hourly_avg_completed_task .elementor-widget-container p").html(response.data[k].hourlyAvgCompletedTask.toFixed(2));                                    

                                    jQuery("#q_one_kpi .elementor-widget-container p").html(response.data[k].q1.toFixed(2));
                                    jQuery("#q_two_kpi .elementor-widget-container p").html(response.data[k].q2.toFixed(2));
                                    jQuery("#q_three_kpi .elementor-widget-container p").html(response.data[k].q3.toFixed(2));
                                    jQuery("#q_four_kpi .elementor-widget-container p").html(response.data[k].q4.toFixed(2));

                                });
                            }
                              jQuery('#q_prod_rate').css('display','');
                              jQuery('#q_nonprod_rate').css('display','');
                              jQuery('#q_unplanned_leave_rate').css('display','');
                              jQuery('#q_schedule_adherance').css('display','');                                
                        }
                      }
        }); 

    });

    jQuery("#elementor-tab-content-3831 #quarterly_memselect #team_memberlist,#elementor-tab-content-3831 #quarterly_memselect #form-field-year,#elementor-tab-content-3831 #quarterly_memselect #form-field-quarter").change( function(e) {

        jQuery("#elementor-tab-title-3831").click();
    })

    jQuery("#elementor-tab-content-3832 #monthly_memselect #team_memberlist,#elementor-tab-content-3832 #monthly_memselect #form-field-year,#elementor-tab-content-3832 #monthly_memselect #form-field-month").change( function(e) {
        jQuery("#elementor-tab-title-3832").click();
    })


    jQuery("#elementor-tab-content-3833 #daily_memselect #team_memberlist,#elementor-tab-content-3833 #daily_memselect #form-field-dateselect").change( function(e) {
        //jQuery('#monthly_memselect #team_memberlist')
        //jQuery('#daily_memselect #team_memberlist').find("option:selected").attr('value');
        console.log(jQuery('#daily_memselect #team_memberlist').find("option:selected").attr('value'));
        jQuery("#elementor-tab-title-3833").click();
    })



    window.addEventListener( 'elementor/popup/show', ( event )=>{
        const id = event.detail.id;
        const instance = event.detail.instance;
        if( id === 4050 ) {
            // do your magic here

            var table = jQuery('.monthly-prod-dashboard');
               // Emptying the Table items
            table.find('tbody').html('');

            var tr = jQuery('<tr class="prod-met">')
            tr.append('<td class="py-1 px-2 text-center" colspan="3">Loading Data...</td>')
            table.find('tbody').append(tr)

            jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : user_object.ajaxurl,
                 data : {action: "guser_montly_production_full", u_id : jQuery('#monthly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#monthly_memselect #form-field-year').find("option:selected").attr('value'),month:jQuery('#monthly_memselect #form-field-month').find("option:selected").attr('value'), nonce: user_object.nonce},
                 success: function(response) {
                            if(response.type == "success") {
                                if (response.data.length > 0) {
                                    
                                    table.find('tbody').html('');
                                    if (response.data.length > 0) {
                                     // If returned json data is not empty
                                     var i = 1;
                                     // looping the returned data
                                     Object.keys(response.data).map(k => {
                                         // creating new table row element
                                         if((response.data[k].actualProductivity * 100).toFixed(2) < 80){
                                            var tr = jQuery('<tr class="prod-not-met">');
                                         }else{
                                            var tr = jQuery('<tr class="prod-met">');
                                         }

                                         if(response.data[k].requestType != "Idle Time"){
                                           totProdTime += response.data[k].timeSpent;
                                         }

                                            var spd = new Date(response.data[k].date);
                                            xspd = spd.toLocaleDateString("en-US").split('/')
                                            

                                             // first column data
                                         tr.append('<td data-label="Date">' + xspd[2] + "-" + xspd[0] + "-" + xspd[1] + '</td>')
                                             // third column data
                                         //tr.append('<td data-label="Utilisation">' + (response.data[k].utilization * 100).toFixed(2) + "%" + '</td>')
                                             // fourth column data
                                         tr.append('<td data-label="Expected Productivity">' + (response.data[k].expectedProductivity * 100).toFixed(2) + "%" + '</td>')
                                             // fifth column data
                                         tr.append('<td data-label="Actual Productivity" rel="' + response.data[k].actualProductivity +'">' + response.data[k].actualProductivity.toFixed(2) + "%" + '</td>')
                                             // sixth column data
                                         table.find('tbody').append(tr)
                                     });
                                    getPagination('#monthtable');
//                                     jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2) + "%");
//                                     jQuery('#bxnonprod > div.elementor-widget-container').html(nonprod.toFixed(2) + "%");              
                                     } else {
                                     // If returned json data is empty
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<th class="py-1 px-2 text-center" colspan="3">No data to display</th>')
                                     table.find('tbody').append(tr)
                                     }

                                 }else{
                                        // Emptying the Table items
                                     table.find('tbody').html('');
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<td class="py-1 px-2 text-center" colspan="3">No data to display</td>')
                                     table.find('tbody').append(tr)
                                 }

                            }else{
                             table.find('tbody').html('');
                             tr = jQuery('<tr class="prod-met">')
                             tr.append('<td class="py-1 px-2 text-center" colspan="3">No data to display</td>')
                             table.find('tbody').append(tr)
                            }
                          }
            });
        }else if( id === 4084 ){
            var table = jQuery('.monthly-prod-dashboard');
               // Emptying the Table items
            table.find('tbody').html('');

            var tr = jQuery('<tr class="prod-met">')
            tr.append('<td class="py-1 px-2 text-center" colspan="5">Loading Data...</td>')
            table.find('tbody').append(tr)
            jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : user_object.ajaxurl,
                 data : {action: "guser_montly_non_production_full", u_id : jQuery('#monthly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#monthly_memselect #form-field-year').find("option:selected").attr('value'),month:jQuery('#monthly_memselect #form-field-month').find("option:selected").attr('value'), nonce: user_object.nonce},
                 success: function(response) {
                            if(response.type == "success") {
                                if (response.data.length > 0) {
                                    
                                    table.find('tbody').html('');
                                    if (response.data.length > 0) {
                                     // If returned json data is not empty
                                     var i = 1;
                                     // looping the returned data
                                     Object.keys(response.data).map(k => {
                                         // creating new table row element
                                         if((response.data[k].utilization * 100).toFixed(2) < 80){
                                            var tr = jQuery('<tr class="prod-not-met">');
                                         }else{
                                            var tr = jQuery('<tr class="prod-met">');
                                         }

                                         if(response.data[k].requestType != "Idle Time"){
                                           totProdTime += response.data[k].timeSpent;
                                         }

                                            var spd = new Date(response.data[k].date);
                                            xspd = spd.toLocaleDateString("en-US").split('/')
                                            

                                             // first column data
                                         tr.append('<td data-label="Date">' + xspd[2] + "-" + xspd[0] + "-" + xspd[1] + '</td>')
                                             // third column data
                                         tr.append('<td data-label="Utilisation">' + (response.data[k].utilization * 100).toFixed(2) + "%" + '</td>')
                                             // fourth column data
                                         tr.append('<td data-label="TARGET UTILIZATION">' + (response.data[k].targetUtilization * 100).toFixed(2) + "%" + '</td>')
                                             // fifth column data
                                         tr.append('<td data-label="PRODUCTIVITY" rel="' + response.data[k].productivity +'">' + (100 - (response.data[k].utilization * 100)).toFixed(2) + "%" + '</td>')
                                             // sixth column data
                                         tr.append('<td data-label="LOST HOURS" rel="' + response.data[k].avgLostHours  +'">' + (response.data[k].avgLostHours / 60).toFixed(2) + '</td>')
                                             // sixth column data
                                         table.find('tbody').append(tr)
                                     });
                                    getPagination('#monthtable');
            //                                     jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2) + "%");
            //                                     jQuery('#bxnonprod > div.elementor-widget-container').html(nonprod.toFixed(2) + "%");              
                                     } else {
                                     // If returned json data is empty
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<th class="py-1 px-2 text-center" colspan="5">No data to display</th>')
                                     table.find('tbody').append(tr)
                                     }

                                 }else{
                                        // Emptying the Table items
                                     table.find('tbody').html('');
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<td class="py-1 px-2 text-center" colspan="5">No data to display</td>')
                                     table.find('tbody').append(tr)
                                 }

                            }else{
                             table.find('tbody').html('');
                             tr = jQuery('<tr class="prod-met">')
                             tr.append('<td class="py-1 px-2 text-center" colspan="4">No data to display</td>')
                             table.find('tbody').append(tr)
                            }
                          }
            });            
        }else if( id === 4177 ){
            var table = jQuery('.monthly-prod-dashboard');
               // Emptying the Table items
            table.find('tbody').html('');

            var tr = jQuery('<tr class="prod-met">')
            tr.append('<td class="py-1 px-2 text-center" colspan="4">Loading Data...</td>')
            table.find('tbody').append(tr)
            jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : user_object.ajaxurl,
                 data : {action: "guser_montly_unplanned_leave_full", u_id : jQuery('#monthly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#monthly_memselect #form-field-year').find("option:selected").attr('value'),month:jQuery('#monthly_memselect #form-field-month').find("option:selected").attr('value'), nonce: user_object.nonce},
                 success: function(response) {
                            if(response.type == "success") {
                                if (response.data.length > 0) {
                                    
                                    table.find('tbody').html('');
                                    if (response.data.length > 0) {
                                     // If returned json data is not empty
                                     var i = 1;
                                     // looping the returned data
                                     Object.keys(response.data).map(k => {
                                         // creating new table row element
                                            var tr = jQuery('<tr class="prod-not-met">');

                                         if(response.data[k].requestType != "Idle Time"){
                                           totProdTime += response.data[k].timeSpent;
                                         }

                                            var spd = new Date(response.data[k].date);
                                            xspd = spd.toLocaleDateString("en-US").split('/')
                                            

                                             // first column data
                                         tr.append('<td data-label="Date">' + xspd[2] + "-" + xspd[0] + "-" + xspd[1] + '</td>')
                                             // third column data
                                         tr.append('<td data-label="Name">' + response.data[k].name + '</td>')
                                             // fourth column data
                                         tr.append('<td data-label="TARGET UTILIZATION">' + response.data[k].status + '</td>')
                                             // fifth column data
                                         tr.append('<td data-label="PRODUCTIVITY" rel="' + response.data[k].attendanceRating +'">' + response.data[k].attendanceRating + '</td>')
                                             // sixth column data
                                         //tr.append('<td data-label="LOST HOURS" rel="' + response.data[k].avgLostHours  +'">' + (response.data[k].avgLostHours / 60).toFixed(2) + '</td>')
                                             // sixth column data
                                         table.find('tbody').append(tr)
                                     });
                                    getPagination('#monthtable');
            //                                     jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2) + "%");
            //                                     jQuery('#bxnonprod > div.elementor-widget-container').html(nonprod.toFixed(2) + "%");              
                                     } else {
                                     // If returned json data is empty
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<th class="py-1 px-2 text-center" colspan="4">No data to display</th>')
                                     table.find('tbody').append(tr)
                                     }

                                 }else{
                                        // Emptying the Table items
                                     table.find('tbody').html('');
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<td class="py-1 px-2 text-center" colspan="4">No data to display</td>')
                                     table.find('tbody').append(tr)
                                 }

                            }else{
                             table.find('tbody').html('');
                             tr = jQuery('<tr class="prod-met">')
                             tr.append('<td class="py-1 px-2 text-center" colspan="4">No data to display</td>')
                             table.find('tbody').append(tr)
                            }
                          }
            });
        }else if( id === 4178 ){
            var table = jQuery('.monthly-prod-dashboard');
               // Emptying the Table items
            table.find('tbody').html('');

            var tr = jQuery('<tr class="prod-met">')
            tr.append('<td class="py-1 px-2 text-center" colspan="4">Loading Data...</td>')
            table.find('tbody').append(tr)
            jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : user_object.ajaxurl,
                 data : {action: "guser_montly_schedule_adherence_full", u_id : jQuery('#monthly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#monthly_memselect #form-field-year').find("option:selected").attr('value'),month:jQuery('#monthly_memselect #form-field-month').find("option:selected").attr('value'), nonce: user_object.nonce},
                 success: function(response) {
                            if(response.type == "success") {
                                if (response.data.length > 0) {
                                    
                                    table.find('tbody').html('');
                                    if (response.data.length > 0) {
                                     // If returned json data is not empty
                                     var i = 1;
                                     // looping the returned data
                                     Object.keys(response.data).map(k => {
                                         // creating new table row element
                                         if(response.data[k].attendanceRating < 5){
                                            var tr = jQuery('<tr class="prod-not-met">');
                                         }else{
                                            var tr = jQuery('<tr class="prod-met">');
                                         }                                         

                                         if(response.data[k].requestType != "Idle Time"){
                                           totProdTime += response.data[k].timeSpent;
                                         }

                                            var spd = new Date(response.data[k].date);
                                            xspd = spd.toLocaleDateString("en-US").split('/')
                                            

                                             // first column data
                                         tr.append('<td data-label="Date">' + xspd[2] + "-" + xspd[0] + "-" + xspd[1] + '</td>')
                                             // third column data
                                         tr.append('<td data-label="Name">' + response.data[k].name + '</td>')
                                             // fourth column data
                                         tr.append('<td data-label="Status">' + response.data[k].status + '</td>')
                                             // fifth column data
                                         tr.append('<td data-label="Attendance Rating" rel="' + response.data[k].attendanceRating +'">' + response.data[k].attendanceRating + '</td>')
                                             // sixth column data
                                         //tr.append('<td data-label="LOST HOURS" rel="' + response.data[k].avgLostHours  +'">' + (response.data[k].avgLostHours / 60).toFixed(2) + '</td>')
                                             // sixth column data
                                         table.find('tbody').append(tr)
                                     });
                                    getPagination('#monthtable');
            //                                     jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2) + "%");
            //                                     jQuery('#bxnonprod > div.elementor-widget-container').html(nonprod.toFixed(2) + "%");              
                                     } else {
                                     // If returned json data is empty
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<th class="py-1 px-2 text-center" colspan="4">No data to display</th>')
                                     table.find('tbody').append(tr)
                                     }

                                 }else{
                                        // Emptying the Table items
                                     table.find('tbody').html('');
                                     tr = jQuery('<tr class="prod-met">')
                                     tr.append('<td class="py-1 px-2 text-center" colspan="4">No data to display</td>')
                                     table.find('tbody').append(tr)
                                 }

                            }else{
                             table.find('tbody').html('');
                             tr = jQuery('<tr class="prod-met">')
                             tr.append('<td class="py-1 px-2 text-center" colspan="4">No data to display</td>')
                             table.find('tbody').append(tr)
                            }
                          }
            });            
        }else if( id === 4251 ){
            var table = jQuery('.monthly-exeed-tat');
            // Emptying the Table items
            table.find('tbody').html('');

            var tr = jQuery('<tr>');
            tr.append('<td class="py-1 px-2 text-center" colspan="5">Loading Data...</td>');
            table.find('tbody').append(tr);

            jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : user_object.ajaxurl,
                 data : {action: "guser_montly_exeed_tat", u_id : jQuery('#monthly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#monthly_memselect #form-field-year').find("option:selected").attr('value'),month:jQuery('#monthly_memselect #form-field-month').find("option:selected").attr('value'), nonce: user_object.nonce},
                 success: function(response) {
                            if(response.type == "success") {
                                if (response.data.length > 0) {
                                    
                                    table.find('tbody').html('');
                                    if (response.data.length > 0) {
                                     // If returned json data is not empty
                                     var i = 1;
                                     // looping the returned data
                                     Object.keys(response.data).map(k => {
                                         // creating new table row element
                                        var tr = jQuery('<tr>');
                                         if(response.data[k].requestType != "Idle Time"){
                                           totProdTime += response.data[k].timeSpent;
                                         }

                                            var spd = new Date(response.data[k].date);
                                            xspd = spd.toLocaleDateString("en-US").split('/');
                                            

                                             // first column data
                                         tr.append('<td data-label="spoon">' + response.data[k].spon + '</td>');
                                             // third column data
                                         tr.append('<td data-label="tasks-type">' + response.data[k].taskType + '</td>');
                                             // fourth column data
                                         tr.append('<td data-label="complexity">' + response.data[k].priority + '</td>');
                                             // fifth column data
                                         tr.append('<td data-label="time-spent" rel="' + response.data[k].timeSpent +'">' + time_stamp_to_hms(response.data[k].timeSpent) + '</td>');
                                             // sixth column data
                                         tr.append('<td data-label="acceptable-tat" rel="' + response.data[k].tatref  +'">' + response.data[k].tatref + ' Minutes</td>');
                                             // sixth column data
                                         table.find('tbody').append(tr);
                                     });
                                    getPagination('#tablelist');
            //                                     jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2) + "%");
            //                                     jQuery('#bxnonprod > div.elementor-widget-container').html(nonprod.toFixed(2) + "%");              
                                     } else {
                                     // If returned json data is empty
                                     tr = jQuery('<tr>');
                                     tr.append('<th class="py-1 px-2 text-center" colspan="5">No data to display</th>');
                                     table.find('tbody').append(tr);
                                     }

                                 }else{
                                        // Emptying the Table items
                                     table.find('tbody').html('');
                                     tr = jQuery('<tr>');
                                     tr.append('<td class="py-1 px-2 text-center" colspan="5">No data to display</td>');
                                     table.find('tbody').append(tr);
                                 }

                            }else{
                             table.find('tbody').html('');
                             tr = jQuery('<tr>');
                             tr.append('<td class="py-1 px-2 text-center" colspan="5">No data to display</td>');
                             table.find('tbody').append(tr);
                            }
                          }
            }); 

        }else if( id === 4291 ){
            var table = jQuery('.monthly-exeed-tat');
            // Emptying the Table items
            table.find('tbody').html('');

            var tr = jQuery('<tr>');
            tr.append('<td class="py-1 px-2 text-center" colspan="5">Loading Data...</td>');
            table.find('tbody').append(tr);

            jQuery.ajax({
                 type : "post",
                 dataType : "json",
                 url : user_object.ajaxurl,
                 data : {action: "guser_montly_exeed_tat", u_id : jQuery('#quarterly_memselect #team_memberlist').find("option:selected").attr('value'),g_year: jQuery('#quarterly_memselect #form-field-year').find("option:selected").attr('value'),quarter:jQuery('#quarterly_memselect #form-field-quarter').find("option:selected").attr('value'), nonce: user_object.nonce},
                 success: function(response) {
                            if(response.type == "success") {
                                if (response.data.length > 0) {
                                    
                                    table.find('tbody').html('');
                                    if (response.data.length > 0) {
                                     // If returned json data is not empty
                                     var i = 1;
                                     // looping the returned data
                                     Object.keys(response.data).map(k => {
                                         // creating new table row element
                                        var tr = jQuery('<tr>');
                                         if(response.data[k].requestType != "Idle Time"){
                                           totProdTime += response.data[k].timeSpent;
                                         }

                                            var spd = new Date(response.data[k].date);
                                            xspd = spd.toLocaleDateString("en-US").split('/');
                                            

                                             // first column data
                                         tr.append('<td data-label="spoon">' + response.data[k].spon + '</td>');
                                             // third column data
                                         tr.append('<td data-label="tasks-type">' + response.data[k].taskType + '</td>');
                                             // fourth column data
                                         tr.append('<td data-label="complexity">' + response.data[k].priority + '</td>');
                                             // fifth column data
                                         tr.append('<td data-label="time-spent" rel="' + response.data[k].timeSpent +'">' + time_stamp_to_hms(response.data[k].timeSpent) + '</td>');
                                             // sixth column data
                                         tr.append('<td data-label="acceptable-tat" rel="' + response.data[k].tatref  +'">' + response.data[k].tatref + ' Minutes</td>');
                                             // sixth column data
                                         table.find('tbody').append(tr);
                                     });
                                    getPagination('#tablelist');
            //                                     jQuery('#elproductivity > div.elementor-widget-container').html(productivity.toFixed(2) + "%");
            //                                     jQuery('#bxnonprod > div.elementor-widget-container').html(nonprod.toFixed(2) + "%");              
                                     } else {
                                     // If returned json data is empty
                                     tr = jQuery('<tr>');
                                     tr.append('<th class="py-1 px-2 text-center" colspan="5">No data to display</th>');
                                     table.find('tbody').append(tr);
                                     }

                                 }else{
                                        // Emptying the Table items
                                     table.find('tbody').html('');
                                     tr = jQuery('<tr>');
                                     tr.append('<td class="py-1 px-2 text-center" colspan="5">No data to display</td>');
                                     table.find('tbody').append(tr);
                                 }

                            }else{
                             table.find('tbody').html('');
                             tr = jQuery('<tr>');
                             tr.append('<td class="py-1 px-2 text-center" colspan="5">No data to display</td>');
                             table.find('tbody').append(tr);
                            }
                          }
            }); 

        }

    })


});

function time_stamp_to_hms(t){
   var hours = t * 24;
   var h = hours;
   var hwhole = Math.floor(h);      // 1
   var minfraction = h - hwhole; // .25

   var minutes = minfraction * 60;
   var m = minutes;
   var mwhole = Math.floor(m);      // 1
   var secfraction = m - mwhole; // .25

   var secods = secfraction * 60;
   var s = secods;
   var swhole = Math.floor(s);      // 1

   return hwhole + ":" + mwhole + ":" + swhole;
}
////////////////////////////////////////////////////////////////////////////////////////
function getPagination(table) {
  var lastPage = 1;

  jQuery('#maxRows')
    .on('change', function(evt) {
      //$('.paginationprev').html('');                      // reset pagination

     lastPage = 1;
      jQuery('.pagination')
        .find('li')
        .slice(1, -1)
        .remove();
      var trnum = 0; // reset tr counter
      var maxRows = parseInt(jQuery(this).val()); // get Max Rows from select option

      if (maxRows == 5000) {
        jQuery('.pagination').hide();
      } else {
        jQuery('.pagination').show();
      }

      var totalRows = jQuery(table + ' tbody tr').length; // numbers of rows
      jQuery(table + ' tr:gt(0)').each(function() {
        // each TR in  table and not the header
        trnum++; // Start Counter
        if (trnum > maxRows) {
          // if tr number gt maxRows

          jQuery(this).hide(); // fade it out
        }
        if (trnum <= maxRows) {
          jQuery(this).show();
        } // else fade in Important in case if it ..
      }); //  was fade out to fade it in
      if (totalRows > maxRows) {
        // if tr total rows gt max rows option
        var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
        //  numbers of pages
        for (var i = 1; i <= pagenum; ) {
          // for each page append pagination li
          jQuery('.pagination #prev')
            .before(
              '<li data-page="' +
                i +
                '">\
                                  <span>' +
                i++ +
                '<span class="sr-only">(current)</span></span>\
                                </li>'
            )
            .show();
        } // end for i
      } // end if row count > max rows
      jQuery('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
      jQuery('.pagination li').on('click', function(evt) {
        // on click each page
        evt.stopImmediatePropagation();
        evt.preventDefault();
        var pageNum = jQuery(this).attr('data-page'); // get it's number

        var maxRows = parseInt(jQuery('#maxRows').val()); // get Max Rows from select option

        if (pageNum == 'prev') {
          if (lastPage == 1) {
            return;
          }
          pageNum = --lastPage;
        }
        if (pageNum == 'next') {
          if (lastPage == jQuery('.pagination li').length - 2) {
            return;
          }
          pageNum = ++lastPage;
        }

        lastPage = pageNum;
        var trIndex = 0; // reset tr counter
        jQuery('.pagination li').removeClass('active'); // remove active class from all li
        jQuery('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
        // jQuery(this).addClass('active');                  // add active class to the clicked
        limitPagging();
        jQuery(table + ' tr:gt(0)').each(function() {
          // each tr in table not the header
          trIndex++; // tr index counter
          // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
          if (
            trIndex > maxRows * pageNum ||
            trIndex <= maxRows * pageNum - maxRows
          ) {
            jQuery(this).hide();
          } else {
            jQuery(this).show();
          } //else fade in
        }); // end of for each tr in table
      }); // end of on click pagination list
      limitPagging();
    })
    .val(10)
    .change();

  // end of on select change

  // END OF PAGINATION
}

function limitPagging(){
    // alert(jQuery('.pagination li').length)

    if(jQuery('.pagination li').length > 7 ){
            if( jQuery('.pagination li.active').attr('data-page') <= 3 ){
            jQuery('.pagination li:gt(5)').hide();
            jQuery('.pagination li:lt(5)').show();
            jQuery('.pagination [data-page="next"]').show();
        }if (jQuery('.pagination li.active').attr('data-page') > 3){
            jQuery('.pagination li:gt(0)').hide();
            jQuery('.pagination [data-page="next"]').show();
            for( let i = ( parseInt(jQuery('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt(jQuery('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
                jQuery('.pagination [data-page="'+i+'"]').show();

            }

        }
    }
}

function animateValue(obj, start, end, duration) {
  let startTimestamp = null;
  const step = (timestamp) => {
    if (!startTimestamp) startTimestamp = timestamp;
    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
    obj.innerHTML = Math.floor(progress * (end - start) + start);
    if (progress < 1) {
      window.requestAnimationFrame(step);
    }
  };
  window.requestAnimationFrame(step);
}

function detectform(){
    if(jQuery('#control_table form').length == 4){
        jQuery('.add_kpi_entry').hide();
    }
}