


(function($){
  var _tab = "Over All KPI";
  jQuery(document).ready(function(){
    if(jQuery('.datecontainer').length){
        jQuery('.datecontainer').append(jQuery('#date_picks'));
    }

    setTimeout( function(){ 
        jQuery('.flatpickr-input').each(function(){ 
                flatpickr( jQuery(this)[0],{
                                maxDate: "today",
                                mode: "range",
                                onClose: function(selectedDates, dateStr, instance) {
                                    jQuery("#elementor-tab-title-2561").click();
                                }
                            });
            }); 
    }, 1000 );
    jQuery('.elementor-tab-content.elementor-active .prod-boxes').hide();
    jQuery('.elementor-tab-content.elementor-active .team-overall-task-block').hide();        
    jQuery('.elementor-tab-content.elementor-active .grand-total-block').hide();
    jQuery('.elementor-tab-content.elementor-active .graph-block').hide(); 
    setTimeout(function() {
      jQuery("#elementor-tab-title-2561").click();
    },500);

    jQuery('#elementor-tab-content-2561 #team-list').change(function (e){
        jQuery("#elementor-tab-title-2561").click();
        jQuery(".teamcaption h5").html(jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val());
    });

    jQuery('#elementor-tab-content-2562 #form-field-year, #elementor-tab-content-2562 #form-field-month, #elementor-tab-content-2562 #team-list').change(function (e){
        jQuery("#elementor-tab-title-2562").click();
        jQuery(".teamcaption h5").html(jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val());
    });


    jQuery("#elementor-tab-content-2563 #form-field-year, #elementor-tab-content-2563 #form-field-quarter, #elementor-tab-content-2563 #team-list").change( function(e) {
        jQuery("#elementor-tab-title-2563").click();
        jQuery(".teamcaption h5").html(jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val());
    })

    jQuery("#elementor-tab-content-2564 #form-field-year, #elementor-tab-content-2564 #form-field-quarter, #elementor-tab-content-2564 #team-list").change( function(e) {
        jQuery("#elementor-tab-title-2564").click();
        jQuery(".teamcaption h5").html(jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val());
    })



    jQuery("#elementor-tab-title-2561").click( function(e) {
        _tab = 'Over All KPI Team';
        setTimeout( function(){
        jQuery('.elementor-tab-content.elementor-active .prod-boxes').hide();
        jQuery('.elementor-tab-content.elementor-active .team-overall-task-block').hide();        
        jQuery('.elementor-tab-content.elementor-active .grand-total-block').hide();
        jQuery('.elementor-tab-content.elementor-active .graph-block').hide();        
        production_overallkpi_dailyweekly();
        }, 1000 );
    });

    jQuery("#elementor-tab-title-2562").click( function(e) {
        _tab = 'Over All KPI Team';
        setTimeout( function(){
        jQuery('.elementor-tab-content.elementor-active .prod-boxes').hide();
        jQuery('.elementor-tab-content.elementor-active .team-overall-task-block').hide();        
        jQuery('.elementor-tab-content.elementor-active .grand-total-block').hide();
        jQuery('.elementor-tab-content.elementor-active .graph-block').hide();        
        production_overallkpi();
        }, 1000 );        
    });

    jQuery("#elementor-tab-title-2563").click( function(e) {
        _tab = 'Over All KPI Team';
        setTimeout( function(){
        jQuery('.elementor-tab-content.elementor-active .prod-boxes').hide();    
        jQuery('.elementor-tab-content.elementor-active .team-overall-task-block').hide();        
        jQuery('.elementor-tab-content.elementor-active .grand-total-block').hide();
        jQuery('.elementor-tab-content.elementor-active .graph-block').hide();        
        production_quarterly_overallkpi();
        }, 1000 );        
    });

    jQuery("#elementor-tab-title-2564").click( function(e) {
        _tab = 'Team Yearly Performance';
        jQuery(".y-team-yearly-performance-block").hide();
        jQuery(".y-total-revisions").hide();
        jQuery(".y-total-completed-task").hide();
        jQuery(".y-utilization-per-month").hide();
        jQuery(".y-productivity-rev-vs-task").hide();
        jQuery(".y-non-prod-per-month").hide();
        q_team_yearly_performance();
    });



    function production_overallkpi_dailyweekly(){
        jQuery('#productivity h2').html('<div class="loader"></div>');
        jQuery('#non_productivity h2').html('<div class="loader"></div>');
        jQuery('#unplanned_leave h2').html('<div class="loader"></div>');
        jQuery('#schedule_adherence h2').html('<div class="loader"></div>');
        jQuery('#utilisation h2').html('<div class="loader"></div>');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper .elementor-tab-content.elementor-active .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper .elementor-tab-content.elementor-active .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');
        jQuery('.tat_info').hide();
        jQuery('.task_info').hide();
        jQuery('.dm-only-section').hide();
        jQuery('.dm-only-section-two').hide();
        jQuery('.team-overall-task-block').hide();        
        jQuery('.grand-total-block').hide();
        jQuery('.graph-block').hide();
        jQuery('.task_info .task_completed_block').hide();
        jQuery('.task_info .revision_tasks_block').hide();
        jQuery('.task_info .revision_tasks_block_two').hide();
        jQuery('.task_info .rev_sip').hide();        

        if( jQuery('.elementor-tab-content.elementor-active #team-list').length ) {
            g_mp_user_team = jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val();
        }else{
            g_mp_user_team = user_object.mp_user_team
        }

        if(g_mp_user_team != ""){
            jQuery('.elementor-tab-content.elementor-active .prod-boxes').show();    
        }        

        var date1 = new Date();
        var date2 = new Date();

        if( jQuery('.elementor-tab-content.elementor-active #form-field-dateselect').val().length > 0) {
            var array = jQuery('.elementor-tab-content.elementor-active #form-field-dateselect').val().split(" to ").filter(function(itm, i, a) {
                return i == a.indexOf(itm);
            });


            if(array.length > 1){
                 date1 = new Date(array[0]);
                 date2 = new Date(array[1]);
                 date2 = new Date(date2.setDate(date2.getDate() + 1));
            }else{
                 date1 = new Date(array[0]);
                 date2 = new Date(date2.setDate(date1.getDate() + 1));
            }

        }else{
                 date1 = new Date();
                 date2 = new Date(date2.setDate(date2.getDate() + 1));
        }

        var date1_year = date1.toLocaleString("default", { year: "numeric" });
        var date1_month = date1.toLocaleString("default", { month: "2-digit" });
        var date1_day = date1.toLocaleString("default", { day: "2-digit" });                 
        var formattedDate_1 = date1_year + "-" + date1_month + "-" + date1_day;

        var date2_year = date2.toLocaleString("default", { year: "numeric" });
        var date2_month = date2.toLocaleString("default", { month: "2-digit" });
        var date2_day = date2.toLocaleString("default", { day: "2-digit" });                 
        var formattedDate_2 = date2_year + "-" + date2_month + "-" + date2_day;



        console.log(formattedDate_1);
        console.log(formattedDate_2);

        jQuery.ajax({
                     type : "post",
                     dataType : "json",
                     url : user_object.ajaxurl,
                     data : {action: "g_production_overall_kpi", fromDate: formattedDate_1,toDate : formattedDate_2 ,_data : g_mp_user_team,tab : _tab, nonce: user_object.nonce},
                     success: function(response) {
                                if(response.type == "success") {

                                    if (response.data.length > 0) {
                                        var i = 1;
                                        // looping the returned data
                                        Object.keys(response.data).map(k => {
                                         // creating new table row element
                                               if(parseFloat(response.data[k].productivity) > 71){
                                                  jQuery('#_productivity').addClass('criteria-pass');
                                                  jQuery('#_productivity').removeClass('criteria-failed');
                                               }else{
                                                  jQuery('#_productivity').removeClass('criteria-pass');
                                                  jQuery('#_productivity').addClass('criteria-failed');
                                               }

                                               if(parseFloat(response.data[k].nonProductivity) < 30){
                                                  jQuery('#_non_productivity').addClass('criteria-pass');
                                                  jQuery('#_non_productivity').removeClass('criteria-failed');
                                               }else{
                                                  jQuery('#_non_productivity').removeClass('criteria-pass');
                                                  jQuery('#_non_productivity').addClass('criteria-failed');
                                               }

                                               if(parseFloat(response.data[k].unplannedLeave) < 30){
                                                  jQuery('#_unplanned_leave').addClass('criteria-pass');
                                                  jQuery('#_unplanned_leave').removeClass('criteria-failed');
                                               }else{
                                                  jQuery('#_unplanned_leave').removeClass('criteria-pass');
                                                  jQuery('#_unplanned_leave').addClass('criteria-failed');
                                               }

                                               if(parseFloat(response.data[k].scheduleAdherence) > 3){
                                                  jQuery('#_schedule_adherence').addClass('criteria-pass');
                                                  jQuery('#_schedule_adherence').removeClass('criteria-failed');
                                               }else{
                                                  jQuery('#_schedule_adherence').removeClass('criteria-pass');
                                                  jQuery('#_schedule_adherence').addClass('criteria-failed');
                                               }


                                                jQuery('#productivity h2').html(displayPercent(parseInt(response.data[k].productivity).toFixed(2)));
                                                jQuery('#non_productivity h2').html(displayPercent(response.data[k].nonProductivity.toFixed(2)));
                                                jQuery('#unplanned_leave h2').html(displayPercent(response.data[k].unplannedLeave.toFixed(2)));
                                                jQuery('#schedule_adherence h2').html(parseInt('' + (response.data[k].scheduleAdherence * 100)) / 100);
                                                jQuery('#utilisation h2').html(isNaN(parseInt(response.data[k].utilization)) ? 0 : displayPercent(response.data[k].utilization.toFixed(2)));

                                                jQuery('.tat_info .dep_tat_block .tot_task_with_tat .target-score').html(response.data[k].totalTat);
                                                jQuery('.tat_info .dep_tat_block .avg_ata_in_min .target-score').html(response.data[k].avgTatInMin);
                                                jQuery('.tat_info .dep_tat_block .tot_tasks_exeed_tat .target-score').html(emptytozero(response.data[k].exeedsTat));
                                                jQuery('.tat_info .dep_tat_block .tot_tasks_within_tat .target-score').html(response.data[k].withinTat);

                                                jQuery('.task_info .task_completed_block .total-completed-task .target-score').html(response.data[k].noOfCompletedTasks);
                                                jQuery('.task_info .task_completed_block .daily-avg-completed-tasks .target-score').html(response.data[k].dailyAvgCompletedTask);
                                                jQuery('.task_info .task_completed_block .hourly-avg-completed-tasks .target-score').html(response.data[k].hourlyAvgCompletedTask);
                                                jQuery('.task_info .regional-task .total-completed-eu-task .target-score p').html(isNaN(parseInt(response.data[k].regionEu)) ? 0 : response.data[k].regionEu.toFixed(0));    
                                                jQuery('.task_info .regional-task .total-completed-au-task .target-score p').html(isNaN(parseInt(response.data[k].regionAu)) ? 0 : response.data[k].regionAu.toFixed(0));    


                                                jQuery('.tat_info').show();
                                                jQuery('.task_info').show();
                                                jQuery('.task_info .task_completed_block').show();
                                                if(g_mp_user_team == "DMAU" ){

                                                jQuery('.task_info .revision_tasks_block .total-completed-revision-task .target-score').html(isNaN(parseInt(response.data[k].totalCompletedRevisionTask)) ? 0 : response.data[k].totalCompletedRevisionTask);
                                                jQuery('.task_info .revision_tasks_block .daily-avg-completed-revisons-task .target-score').html(isNaN(parseInt(response.data[k].dailyAvgCompletedRevisonsTask)) ? 0 : response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));
                                                jQuery('.task_info .revision_tasks_block .hourly-avg-completed-revision-task .target-score').html(response.data[k].hourlyAvgCompletedRevisionTask.toFixed(0));
                                                jQuery('.task_info .revision_tasks_block_two .total-percentage-of-revisions-task .target-score').html(displayPercent(response.data[k].totalPercentageOfRevisionsTask.toFixed(2)));
                                                jQuery('.dm-only-section #dmeu_total_one').html(response.data[k].totalCompletedRevisionTask);
                                                jQuery('.dm-only-section #dmeu_total_two').html(response.data[k].noOfCompletedTasks);
                                                jQuery('.dm-only-section #dmeu_total_three').html(response.data[k].dailyAvgCompletedTask);
                                                jQuery('.dm-only-section #dmeu_total_four').html(response.data[k].hourlyAvgCompletedTask);
                                                jQuery('.dm-only-section #dmeu_total_five').html(displayPercent(response.data[k].utilization.toFixed(2)));
                                                jQuery('.dm-only-section #dmeu_total_six').html(displayPercent(((response.data[k].totalCompletedRevisionTask / response.data[k].noOfCompletedTasks) * 100).toFixed(2)));
                                                jQuery('.dm-only-section #dmeu_total_seven').html(isNaN(parseInt(response.data[k].dailyAvgCompletedRevisonsTask)) ? 0 : response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));    
                                                
                                                jQuery('.dm-only-section #dmeu_total_eight').html(response.data[k].averageTimeSpentPerRevision.toFixed(0) + ' Min.');
                                                jQuery('.dm-only-section #dmeu_total_nine').html( ( (response.data[k].productivity.toFixed(2) * response.data[k].noOfCompletedTasks ) / 100 ).toFixed(0) );
                                                jQuery('.dm-only-section #dmeu_total_ten').html( ( (response.data[k].nonProductivity.toFixed(2) * response.data[k].noOfCompletedTasks ) / 100 ).toFixed(0) );

                                                    jQuery('.dm-only-section').show();
                                                    jQuery('.task_info .revision_tasks_block').show();
                                                    jQuery('.task_info .revision_tasks_block_two').show();
                                                    jQuery('.task_info .rev_sip').show();
                                                }    
                                                    get_group_kpi();
                                                    individual_utilization_rate_per_task();
                                                    
                                                

                                        });
                                    }
                                }
                              },
                     error: function(xmlhttprequest, textstatus, message) {
                        if(textstatus==="timeout") {
                            console.log("got timeout");
                        } else {
                            console.log(textstatus);
                        }
                     }  
                }); 

    }

    function production_overallkpi(){
        jQuery('#productivity h2').html('<div class="loader"></div>');
        jQuery('#non_productivity h2').html('<div class="loader"></div>');
        jQuery('#unplanned_leave h2').html('<div class="loader"></div>');
        jQuery('#schedule_adherence h2').html('<div class="loader"></div>');
        jQuery('#utilisation h2').html('<div class="loader"></div>');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper .elementor-tab-content.elementor-active .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper .elementor-tab-content.elementor-active .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');
        jQuery('.tat_info').hide();
        jQuery('.task_info').hide();
        jQuery('.dm-only-section').hide();
        jQuery('.dm-only-section-two').hide();

        jQuery('.team-overall-task-block').hide();        
        jQuery('.grand-total-block').hide();
        jQuery('.graph-block').hide();

        jQuery('.task_info .task_completed_block').hide();
        jQuery('.task_info .revision_tasks_block').hide();
        jQuery('.task_info .revision_tasks_block_two').hide();
        jQuery('.task_info .rev_sip').hide();
        if( jQuery('#elementor-tab-content-2562 #team-list').length ) {
            g_mp_user_team = jQuery("#elementor-tab-content-2562 #team-list").find(':selected').val();
        }else{
            g_mp_user_team = user_object.mp_user_team
        }

        if(g_mp_user_team != ""){
            jQuery('.elementor-tab-content.elementor-active .prod-boxes').show();    
        }        


        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_production_overall_kpi", g_year : jQuery('.elementor-tab-content.elementor-active #form-field-year').find("option:selected").attr('value'),month : jQuery('.elementor-tab-content.elementor-active #form-field-month').find("option:selected").attr('value'),_data : g_mp_user_team,tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                Object.keys(response.data).map(k => {
                                 // creating new table row element
                                       if(parseFloat(response.data[k].productivity) > 71){
                                          jQuery('#_productivity').addClass('criteria-pass');
                                          jQuery('#_productivity').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_productivity').removeClass('criteria-pass');
                                          jQuery('#_productivity').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].nonProductivity) < 30){
                                          jQuery('#_non_productivity').addClass('criteria-pass');
                                          jQuery('#_non_productivity').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_non_productivity').removeClass('criteria-pass');
                                          jQuery('#_non_productivity').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].unplannedLeave) < 30){
                                          jQuery('#_unplanned_leave').addClass('criteria-pass');
                                          jQuery('#_unplanned_leave').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_unplanned_leave').removeClass('criteria-pass');
                                          jQuery('#_unplanned_leave').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].scheduleAdherence) > 3){
                                          jQuery('#_schedule_adherence').addClass('criteria-pass');
                                          jQuery('#_schedule_adherence').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_schedule_adherence').removeClass('criteria-pass');
                                          jQuery('#_schedule_adherence').addClass('criteria-failed');
                                       }


                                        jQuery('#productivity h2').html(displayPercent(parseInt(response.data[k].productivity).toFixed(2)));
                                        jQuery('#non_productivity h2').html(displayPercent(response.data[k].nonProductivity.toFixed(2)));
                                        jQuery('#unplanned_leave h2').html(displayPercent(response.data[k].unplannedLeave.toFixed(2)));
                                        jQuery('#schedule_adherence h2').html(parseInt('' + (response.data[k].scheduleAdherence * 100)) / 100);
                                        jQuery('#utilisation h2').html(displayPercent(response.data[k].utilization.toFixed(2)));

                                        jQuery('.tat_info .dep_tat_block .tot_task_with_tat .target-score').html(response.data[k].totalTat);
                                        jQuery('.tat_info .dep_tat_block .avg_ata_in_min .target-score').html(response.data[k].avgTatInMin);
                                        jQuery('.tat_info .dep_tat_block .tot_tasks_exeed_tat .target-score').html(emptytozero(response.data[k].exeedsTat));
                                        jQuery('.tat_info .dep_tat_block .tot_tasks_within_tat .target-score').html(response.data[k].withinTat);

                                        jQuery('.task_info .task_completed_block .total-completed-task .target-score').html(response.data[k].noOfCompletedTasks);
                                        jQuery('.task_info .task_completed_block .daily-avg-completed-tasks .target-score').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('.task_info .task_completed_block .hourly-avg-completed-tasks .target-score').html(response.data[k].hourlyAvgCompletedTask);
                                        jQuery('.task_info .regional-task .total-completed-eu-task .target-score p').html(isNaN(parseInt(response.data[k].regionEu)) ? 0 : response.data[k].regionEu.toFixed(0));    
                                        jQuery('.task_info .regional-task .total-completed-au-task .target-score p').html(isNaN(parseInt(response.data[k].regionAu)) ? 0 : response.data[k].regionAu.toFixed(0));    


                                        jQuery('.tat_info').show();
                                        jQuery('.task_info').show();
                                        jQuery('.task_info .task_completed_block').show();
                                        if(g_mp_user_team == "DMAU" ){

                                        jQuery('.task_info .revision_tasks_block .total-completed-revision-task .target-score').html(response.data[k].totalCompletedRevisionTask);
                                        jQuery('.task_info .revision_tasks_block .daily-avg-completed-revisons-task .target-score').html(response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));
                                        jQuery('.task_info .revision_tasks_block .hourly-avg-completed-revision-task .target-score').html(response.data[k].hourlyAvgCompletedRevisionTask.toFixed(0));
                                        jQuery('.task_info .revision_tasks_block_two .total-percentage-of-revisions-task .target-score').html(displayPercent(response.data[k].totalPercentageOfRevisionsTask.toFixed(2)));
                                        jQuery('.dm-only-section #dmeu_total_one').html(response.data[k].totalCompletedRevisionTask);
                                        jQuery('.dm-only-section #dmeu_total_two').html(response.data[k].noOfCompletedTasks);
                                        jQuery('.dm-only-section #dmeu_total_three').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('.dm-only-section #dmeu_total_four').html(response.data[k].hourlyAvgCompletedTask);
                                        jQuery('.dm-only-section #dmeu_total_five').html(displayPercent(response.data[k].utilization.toFixed(2)));
                                        jQuery('.dm-only-section #dmeu_total_six').html(displayPercent(((response.data[k].totalCompletedRevisionTask / response.data[k].noOfCompletedTasks) * 100).toFixed(2)));
                                        jQuery('.dm-only-section #dmeu_total_seven').html(response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));
                                        jQuery('.dm-only-section #dmeu_total_eight').html(response.data[k].averageTimeSpentPerRevision.toFixed(0) + ' Min.');
                                        jQuery('.dm-only-section #dmeu_total_nine').html( ( (response.data[k].productivity.toFixed(2) * response.data[k].noOfCompletedTasks ) / 100 ).toFixed(0) );
                                        jQuery('.dm-only-section #dmeu_total_ten').html( ( (response.data[k].nonProductivity.toFixed(2) * response.data[k].noOfCompletedTasks ) / 100 ).toFixed(0) );

                                            jQuery('.dm-only-section').show();
                                            jQuery('.task_info .revision_tasks_block').show();
                                            jQuery('.task_info .revision_tasks_block_two').show();
                                            jQuery('.task_info .rev_sip').show();
                                        }    
                                            get_group_kpi();
                                            individual_utilization_rate_per_task();                                           
                                        

                                });
                            }
                        }
                      },
            error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    console.log("got timeout");
                } else {
                    console.log(textstatus);
                }
             }  
        }); 
    }

    function production_quarterly_overallkpi(){
        jQuery('#productivity_q h2').html('<div class="loader"></div>');
        jQuery('#non_productivity_q h2').html('<div class="loader"></div>');
        jQuery('#unplanned_leave_q h2').html('<div class="loader"></div>');
        jQuery('#schedule_adherence_q h2').html('<div class="loader"></div>');
        jQuery('#utilization_q h2').html('<div class="loader"></div>');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper .elementor-tab-content.elementor-active .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper .elementor-tab-content.elementor-active3 .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');
        jQuery('.dm-only-section').hide();
        jQuery('.tat_info_q').hide();
        jQuery('.task_info_q').hide();

        jQuery('.elementor-tab-content.elementor-active .dm-only-section').hide();
        jQuery('.elementor-tab-content.elementor-active .dm-only-section-two').hide();
        jQuery('.elementor-tab-content.elementor-active .team-overall-task-block').hide();
        jQuery('.elementor-tab-content.elementor-active .grand-total-block').hide();
        jQuery('.elementor-tab-content.elementor-active .graph-block').hide();

        jQuery('.task_info_q .task_completed_block').hide();
        jQuery('.task_info_q .revision_tasks_block').hide();
        jQuery('.task_info_q .revision_tasks_block_two').hide();
        jQuery('.task_info_q .rev_sip').hide();        

        if( jQuery('#elementor-tab-content-2563 #team-list').length ) {
            g_mp_user_team = jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val();
        }else{
            g_mp_user_team = user_object.mp_user_team
        }

        if(g_mp_user_team != ""){
        jQuery('.elementor-tab-content.elementor-active .prod-boxes').show();    
        }
        
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_production_quarterly_overall_kpi", g_year : jQuery('.elementor-tab-content.elementor-active #form-field-year').find("option:selected").attr('value'),quarter : jQuery('.elementor-tab-content.elementor-active #form-field-quarter').find("option:selected").attr('value'),_data : g_mp_user_team,tab : _tab, nonce: user_object.nonce},
             success: function(response) {

                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                Object.keys(response.data).map(k => {
                                 // creating new table row element
                                       if(parseFloat(response.data[k].productivity) > 71){
                                          jQuery('#_productivity_q').addClass('criteria-pass');
                                          jQuery('#_productivity_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_productivity_q').removeClass('criteria-pass');
                                          jQuery('#_productivity_q').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].nonProductivity) < 30){
                                          jQuery('#_non_productivity_q').addClass('criteria-pass');
                                          jQuery('#_non_productivity_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_non_productivity_q').removeClass('criteria-pass');
                                          jQuery('#_non_productivity_q').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].unplannedLeave) < 30){
                                          jQuery('#_unplanned_leave_q').addClass('criteria-pass');
                                          jQuery('#_unplanned_leave_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_unplanned_leave_q').removeClass('criteria-pass');
                                          jQuery('#_unplanned_leave_q').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].scheduleAdherence) > 3){
                                          jQuery('#_schedule_adherence_q').addClass('criteria-pass');
                                          jQuery('#_schedule_adherence_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_schedule_adherence_q').removeClass('criteria-pass');
                                          jQuery('#_schedule_adherence_q').addClass('criteria-failed');
                                       }

                                        jQuery('#productivity_q h2').html(displayPercent(response.data[k].productivity.toFixed(2)));
                                        jQuery('#non_productivity_q h2').html(displayPercent(response.data[k].nonProductivity.toFixed(2)));
                                        jQuery('#unplanned_leave_q h2').html(displayPercent(response.data[k].unplannedLeave.toFixed(2)));
                                        jQuery('#schedule_adherence_q h2').html(parseInt('' + (response.data[k].scheduleAdherence * 100)) / 100);
                                        jQuery('#utilisation_q h2').html(displayPercent(response.data[k].utilization.toFixed(2)));

                                        jQuery('.tat_info_q .dep_tat_block .tot_task_with_tat .target-score').html(response.data[k].totalTat);
                                        jQuery('.tat_info_q .dep_tat_block .avg_ata_in_min .target-score').html(response.data[k].avgTatInMin);
                                        jQuery('.tat_info_q .dep_tat_block .tot_tasks_exeed_tat .target-score').html(emptytozero(response.data[k].exeedsTat));
                                        jQuery('.tat_info_q .dep_tat_block .tot_tasks_within_tat .target-score').html(response.data[k].withinTat);

                                        jQuery('.task_info_q .task_completed_block .total-completed-task .target-score').html(response.data[k].noOfCompletedTasks);
                                        jQuery('.task_info_q .task_completed_block .daily-avg-completed-tasks .target-score').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('.task_info_q .task_completed_block .hourly-avg-completed-tasks .target-score').html(response.data[k].hourlyAvgCompletedTask);
                                        jQuery('.task_info_q .regional-task .total-completed-eu-task .target-score p').html(isNaN(parseInt(response.data[k].regionEu)) ? 0 : response.data[k].regionEu.toFixed(0));    
                                        jQuery('.task_info_q .regional-task .total-completed-au-task .target-score p').html(isNaN(parseInt(response.data[k].regionAu)) ? 0 : response.data[k].regionAu.toFixed(0));    

                                        jQuery('.tat_info_q').show();
                                        jQuery('.task_info_q').show();
                                        jQuery('.task_info_q .task_completed_block').show();

                                        if(g_mp_user_team == "DMAU"){

                                        jQuery('.task_info_q .revision_tasks_block .total-completed-revision-task .target-score').html(response.data[k].totalCompletedRevisionTask);
                                        jQuery('.task_info_q .revision_tasks_block .daily-avg-completed-revisons-task .target-score').html(response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));
                                        jQuery('.task_info_q .revision_tasks_block .hourly-avg-completed-revision-task .target-score').html(response.data[k].hourlyAvgCompletedRevisionTask.toFixed(0));
                                        jQuery('.task_info_q .revision_tasks_block_two .total-percentage-of-revisions-task .target-score').html(displayPercent(response.data[k].totalPercentageOfRevisionsTask.toFixed(2)));
                                        jQuery('.q_dm-only-section #dmeu_total_one').html(response.data[k].totalCompletedRevisionTask);                                        
                                        jQuery('.q_dm-only-section #dmeu_total_two').html(response.data[k].noOfCompletedTasks);
                                        jQuery('.q_dm-only-section #dmeu_total_three').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('.q_dm-only-section #dmeu_total_four').html(response.data[k].hourlyAvgCompletedTask);
                                        jQuery('.q_dm-only-section #dmeu_total_five').html(displayPercent(response.data[k].utilization.toFixed(2)));
                                        jQuery('.q_dm-only-section #dmeu_total_six').html(displayPercent(((response.data[k].totalCompletedRevisionTask / response.data[k].noOfCompletedTasks) * 100).toFixed(2)));
                                        jQuery('.q_dm-only-section #dmeu_total_seven').html(response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));
                                        jQuery('.q_dm-only-section #dmeu_total_eight').html(response.data[k].averageTimeSpentPerRevision.toFixed(0) + ' Min.');
                                        jQuery('.q_dm-only-section #dmeu_total_nine').html( ( (response.data[k].productivity.toFixed(2) * response.data[k].noOfCompletedTasks ) / 100 ).toFixed(0) );
                                        jQuery('.q_dm-only-section #dmeu_total_ten').html( ( (response.data[k].nonProductivity.toFixed(2) * response.data[k].noOfCompletedTasks ) / 100 ).toFixed(0) );                                        

                                            jQuery('.q_dm-only-section').show();
                                            jQuery('.task_info_q .revision_tasks_block').show();
                                            jQuery('.task_info_q .revision_tasks_block_two').show();
                                            jQuery('.task_info_q .rev_sip').show();                                            
                                        }
                                        get_group_kpi("_q");
                                        individual_utilization_rate_per_task();
                                });
                            }
                        }
                      },
             error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    console.log("got timeout");
                } else {
                    console.log(textstatus);
                }
             }        
        });
    }    

    function get_group_kpi(prefi = ""){
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_group_kpi_performnace",_data : g_mp_user_team,tab : 'Over All KPI Group', nonce: user_object.nonce},
             success: function(response) {

                if(response.type == "success") {
                    if (response.data.length > 0) {
                        var i = 1;
                        // looping the returned data
                        Object.keys(response.data).map(k => {

                           if(parseFloat(response.data[k].productivity) > 71){
                              jQuery('#_productivity'+prefi).addClass('criteria-pass');
                              jQuery('#_productivity'+prefi).removeClass('criteria-failed');
                           }else{
                              jQuery('#_productivity'+prefi).removeClass('criteria-pass');
                              jQuery('#_productivity'+prefi).addClass('criteria-failed');
                           }

                           if(parseFloat(response.data[k].nonProductivity) < 30){
                              jQuery('#_non_productivity'+prefi).addClass('criteria-pass');
                              jQuery('#_non_productivity'+prefi).removeClass('criteria-failed');
                           }else{
                              jQuery('#_non_productivity'+prefi).removeClass('criteria-pass');
                              jQuery('#_non_productivity'+prefi).addClass('criteria-failed');
                           }

                           if(parseFloat(response.data[k].unplannedLeave) < 30){
                              jQuery('#_unplanned_leave'+prefi).addClass('criteria-pass');
                              jQuery('#_unplanned_leave'+prefi).removeClass('criteria-failed');
                           }else{
                              jQuery('#_unplanned_leave'+prefi).removeClass('criteria-pass');
                              jQuery('#_unplanned_leave'+prefi).addClass('criteria-failed');
                           }

                           if(parseFloat(response.data[k].scheduleAdherence) > 3){
                              jQuery('#_schedule_adherence'+prefi).addClass('criteria-pass');
                              jQuery('#_schedule_adherence'+prefi).removeClass('criteria-failed');
                           }else{
                              jQuery('#_schedule_adherence'+prefi).removeClass('criteria-pass');
                              jQuery('#_schedule_adherence'+prefi).addClass('criteria-failed');
                           }

                            jQuery('#productivity'+prefi+' h2').html(displayPercent(response.data[k].productivity.toFixed(2)));
                            jQuery('#non_productivity'+prefi+' h2').html(displayPercent(response.data[k].nonProductivity.toFixed(2)));
                            jQuery('#unplanned_leave'+prefi+' h2').html(displayPercent(response.data[k].unplannedLeave.toFixed(2)));
                            jQuery('#schedule_adherence'+prefi+' h2').html(parseInt('' + (response.data[k].scheduleAdherence * 100)) / 100);
                            jQuery('#utilisation'+prefi+' h2').html(displayPercent(response.data[k].utilization.toFixed(2)));
                        });
                    }
                }


              }
        });         
    }

    function individual_utilization_rate_per_task(){

        if( jQuery('.elementor-tab-content.elementor-active #team-list').length ) {
            g_mp_user_team = jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val();
        }else{
            g_mp_user_team = user_object.mp_user_team;
        }
        console.log(g_mp_user_team);
        _tab = g_mp_user_team + " Team Utilization Per Task";

        jQuery('.elementor-tab-content.elementor-active .dm-only-section-two').show();
        jQuery('.elementor-tab-content.elementor-active .dm-only-section-two #table-list2').remove();
        var table_dm = jQuery('.elementor-tab-content.elementor-active .dm-only-section-two #table-list');
        var table_rate = jQuery( "<table id='table-list2'><thead></thead><tbody></tbody></table>" ).insertAfter(table_dm);
        jQuery(".elementor-tab-content.elementor-active .dm-only-section-two #table-list tbody").empty();
        table_dm.find("thead").empty();
        table_rate.find('tbody').empty();        
        table_rate.find('thead').empty();
        if(g_mp_user_team == "DMAU" || g_mp_user_team == "DMEU"){
            var tr = jQuery('<tr>');
            table_dm.removeClass('non-dm');
            tr.append('<th scope="col" rowspan="2">Members</th>');
            tr.append('<th scope="col" colspan="2" class="task-01">Spotzer Ads</th>');
            tr.append('<th scope="col" colspan="2" class="task-02">Revision Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-03">Traffic Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-04">Admin Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-05">AI Task</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" class="task-01">QTY</th>');
            tr.append('<th scope="col" class="task-01">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-02">QTY</th>');
            tr.append('<th scope="col" class="task-02">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-03">QTY</th>');
            tr.append('<th scope="col" class="task-03">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-04">QTY</th>');
            tr.append('<th scope="col" class="task-04">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-05">QTY</th>');
            tr.append('<th scope="col" class="task-05">HRS SPENT</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th class="py-1 px-2 text-center" colspan="11">Loading Data...</th>');
            table_dm.find('tbody').append(tr.clone());
            
            var tr = jQuery('<tr>');
            tr.append('<th scope="col">Members</th>');
            tr.append('<th scope="col">Total Utilization Rate</th>');
            tr.append('<th scope="col">Total Efficiency per Member</th>');
            tr.append('<th scope="col">Total Lost Hours per Member</th>');
            table_rate.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            //tr.append('<th class="py-1 px-2 text-center" colspan="4">Loading Data...</th>');
            table_rate.find('tbody').append(tr.clone());            
        }
        if(g_mp_user_team == "DESIGN"){
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" rowspan="2">Members</th>');
            tr.append('<th scope="col" colspan="2" class="task-01">Admin Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-02">Special Project</th>');
            tr.append('<th scope="col" colspan="2" class="task-03">Revision</th>');
            tr.append('<th scope="col" colspan="2" class="task-04">Fullbuild</th>');
            tr.append('<th scope="col" colspan="2" class="task-05">Other Design Tasks</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" class="task-01">QTY</th>');
            tr.append('<th scope="col" class="task-01">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-02">QTY</th>');
            tr.append('<th scope="col" class="task-02">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-03">QTY</th>');
            tr.append('<th scope="col" class="task-03">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-04">QTY</th>');
            tr.append('<th scope="col" class="task-04">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-05">QTY</th>');
            tr.append('<th scope="col" class="task-05">HRS SPENT</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th class="py-1 px-2 text-center" colspan="11">Loading Data...</th>');
            table_dm.find('tbody').append(tr.clone());
            
            var tr = jQuery('<tr>');
            tr.append('<th scope="col">Members</th>');
            tr.append('<th scope="col">Total Utilization Rate</th>');
            tr.append('<th scope="col">Total Efficiency per Member</th>');
            tr.append('<th scope="col">Total Lost Hours per Member</th>');
            table_rate.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            table_rate.find('tbody').append(tr.clone());            
        }
        if(g_mp_user_team == "QA"){
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" rowspan="2">Members</th>');
            tr.append('<th scope="col" colspan="2" class="task-01">Admin Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-02">Regular QA</th>');
            tr.append('<th scope="col" colspan="2" class="task-03">Migration (Partner Specific)</th>');
            tr.append('<th scope="col" colspan="2" class="task-04">Special Project / QA outside of Salesforce</th>');
            tr.append('<th scope="col" colspan="2" class="task-05">Other QA Tasks</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" class="task-01">QTY</th>');
            tr.append('<th scope="col" class="task-01">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-02">QTY</th>');
            tr.append('<th scope="col" class="task-02">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-03">QTY</th>');
            tr.append('<th scope="col" class="task-03">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-04">QTY</th>');
            tr.append('<th scope="col" class="task-04">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-05">QTY</th>');
            tr.append('<th scope="col" class="task-05">HRS SPENT</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th class="py-1 px-2 text-center" colspan="11">Loading Data...</th>');
            table_dm.find('tbody').append(tr.clone());
            
            var tr = jQuery('<tr>');
            tr.append('<th scope="col">Members</th>');
            tr.append('<th scope="col">Total Utilization Rate</th>');
            tr.append('<th scope="col">Total Efficiency per Member</th>');
            tr.append('<th scope="col">Total Lost Hours per Member</th>');
            table_rate.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            table_rate.find('tbody').append(tr.clone());            
        }                
        if(g_mp_user_team == "WPDEV"){
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" rowspan="2">Members</th>');
            tr.append('<th scope="col" colspan="2" class="task-01">Admin Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-02">Production Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-03">Post-Production Task</th>');
            table_dm.find('thead').append(tr.clone());

            var tr = jQuery('<tr>');
            tr.append('<th scope="col" class="task-01">QTY</th>');
            tr.append('<th scope="col" class="task-01">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-02">QTY</th>');
            tr.append('<th scope="col" class="task-02">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-03">QTY</th>');
            tr.append('<th scope="col" class="task-03">HRS SPENT</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th class="py-1 px-2 text-center" colspan="7">Loading Data...</th>');
            table_dm.find('tbody').append(tr.clone());            

            var tr = jQuery('<tr>');
            tr.append('<th scope="col">Members</th>');
            tr.append('<th scope="col">Total Utilization Rate</th>');
            tr.append('<th scope="col">Total Efficiency per Member</th>');
            tr.append('<th scope="col">Total Lost Hours per Member</th>');
            table_rate.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            //tr.append('<th class="py-1 px-2 text-center" colspan="4">Loading Data...</th>');
            table_rate.find('tbody').append(tr.clone());

        }
        if(g_mp_user_team == "FRONTEND"){
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" rowspan="2">Members</th>');
            tr.append('<th scope="col" colspan="2" class="task-01">Admin Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-02">Production Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-03">Post-Production Task</th>');
            table_dm.find('thead').append(tr.clone());

            var tr = jQuery('<tr>');
            tr.append('<th scope="col" class="task-01">QTY</th>');
            tr.append('<th scope="col" class="task-01">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-02">QTY</th>');
            tr.append('<th scope="col" class="task-02">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-03">QTY</th>');
            tr.append('<th scope="col" class="task-03">HRS SPENT</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th class="py-1 px-2 text-center" colspan="7">Loading Data...</th>');
            table_dm.find('tbody').append(tr.clone());            

            var tr = jQuery('<tr>');
            tr.append('<th scope="col">Members</th>');
            tr.append('<th scope="col">Total Utilization Rate</th>');
            tr.append('<th scope="col">Total Efficiency per Member</th>');
            tr.append('<th scope="col">Total Lost Hours per Member</th>');
            table_rate.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            //tr.append('<th class="py-1 px-2 text-center" colspan="4">Loading Data...</th>');
            table_rate.find('tbody').append(tr.clone());

        }
        if(g_mp_user_team == "TRAFFIC"){
            var tr = jQuery('<tr>');
            tr.append('<th scope="col" rowspan="2">Members</th>');
            tr.append('<th scope="col" colspan="2" class="task-01">Admin Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-02">Traffic Monitoring Task</th>');
            tr.append('<th scope="col" colspan="2" class="task-03">Task Allocation Task</th>');
            table_dm.find('thead').append(tr.clone());

            var tr = jQuery('<tr>');
            tr.append('<th scope="col" class="task-01">QTY</th>');
            tr.append('<th scope="col" class="task-01">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-02">QTY</th>');
            tr.append('<th scope="col" class="task-02">HRS SPENT</th>');
            tr.append('<th scope="col" class="task-03">QTY</th>');
            tr.append('<th scope="col" class="task-03">HRS SPENT</th>');
            table_dm.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            tr.append('<th class="py-1 px-2 text-center" colspan="7">Loading Data...</th>');
            table_dm.find('tbody').append(tr.clone());            

            var tr = jQuery('<tr>');
            tr.append('<th scope="col">Members</th>');
            tr.append('<th scope="col">Total Utilization Rate</th>');
            tr.append('<th scope="col">Total Efficiency per Member</th>');
            tr.append('<th scope="col">Total Lost Hours per Member</th>');
            table_rate.find('thead').append(tr.clone());
            var tr = jQuery('<tr>');
            //tr.append('<th class="py-1 px-2 text-center" colspan="4">Loading Data...</th>');
            table_rate.find('tbody').append(tr.clone());

        }        
        table_dm.find('tbody').append(tr.clone());
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_individual_utilization_rate_per_task", g_year : jQuery('.elementor-tab-content.elementor-active #form-field-year').find("option:selected").attr('value'),_data : g_mp_user_team,tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                var data_Points = [];
                                var data_Points2 = [];
                                var data_Points3 = [];
                                // looping the returned data
                                table_dm.find('tbody').empty();
                                table_rate.find('tbody').empty();
                                jQuery('.graph-block').show();
                                Object.keys(response.data).map(k => {
                                        data_Points.push({'label': response.data[k].member, 'y':Number(response.data[k].totalUtilizationRate.toFixed(2))});
                                        data_Points2.push({'label': response.data[k].member, 'y':Number(response.data[k].totalProductivityPerMemberInAMonth.toFixed(2))});
                                        data_Points3.push({'label': response.data[k].member, 'y':Number(response.data[k].totalNonprodPerMemberInAMonth.toFixed(2))});
                                    if(g_mp_user_team == "DMAU"){
                                        var tr = jQuery('<tr>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].member +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].spotzerAds +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].spotzerHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].revisionTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].revisionHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].trafficTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].trafficHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-04">' + response.data[k].dmAdminTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-04">' + response.data[k].dmAdminHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-05">' + response.data[k].aiTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-05">' + response.data[k].aiHrsSpent.toFixed(2) +'</td>');
                                        table_dm.find('tbody').append(tr.clone());
                                    }
                                    if(g_mp_user_team == "DESIGN"){
                                        var tr = jQuery('<tr>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].member +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].specialProject +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].specialProjecthrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].revision +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].revisionHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-04">' + response.data[k].fullbuildTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-04">' + response.data[k].fullbuildHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-05">' + response.data[k].otherDesignTasks +'</td>');
                                        tr.append('<td class="py-1 px-2 task-05">' + response.data[k].otherDesignTasksHrsSpent.toFixed(2) +'</td>');
                                        table_dm.find('tbody').append(tr.clone());
                                    }
                                    if(g_mp_user_team == "QA"){
                                        var tr = jQuery('<tr>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].member +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].regularQaTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].regularQaHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].migrationPartnerSpecific +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].migrationPartnerSpecificHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-04">' + response.data[k].specialProjectQaOutsideOfSalesforcetask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-04">' + response.data[k].specialProjectQaOutsideOfSalesforceHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-05">' + response.data[k].otherQaTasks +'</td>');
                                        tr.append('<td class="py-1 px-2 task-05">' + response.data[k].otherQaTasksHrsSpent.toFixed(2) +'</td>');
                                        table_dm.find('tbody').append(tr.clone());
                                    }
                                    if(g_mp_user_team == "WPDEV"){
                                        var tr = jQuery('<tr>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].member +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].production +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].productionHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].postproductionTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].postproductionHrsSpent.toFixed(2) +'</td>');
                                        table_dm.find('tbody').append(tr.clone());
                                    }
                                    if(g_mp_user_team == "FRONTEND"){
                                        var tr = jQuery('<tr>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].member +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].production +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].productionHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].postproductionTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].postproductionHrsSpent.toFixed(2) +'</td>');
                                        table_dm.find('tbody').append(tr.clone());
                                    }
                                    if(g_mp_user_team == "TRAFFIC"){
                                        var tr = jQuery('<tr>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].member +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-01">' + response.data[k].adminHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].trafficMonitoring +'</td>');
                                        tr.append('<td class="py-1 px-2 task-02">' + response.data[k].trafficMonitoringHrsSpent.toFixed(2) +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].taskAllocationTask +'</td>');
                                        tr.append('<td class="py-1 px-2 task-03">' + response.data[k].taskAllocationHrsSpent.toFixed(2) +'</td>');
                                        table_dm.find('tbody').append(tr.clone());
                                    }
                                    var tr = jQuery('<tr>');
                                    tr.append('<td class="py-1 px-2">' + response.data[k].member +'</td>');
                                    tr.append('<td class="py-1 px-2">' + displayPercent(response.data[k].totalUtilizationRate.toFixed(2)) +'</td>');
                                    tr.append('<td class="py-1 px-2">' + displayPercent(response.data[k].totalProductivityPerMemberInAMonth.toFixed(2)) +'</td>');
                                    tr.append('<td class="py-1 px-2">' + displayPercent(response.data[k].totalNonprodPerMemberInAMonth.toFixed(2)) +'</td>');
                                    table_rate.find('tbody').append(tr.clone());

                                });
                                var options = {
                                        title: {
                                            text: ""
                                        },
                                        data: [              
                                        {
                                            // Change type to "doughnut", "line", "splineArea", etc.
                                            type: "column",
                                            name: "Total Utilization Rate",
                                            showInLegend: true,                                            
                                            dataPoints: data_Points
                                        },
                                        {
                                            // Change type to "doughnut", "line", "splineArea", etc.
                                            type: "column",
                                            name: "Total Efficiency per Member in a Month",
                                            showInLegend: true,                                            
                                            dataPoints: data_Points2
                                        }
                                        ,
                                        {
                                            // Change type to "doughnut", "line", "splineArea", etc.
                                            type: "column",
                                            name: "Total Lost Hours per Member in a Month",
                                            showInLegend: true,                                            
                                            dataPoints: data_Points3
                                        }
                                        ],
                                        axisY:{
                                          prefix: "",
                                          suffix: "%"
                                        }
                                    };
                                
                                jQuery(".elementor-tab-content.elementor-active #chartContainer").CanvasJSChart(options);

                                team_overall_task_submited();
                            }
                        }
                      }
        });
    }

    function team_overall_task_submited(){

        if( jQuery('.elementor-tab-content.elementor-active #team-list').length ) {
            g_mp_user_team = jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val();
        }else{
            g_mp_user_team = user_object.mp_user_team
        }
        _tab = "Overall Task submitted";

        jQuery('.team-overall-task-block').show();
        jQuery('.team-overall-task-block .overall-block .overall-col .elementor-widget-container').empty();
        jQuery('.team-overall-task-block .overall-block .overall-col .elementor-widget-container').append(  '<table id="table-list" class="overall-task"><colgroup><col style="width: 28.33%;"><col style="width: 5%;"></colgroup>' );
        var table_dm = jQuery('.team-overall-task-block').find('#table-list');
        var tr = jQuery('<tr>');
        tr.append('<th class="py-1 px-2 text-center">Loading Data...</th>');
        jQuery(".team-overall-task-block #table-list thead").empty();
        jQuery(".team-overall-task-block #table-list tbody").empty();
        table_dm.find('tbody').append(tr.clone());
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_team_overall_task_submited", g_year : jQuery('.elementor-tab-content.elementor-active #form-field-year').find("option:selected").attr('value'),month : jQuery('.elementor-tab-content.elementor-active #form-field-month').find("option:selected").attr('value'),_data : g_mp_user_team,tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                var data_Points = [];
                                jQuery('.team-overall-task-block .overall-block .overall-col .elementor-widget-container').empty();
                                jQuery('.graph-block').show();
                                Object.keys(response.data).map(k => {
                                    jQuery('.grand-total-block .g-total h4').text(displayPercent(response.data[k].total.toFixed(2)));
                                    data_Points.push({'label': response.data[k].taskType, 'y':Number(response.data[k].numberOfCompleted.toFixed(2))});
                                    if (k % 10 == 0)
                                    {
                                      jQuery('.team-overall-task-block .overall-block .overall-col .elementor-widget-container').append(  '<table id="table-list-'+ k +'" class="overall-task"><colgroup><col style="width: 28.33%;"><col style="width: 5%;"></colgroup>' );
                                      table_dm = jQuery('.team-overall-task-block').find('#table-list-' + k);
                                      table_dm.append("<thead>");
                                      table_dm.append("<tbody>");
                                      var th = jQuery('<tr>');
                                      th.append('<th scope="col" class="task-cell">Task</th>');
                                      th.append('<th scope="col" class="percent-cell">%</th>');

                                      table_dm.find('thead').append(th);
                                    }
                                    var tr = jQuery('<tr>');
                                    tr.append('<td class="py-1 px-2">' + response.data[k].taskType +'</td>');
                                    tr.append('<td class="py-1 px-2 task-01">' + displayPercent(response.data[k].numberOfCompleted.toFixed(2)) +'</td>');
                                    table_dm.find('tbody').append(tr);

                                });
                                var options = {
                                    title: {
                                        text: ""
                                    },
                                    data: [{
                                            type: "pie",
                                            startAngle: 45,
                                            showInLegend: false,
                                            indexLabel: "{label} ({y}%)",
                                            yValueFormatString:"#,##0.#"%"",
                                            dataPoints: data_Points
                                    }]
                                };
                                jQuery(".elementor-tab-content.elementor-active #chartContainer_two").CanvasJSChart(options);
                            }
                            jQuery('.elementor-tab-content.elementor-active .grand-total-block').delay(1000).show();
                        }
                      }
        });
    }

    function q_team_overall_task_submited(){

        if( jQuery('.elementor-tab-content.elementor-active #team-list').length ) {
            g_mp_user_team = jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val();
        }else{
            g_mp_user_team = user_object.mp_user_team
        }
        _tab = "Overall Task submitted";

        jQuery('.q_team-overall-task-block').show();
        jQuery('.q_team-overall-task-block .q_overall-block .overall-col .elementor-widget-container').empty();
        jQuery('.q_team-overall-task-block .q_overall-block .overall-col .elementor-widget-container').append(  '<table id="table-list" class="overall-task"><colgroup><col style="width: 28.33%;"><col style="width: 5%;"></colgroup>' );
        var table_dm = jQuery('.q_team-overall-task-block').find('#table-list');
        var tr = jQuery('<tr>');
        tr.append('<th class="py-1 px-2 text-center">Loading Data...</th>');
        jQuery(".q_team-overall-task-block #table-list thead").empty();
        jQuery(".q_team-overall-task-block #table-list tbody").empty();
        table_dm.find('tbody').append(tr.clone());
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_team_overall_task_submited", g_year : jQuery('.elementor-tab-content.elementor-active #form-field-year').find("option:selected").attr('value'),month : jQuery('.elementor-tab-content.elementor-active #form-field-month').find("option:selected").attr('value'),_data : g_mp_user_team,tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                var data_Points = [];
                                jQuery('.q_team-overall-task-block .q_overall-block .overall-col .elementor-widget-container').empty();
                                jQuery('.q_graph-block').show();
                                Object.keys(response.data).map(k => {
                                    jQuery('.q_grand-total-block .g-total h4').text(displayPercent(response.data[k].total.toFixed(2)));
                                    data_Points.push({'label': response.data[k].taskType, 'y':Number(response.data[k].numberOfCompleted.toFixed(2))});
                                    if (k % 10 == 0)
                                    {
                                      jQuery('.q_team-overall-task-block .q_overall-block .overall-col .elementor-widget-container').append(  '<table id="table-list-'+ k +'" class="overall-task"><colgroup><col style="width: 28.33%;"><col style="width: 5%;"></colgroup>' );
                                      table_dm = jQuery('.q_team-overall-task-block').find('#table-list-' + k);
                                      table_dm.append("<thead>");
                                      table_dm.append("<tbody>");
                                      table_dm.find('thead').empty();
                                      table_dm.find('tbody').empty();
                                      var th = jQuery('<tr>');
                                      th.append('<th scope="col" class="task-cell">Task</th>');
                                      th.append('<th scope="col" class="percent-cell">%</th>');

                                      table_dm.find('thead').append(th);
                                    }
                                    var tr = jQuery('<tr>');
                                    tr.append('<td class="py-1 px-2">' + response.data[k].taskType +'</td>');
                                    tr.append('<td class="py-1 px-2 task-01">' + displayPercent(response.data[k].numberOfCompleted.toFixed(2)) +'</td>');
                                    table_dm.find('tbody').append(tr);

                                });
                                var options = {
                                    title: {
                                        text: ""
                                    },
                                    data: [{
                                            type: "pie",
                                            startAngle: 45,
                                            showInLegend: false,
                                            indexLabel: "{label} ({y}%)",
                                            yValueFormatString:"#,##0.#"%"",
                                            dataPoints: data_Points
                                    }]
                                };
                                jQuery(".elementor-tab-content.elementor-active #chartContainer_two_q").CanvasJSChart(options);
                            }
                            jQuery('.elementor-tab-content.elementor-active .q_grand-total-block').delay(1000).show();
                        }
                      }
        });
    }    

    function q_team_yearly_performance(){

        if( jQuery('.elementor-tab-content.elementor-active #team-list').length ) {
            g_mp_user_team = jQuery(".elementor-tab-content.elementor-active #team-list").find(':selected').val();
        }else{
            g_mp_user_team = user_object.mp_user_team
        }

        jQuery(".y-team-yearly-performance-block").show();
        jQuery(".y-total-revisions").hide();
        jQuery(".y-total-completed-task").hide();
        jQuery(".y-utilization-per-month").hide();
        jQuery(".y-productivity-rev-vs-task").hide();
        jQuery(".y-non-prod-per-month").hide();

        jQuery('.y-team-yearly-performance-block .elementor-widget-container').empty().append(  '<table id="table-list" class="report">' );
        var table_dm = jQuery('.y-team-yearly-performance-block').find('#table-list');
        var tr = jQuery('<tr>');
        if(g_mp_user_team != "DMAU"){
            table_dm.addClass('non-dm');
            table_dm.find('colgroup').empty();
            tr.append('<th class="py-1 px-2 text-center" colspan="4">Loading Data...</th>');
        }else{
            table_dm.removeClass('non-dm');
            tr.append('<th class="py-1 px-2 text-center" colspan="14">Loading Data...</th>');
        }        
        table_dm.append("<tbody>");
        table_dm.find('tbody').append(tr.clone());
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_team_yearly_performnace", g_year : jQuery('.elementor-tab-content.elementor-active #form-field-year').find("option:selected").attr('value'),month : jQuery('.elementor-tab-content.elementor-active #form-field-month').find("option:selected").attr('value'),_data : g_mp_user_team,tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                var data_Points = [];
                                var data_Points2 = [];
                                var data_Points3 = [];
                                var data_Points4 = [];
                                var data_Points5 = [];
                                jQuery('.y-team-yearly-performance-block .elementor-widget-container').empty().append(  '<table id="table-list" class="report">' );
                                var table_dm = jQuery('.y-team-yearly-performance-block').find('#table-list');
                                table_dm.append("<thead>");
                                table_dm.append("<tbody>");
                                table_dm.find('thead');
                                if(g_mp_user_team != "DMAU"){
                                    table_dm.addClass('non-dm');
                                }else{
                                    table_dm.removeClass('non-dm');
                                }                                
                                var tr = jQuery('<tr>');
                                var tr2 = jQuery('<tr>');
                                tr.append('<th scope="col" class="py-1 px-2" rowspan="2">Month</th>');
                                tr.append('<th scope="col" class="py-1 px-2 task-01" colspan="2">Spotzer Ads</th>');
                                tr.append('<th scope="col" class="py-1 px-2 task-02" colspan="2">Revision</th>');
                                tr.append('<th scope="col" class="py-1 px-2 task-03" colspan="2">Traffic</th>');
                                tr.append('<th scope="col" class="py-1 px-2 task-04" colspan="2">Admin</th>');
                                tr.append('<th scope="col" class="py-1 px-2 task-05" colspan="2">AI</th>');
                                tr.append('<th scope="col" class="py-1 px-2 task-06" rowspan="2">Total Revisions</th>');
                                tr.append('<th scope="col" class="py-1 px-2" rowspan="2">Total Completed Task</th>');
                                tr.append('<th scope="col" class="py-1 px-2" rowspan="2">Total Utilisation per Month</th>');
                                tr.append('<th scope="col" class="py-1 px-2 task-07" rowspan="2">Efficiency of Revisions vs All Tasks</th>');
                                tr.append('<th scope="col" class="py-1 px-2" rowspan="2">Total Lost Hours per Month </th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-01">QTY</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-01">HRS SPENT</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-02">QTY</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-02">HRS SPENT</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-03">QTY</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-03">HRS SPENT</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-04">QTY</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-04">HRS SPENT</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-05">QTY</th>');
                                tr2.append('<th scope="col" class="py-1 px-2 task-05">HRS SPENT</th>');
                                table_dm.find('thead').append(tr);
                                table_dm.find('thead').append(tr2);
                                jQuery(".y-total-revisions").show();
                                jQuery(".y-total-completed-task").show();
                                jQuery(".y-utilization-per-month").show();
                                jQuery(".y-productivity-rev-vs-task").show();
                                jQuery(".y-non-prod-per-month").show();
                                Object.keys(response.data).map(k => {
                                    data_Points.push({'label': response.data[k].month, 'y':Number(response.data[k].totalRevisions.toFixed(2))});
                                    data_Points2.push({'label': response.data[k].month, 'y':Number(response.data[k].totalCompletedTask.toFixed(2))});
                                    data_Points3.push({'label': response.data[k].month, 'y':Number(response.data[k].totalUtilisationPerMonth.toFixed(2))});
                                    data_Points4.push({'label': response.data[k].month, 'y':Number(response.data[k].productivityOfRevisionsVsAllTasks.toFixed(2))});
                                    data_Points5.push({'label': response.data[k].month, 'y':Number(response.data[k].totalNonprodPerMonth.toFixed(2))});
                                    var tr = jQuery('<tr>');
                                    tr.append('<td class="py-1 px-2">' + response.data[k].month +'</td>');
                                    tr.append('<td class="py-1 px-2 task-01">' + response.data[k].spotzerAdsQty +'</td>');
                                    tr.append('<td class="py-1 px-2 task-01">' + response.data[k].spotzerAdsHrsSpent.toFixed(2) +'</td>');
                                    tr.append('<td class="py-1 px-2 task-02">' + response.data[k].revisionQty +'</td>');
                                    tr.append('<td class="py-1 px-2 task-02">' + response.data[k].revisionhrsSpent.toFixed(2) +'</td>');
                                    tr.append('<td class="py-1 px-2 task-03">' + response.data[k].trafficQty +'</td>');
                                    tr.append('<td class="py-1 px-2 task-03">' + response.data[k].trafficHrsSpent.toFixed(2) +'</td>');
                                    tr.append('<td class="py-1 px-2 task-04">' + response.data[k].adminQty +'</td>');
                                    tr.append('<td class="py-1 px-2 task-04">' + response.data[k].adminHrsSpent.toFixed(2) +'</td>');
                                    tr.append('<td class="py-1 px-2 task-05">' + response.data[k].aiQty +'</td>');
                                    tr.append('<td class="py-1 px-2 task-05">' + response.data[k].aiHrsSpent.toFixed(2) +'</td>');
                                    tr.append('<td class="py-1 px-2 task-06">' + response.data[k].totalRevisions +'</td>');
                                    tr.append('<td class="py-1 px-2">' + response.data[k].totalCompletedTask +'</td>');
                                    tr.append('<td class="py-1 px-2">' + displayPercent(response.data[k].totalUtilisationPerMonth.toFixed(2)) +'</td>');
                                    tr.append('<td class="py-1 px-2 task-07">' + displayPercent(response.data[k].productivityOfRevisionsVsAllTasks.toFixed(2)) +'</td>');
                                    tr.append('<td class="py-1 px-2">' + displayPercent(response.data[k].totalNonprodPerMonth.toFixed(2)) +'</td>');
                                    table_dm.find('tbody').append(tr);

                                });
                                var options = {
                                        title: {
                                            text: ""
                                        },
                                        data: [{
                                            // Change type to "doughnut", "line", "splineArea", etc.
                                            type: "column",
                                            name: "Total Revisions",
                                            showInLegend: false,                                            
                                            dataPoints: data_Points
                                        }],
                                        axisY:{
                                          prefix: "",
                                          suffix: "%"
                                        }
                                    };
                                var options2 = {
                                    title: {
                                        text: ""
                                    },
                                    data: [{
                                        // Change type to "doughnut", "line", "splineArea", etc.
                                        type: "column",
                                        name: "Total Revisions",
                                        showInLegend: false,                                            
                                        dataPoints: data_Points2
                                    }],
                                    axisY:{
                                      prefix: "",
                                      suffix: "%"
                                    }
                                };
                                var options3 = {
                                    title: {
                                        text: ""
                                    },
                                    data: [{
                                        // Change type to "doughnut", "line", "splineArea", etc.
                                        type: "column",
                                        name: "Total Utilisation per Month",
                                        showInLegend: false,                                            
                                        dataPoints: data_Points3
                                    }],
                                    axisY:{
                                      prefix: "",
                                      suffix: "%"
                                    }
                                };
                                var options4 = {
                                    title: {
                                        text: ""
                                    },
                                    data: [{
                                        // Change type to "doughnut", "line", "splineArea", etc.
                                        type: "column",
                                        name: "Efficiency of Revisions vs All Tasks",
                                        showInLegend: false,                                            
                                        dataPoints: data_Points4
                                    }],
                                    axisY:{
                                      prefix: "",
                                      suffix: "%"
                                    }
                                };
                                var options5 = {
                                    title: {
                                        text: ""
                                    },
                                    data: [{
                                        // Change type to "doughnut", "line", "splineArea", etc.
                                        type: "column",
                                        name: "Total Lost Hours per Month",
                                        showInLegend: false,                                            
                                        dataPoints: data_Points5
                                    }],
                                    axisY:{
                                      prefix: "",
                                      suffix: "%"
                                    }
                                };                                                                    
                                jQuery(".elementor-tab-content.elementor-active #chartContainer_y_rev").CanvasJSChart(options);
                                jQuery(".elementor-tab-content.elementor-active #chartContainer_y_tct").CanvasJSChart(options2);
                                jQuery(".elementor-tab-content.elementor-active #chartContainer_y_u_per_month").CanvasJSChart(options3);
                                jQuery(".elementor-tab-content.elementor-active #chartContainer_y_prt").CanvasJSChart(options4);
                                jQuery(".elementor-tab-content.elementor-active #chartContainer_y_non_prod").CanvasJSChart(options5);
                            }                            
                        }
                      }
        });
    }

      function displayPercent(num) {
      number = num.toString();;
      var words2 = number.split(".");
          for (var i = 0; i < words2.length; i++) {
              words2[i] += " ";
          }

          num1 = words2[0];
          num2 = words2[1];

          num1 = num1.trim();

          if(num2==undefined){
               number1 = num1+'.00%';
               return number1;
          }else{
               num2 = num2.trim();
               number1 = num1+'.'+num2+'%';
               return number1;
          }

      }
      function emptytozero(num){
        if(num == " "){
            return 0;
        }
        return num;
      }

        function addDays(date, days) {
            const newDate = new Date(date);
            newDate.setDate(date.getDate() + days);
            return newDate;
        }      

  });
})(jQuery);