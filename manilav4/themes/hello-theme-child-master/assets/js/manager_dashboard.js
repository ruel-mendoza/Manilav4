


(function($){
  var _tab = "Over All KPI";
  jQuery(document).ready(function(){
    jQuery('#listMenu li:nth-child(1) a').addClass('highlight-b');
    jQuery('.overall_caption .elementor-heading-title').html(jQuery('#listMenu li a.highlight-b span').text());
    setTimeout(function() {
      //jQuery("#elementor-tab-title-7843").click();
      //jQuery("#elementor-tab-title-6463").click();
        jQuery('a.highlight-b').click();
    },500);

    jQuery(document).on('click','#listMenu a',function(e){
      jQuery('#listMenu a').removeClass('highlight-b');
      jQuery(this).addClass('highlight-b');
      jQuery('#viewone .elementor-tab-title.elementor-active').click();
      jQuery('#viewtwo .elementor-tab-title.elementor-active').click();
      jQuery('.overall_caption .elementor-heading-title').html(jQuery('#listMenu li a.highlight-b span').text());
    });

    jQuery('#elementor-tab-content-7843 #form-field-year, #elementor-tab-content-7843 #form-field-month').change(function (e){
        jQuery("#elementor-tab-title-7843").click();
    });

    jQuery("#elementor-tab-content-7842 #form-field-year, #elementor-tab-content-7842 #form-field-quarter").change( function(e) {
        jQuery("#elementor-tab-title-7842").click();
    })

    jQuery("#elementor-tab-content-6462 #form-field-year, #elementor-tab-content-6462 #form-field-month").change( function(e) {
        jQuery("#elementor-tab-title-6462").click();
    })

    jQuery("#elementor-tab-content-6461 #form-field-year, #elementor-tab-content-6461 #form-field-quarter").change( function(e) {
        jQuery("#elementor-tab-title-6461").click();
    })

    jQuery("#elementor-tab-content-7841 #form-field-year").change( function(e) {
        jQuery("#elementor-tab-title-7841").click();
    })



    jQuery("#elementor-tab-title-7841").click( function(e) {
      var highlighted = jQuery('.highlight-b').attr('_data');
      jQuery('.qa-team-block').hide();
      jQuery('.web-design-team-block').hide();
      jQuery('.frontend-team-block').hide();
      jQuery('.wpdev-team-block').hide();
      jQuery('.dmau-team-block').hide();
      jQuery('.dmeu-team-block').hide();
      jQuery('.traffic-team-block').hide();
      jQuery('.yearly-kpi-block-one').hide();  
      jQuery('.yearly-kpi-block-two').hide();
      jQuery('.yearly-kpi-block-three').hide();
      jQuery('.yearly-kpi-block-four').hide();
      jQuery('.yearly-kpi-block-five').hide();    
      jQuery('.yearly-kpi-block-six').hide();
      jQuery('.yearly-kpi-block-seven').hide();  
      switch (highlighted) { 
      case 'QA': 
        jQuery('#viewtwo,#teamleads_tab').show();
        jQuery('.yearly-kpi-block-one').show();
        jQuery('.qa-team-block').show();        
        jQuery('.qa-team-block').removeClass('elementor-col-50').addClass('elementor-col-100');
        _tab = 'Over All KPI Yearly';
        yearly_overallkpi();
        break;
      case 'DESIGN': 
        jQuery('#viewtwo,#teamleads_tab').show();
        jQuery('.yearly-kpi-block-two').show();    
        jQuery('.web-design-team-block').show();
        jQuery('.web-design-team-block').removeClass('elementor-col-50').addClass('elementor-col-100');
        _tab = 'Over All KPI Yearly';
        yearly_overallkpi();
        break;
      case 'WPDEV': 
        jQuery('#viewtwo,#teamleads_tab').show();
        jQuery('.yearly-kpi-block-three').show();
        jQuery('.wpdev-team-block').show();
        jQuery('.wpdev-team-block').removeClass('elementor-col-50').addClass('elementor-col-100');
        _tab = 'Over All KPI Yearly';
        yearly_overallkpi();
        break;
      case 'FRONTEND': 
        jQuery('#viewtwo,#teamleads_tab').show();
        jQuery('.yearly-kpi-block-four').show();
        jQuery('.frontend-team-block').show();        
        jQuery('.frontend-team-block').removeClass('elementor-col-50').addClass('elementor-col-100');
        _tab = 'Over All KPI Yearly';
        yearly_overallkpi();
        break;
      case 'DMAU': 
        jQuery('#viewtwo,#teamleads_tab').show();
        jQuery('.yearly-kpi-block-five').show();
        jQuery('.dmau-team-block').show();
        jQuery('.dmau-team-block').removeClass('elementor-col-50').addClass('elementor-col-100');               
        _tab = 'Over All KPI Yearly';
        yearly_overallkpi();
        break;
      case 'DMEU': 
        jQuery('#viewtwo,#teamleads_tab').show();
        jQuery('.yearly-kpi-block-six').show();        
        jQuery('.dmeu-team-block').show();
        jQuery('.dmeu-team-block').removeClass('elementor-col-50').addClass('elementor-col-100');    
        _tab = 'Over All KPI Yearly';
        yearly_overallkpi();
        break;
      case 'TRAFFIC': 
        jQuery('#viewtwo,#teamleads_tab').show();
        jQuery('.yearly-kpi-block-seven').show();
        jQuery('.traffic-team-block').show();
        jQuery('.traffic-team-block').removeClass('elementor-col-50').addClass('elementor-col-100');
        _tab = 'Over All KPI Yearly';
        yearly_overallkpi();
        break;        
      default:
        jQuery('#viewtwo,#teamleads_tab').hide();
        _tab = "Over All KPI Yearly";
        jQuery('.yearly-kpi-block-one').show();
        jQuery('.yearly-kpi-block-two').show();
        jQuery('.yearly-kpi-block-three').show();
        jQuery('.yearly-kpi-block-four').show();
        jQuery('.yearly-kpi-block-five').show();
        jQuery('.yearly-kpi-block-six').show();
        jQuery('.yearly-kpi-block-seven').show();
        jQuery('.qa-team-block').show().removeClass('elementor-col-50').removeClass('elementor-col-100').addClass('elementor-col-50');
        jQuery('.web-design-team-block').show().removeClass('elementor-col-50').removeClass('elementor-col-100').addClass('elementor-col-50');
        jQuery('.wpdev-team-block').show().removeClass('elementor-col-50').removeClass('elementor-col-100').addClass('elementor-col-50');
        jQuery('.frontend-team-block').show().removeClass('elementor-col-50').removeClass('elementor-col-100').addClass('elementor-col-50');
        jQuery('.dmau-team-block').show().removeClass('elementor-col-50').removeClass('elementor-col-100').addClass('elementor-col-50');
        jQuery('.dmeu-team-block').show().removeClass('elementor-col-50').removeClass('elementor-col-100').addClass('elementor-col-50');
        jQuery('.traffic-team-block').show().removeClass('elementor-col-50').removeClass('elementor-col-100').addClass('elementor-col-50');

        yearly_overallkpi();
      }        
    });


    jQuery("#elementor-tab-title-7843").click( function(e) {
      var highlighted = jQuery('.highlight-b').attr('_data');
      switch (highlighted) { 
          case 'ALL': 
            jQuery('#viewtwo,#teamleads_tab').hide();
            _tab = "Over All KPI";
            production_overallkpi();        
            break;
          default:
            jQuery('#viewtwo,#teamleads_tab').show();
            _tab = 'Over All KPI Team';
            production_overallkpi();
      }
    });

    jQuery("#elementor-tab-title-7842").click( function(e) {
      var highlighted = jQuery('.highlight-b').attr('_data');
      switch (highlighted) { 
      case 'ALL': 
        jQuery('#viewtwo,#teamleads_tab').hide();
        _tab = "Over All KPI";
        production_quarterly_overallkpi();
        break;
      default:
        jQuery('#viewtwo,#teamleads_tab').show();
        _tab = 'Over All KPI Team';
        production_quarterly_overallkpi();
      }  

    });

    jQuery("#elementor-tab-title-6462").click( function(e) {
      var highlighted = jQuery('.highlight-b').attr('_data');
      switch (highlighted) { 
      case 'ALL': 
        jQuery('#viewtwo,#teamleads_tab').hide();
        break;
      default:
        jQuery('#viewtwo,#teamleads_tab').show();
        _tab = 'Over All KPI Lead';
        production_overallkpi_lead();
      }      
    }); 

    jQuery("#elementor-tab-title-6461").click( function(e) {
      var highlighted = jQuery('.highlight-b').attr('_data');
      switch (highlighted) { 
      case 'ALL': 
        jQuery('#viewtwo,#teamleads_tab').hide();
        break;
      default:
        jQuery('#viewtwo,#teamleads_tab').show();
        _tab = 'Over All KPI Lead';
        production_quarterly_overallkpi_lead();
      }       
    });

    function yearly_overallkpi(){
        /*jQuery('#productivity h2').html('<div class="loader"></div>');
        jQuery('#non_productivity h2').html('<div class="loader"></div>');
        jQuery('#unplanned_leave h2').html('<div class="loader"></div>');
        jQuery('#schedule_adherence h2').html('<div class="loader"></div>');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-7843 .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-7843 .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');
        jQuery('.tat_info').hide();
        jQuery('.task_info').hide();
        jQuery('.task_info .task_completed_block').hide();
        jQuery('.task_info .revision_tasks_block').hide();
        jQuery('.task_info .revision_tasks_block_two').hide();
        jQuery('.task_info .rev_sip').hide();*/

        var table_qa = jQuery('.qa-team-block .html-block #table-list');
        var table_wdesign = jQuery('.web-design-team-block .html-block #table-list');
        var table_wpdev = jQuery('.wpdev-team-block .html-block #table-list');
        var table_frontend = jQuery('.frontend-team-block .html-block #table-list');
        var table_dmau = jQuery('.dmau-team-block .html-block #table-list');
        var table_dmeu = jQuery('.dmeu-team-block .html-block #table-list');
        var table_traffic = jQuery('.traffic-team-block .html-block #table-list');

           // Emptying the Table items

        table_qa.find('thead').html('');
        table_wdesign.find('thead').html('');
        table_wpdev.find('thead').html('');
        table_frontend.find('thead').html('');
        table_dmau.find('thead').html('');
        table_dmeu.find('thead').html('');
        table_traffic.find('thead').html('');


        table_qa.find('tbody').html('');
        table_wdesign.find('tbody').html('');
        table_wpdev.find('tbody').html('');
        table_frontend.find('tbody').html('');
        table_dmau.find('tbody').html('');
        table_dmeu.find('tbody').html('');
        table_traffic.find('tbody').html('');


        var tr_h = jQuery('<tr>');
        tr_h.append('<th scope="col">EMPLOYEE NAME</th>');
        tr_h.append('<th scope="col">Q1</th>');
        tr_h.append('<th scope="col">Q2</th>');
        tr_h.append('<th scope="col">Q3</th>');
        tr_h.append('<th scope="col">Q4</th>');
        tr_h.append('<th scope="col">OVERALL '+ jQuery('#viewone #elementor-tab-content-7841 #form-field-year').find("option:selected").attr('value') +' KPI</th>');


        var tr = jQuery('<tr>');
        tr.append('<th class="py-1 px-2 text-center" colspan="6">Loading Data...</th>');

        table_qa.find('thead').append(tr_h.clone());
        table_wdesign.find('thead').append(tr_h.clone());
        table_wpdev.find('thead').append(tr_h.clone());
        table_frontend.find('thead').append(tr_h.clone());
        table_dmau.find('thead').append(tr_h.clone());
        table_dmeu.find('thead').append(tr_h.clone());
        table_traffic.find('thead').append(tr_h.clone());        

        table_qa.find('tbody').append(tr.clone());
        table_wdesign.find('tbody').append(tr.clone());
        table_wpdev.find('tbody').append(tr.clone());
        table_frontend.find('tbody').append(tr.clone());
        table_dmau.find('tbody').append(tr.clone());
        table_dmeu.find('tbody').append(tr.clone());
        table_traffic.find('tbody').append(tr.clone());

        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_overall_team_kpi", g_year : jQuery('#viewone #elementor-tab-content-7841 #form-field-year').find("option:selected").attr('value'),_data : jQuery('#listMenu a.highlight-b').attr('_data'),tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            table_qa = jQuery('.qa-team-block .html-block #table-list');
                            table_wdesign = jQuery('.web-design-team-block .html-block #table-list');
                            table_wpdev = jQuery('.wpdev-team-block .html-block #table-list');
                            table_frontend = jQuery('.frontend-team-block .html-block #table-list');
                            table_dmau = jQuery('.dmau-team-block .html-block #table-list');
                            table_dmeu = jQuery('.dmeu-team-block .html-block #table-list');
                            table_traffic = jQuery('.traffic-team-block .html-block #table-list');

                               // Emptying the Table items
                            table_qa.find('tbody').html('');
                            table_wdesign.find('tbody').html('');
                            table_wpdev.find('tbody').html('');
                            table_frontend.find('tbody').html('');
                            table_dmau.find('tbody').html('');
                            table_dmeu.find('tbody').html('');
                            table_traffic.find('tbody').html('');   

                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                Object.keys(response.data).map(k => {
                                  console.log(response.data[k].team + " : " + response.data[k].revieweeName);
                                    if(response.data[k].team == 'DESIGN'){
                                        if(response.data[k].overallKpi >= 4.5){
                                            var tr = jQuery('<tr class="kpi-met">');    
                                        }else{
                                            var tr = jQuery('<tr class="kpi-not-met">');    
                                        }
                                        tr.append('<td class="py-1 px-2">' + response.data[k].revieweeName +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q1Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q2Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q3Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q4Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].overallKpi.toFixed(2) +'</td>');
                                        
                                        table_wdesign.find('tbody').append(tr);
                                    }
                                    if(response.data[k].team == 'QA'){
                                        if(response.data[k].overallKpi >= 4.5){
                                            var tr = jQuery('<tr class="kpi-met">');    
                                        }else{
                                            var tr = jQuery('<tr class="kpi-not-met">');    
                                        }
                                        tr.append('<td class="py-1 px-2">' + response.data[k].revieweeName +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q1Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q2Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q3Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q4Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].overallKpi.toFixed(2) +'</td>');
                                        table_qa.find('tbody').append(tr);
                                    }
                                    if(response.data[k].team == 'WPDEV'){
                                        if(response.data[k].overallKpi >= 4.5){
                                            var tr = jQuery('<tr class="kpi-met">');    
                                        }else{
                                            var tr = jQuery('<tr class="kpi-not-met">');    
                                        }
                                        tr.append('<td class="py-1 px-2">' + response.data[k].revieweeName +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q1Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q2Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q3Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q4Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].overallKpi.toFixed(2) +'</td>');
                                        table_wpdev.find('tbody').append(tr);
                                    }
                                    if(response.data[k].team == 'DMEU'){
                                        if(response.data[k].overallKpi >= 4.5){
                                            var tr = jQuery('<tr class="kpi-met">');    
                                        }else{
                                            var tr = jQuery('<tr class="kpi-not-met">');    
                                        }
                                        tr.append('<td class="py-1 px-2">' + response.data[k].revieweeName +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q1Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q2Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q3Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q4Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].overallKpi.toFixed(2) +'</td>');
                                        table_dmeu.find('tbody').append(tr);
                                    }
                                    if(response.data[k].team == 'DMAU'){
                                        if(response.data[k].overallKpi >= 4.5){
                                            var tr = jQuery('<tr class="kpi-met">');    
                                        }else{
                                            var tr = jQuery('<tr class="kpi-not-met">');    
                                        }
                                        tr.append('<td class="py-1 px-2">' + response.data[k].revieweeName +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q1Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q2Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q3Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q4Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].overallKpi.toFixed(2) +'</td>');
                                        table_dmau.find('tbody').append(tr);
                                    }
                                    if(response.data[k].team == 'FRONTEND'){
                                        if(response.data[k].overallKpi >= 4.5){
                                            var tr = jQuery('<tr class="kpi-met">');    
                                        }else{
                                            var tr = jQuery('<tr class="kpi-not-met">');    
                                        }
                                        tr.append('<td class="py-1 px-2">' + response.data[k].revieweeName +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q1Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q2Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q3Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q4Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].overallKpi.toFixed(2) +'</td>');
                                        table_frontend.find('tbody').append(tr);
                                    }
                                    if(response.data[k].team == 'TRAFFIC'){
                                        if(response.data[k].overallKpi >= 4.5){
                                            var tr = jQuery('<tr class="kpi-met">');    
                                        }else{
                                            var tr = jQuery('<tr class="kpi-not-met">');    
                                        }
                                        tr.append('<td class="py-1 px-2">' + response.data[k].revieweeName +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q1Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q2Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q3Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].q4Kpi +'</td>');
                                        tr.append('<td class="py-1 px-2">' + response.data[k].overallKpi.toFixed(2) +'</td>');
                                        table_traffic.find('tbody').append(tr);
                                    }                                                                                                                                                                                     
                                });
                            }
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
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-7843 .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-7843 .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');
        jQuery('.tat_info').hide();
        jQuery('.task_info').hide();
        jQuery('.task_info .task_completed_block').hide();
        jQuery('.task_info .revision_tasks_block').hide();
        jQuery('.task_info .revision_tasks_block_two').hide();
        jQuery('.task_info .rev_sip').hide();

        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_production_overall_kpi", g_year : jQuery('#viewone #elementor-tab-content-7843 #form-field-year').find("option:selected").attr('value'),month : jQuery('#viewone #elementor-tab-content-7843 #form-field-month').find("option:selected").attr('value'),_data : jQuery('#listMenu a.highlight-b').attr('_data'),tab : _tab, nonce: user_object.nonce},
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


                                        jQuery('#productivity h2').html(displayPercent(response.data[k].productivity.toFixed(2)));
                                        jQuery('#non_productivity h2').html(displayPercent(response.data[k].nonProductivity.toFixed(2)));
                                        jQuery('#unplanned_leave h2').html(displayPercent(response.data[k].unplannedLeave.toFixed(2)));
                                        jQuery('#schedule_adherence h2').html(response.data[k].scheduleAdherence.toFixed(2));
                                        jQuery('#utilisation h2').html(displayPercent(response.data[k].utilization.toFixed(2)));

                                        jQuery('.tat_info .dep_tat_block .tot_task_with_tat .target-score').html(response.data[k].totalTat);
                                        jQuery('.tat_info .dep_tat_block .avg_ata_in_min .target-score').html(response.data[k].avgTatInMin);
                                        jQuery('.tat_info .dep_tat_block .tot_tasks_exeed_tat .target-score').html(response.data[k].exeedsTat);
                                        jQuery('.tat_info .dep_tat_block .tot_tasks_within_tat .target-score').html(response.data[k].withinTat);

                                        jQuery('.task_info .task_completed_block .total-completed-task .target-score').html(response.data[k].noOfCompletedTasks);
                                        jQuery('.task_info .task_completed_block .daily-avg-completed-tasks .target-score').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('.task_info .task_completed_block .hourly-avg-completed-tasks .target-score').html(response.data[k].hourlyAvgCompletedTask);


                                        jQuery('.tat_info').show();
                                        jQuery('.task_info').show();
                                        jQuery('.task_info .task_completed_block').show();
                                        if(jQuery('#listMenu a.highlight-b').attr('_data') == "DMAU"){

                                        jQuery('.task_info .revision_tasks_block .total-completed-revision-task .target-score').html(response.data[k].totalCompletedRevisionTask);
                                        jQuery('.task_info .revision_tasks_block .daily-avg-completed-revisons-task .target-score').html(response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));
                                        jQuery('.task_info .revision_tasks_block .hourly-avg-completed-revision-task .target-score').html(response.data[k].hourlyAvgCompletedRevisionTask.toFixed(0));
                                        jQuery('.task_info .revision_tasks_block_two .total-percentage-of-revisions-task .target-score').html(displayPercent(response.data[k].totalPercentageOfRevisionsTask.toFixed(2)));


                                            jQuery('.task_info .revision_tasks_block').show();
                                            jQuery('.task_info .revision_tasks_block_two').show();
                                            jQuery('.task_info .rev_sip').show();
                                        }
                                        

                                });
                            }
                        }
                      }
        }); 
    }

    function production_overallkpi_lead(){
        jQuery('#productivity_tl h2').html('<div class="loader"></div>');
        jQuery('#non_productivity_tl h2').html('<div class="loader"></div>');
        jQuery('#unplanned_leave_tl h2').html('<div class="loader"></div>');
        jQuery('#schedule_adherence_tl h2').html('<div class="loader"></div>');

        jQuery('.team-lead-name').html('Loading...');

        jQuery('#tot_tat_tl p').html('<div class="loader"></div>');
        jQuery('#avg_tat_min_tl p').html('<div class="loader"></div>');
        jQuery('#tot_exeed_tat_tl p').html('<div class="loader"></div>');
        jQuery('#tot_within_tat_tl p').html('<div class="loader"></div>');
        jQuery('#tot_completed_task_tl p').html('<div class="loader"></div>');
        jQuery('#daily_avg_completed_tast_tl p').html('<div class="loader"></div>');
        jQuery('#daily_avg_completed_tast_tl p').html('<div class="loader"></div>');
        jQuery('#hourly_avg_completed_task_tl p').html('<div class="loader"></div>');  

        jQuery('#viewtwo .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-6462 .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewtwo .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-6462 .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');
        
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_production_overall_kpi_lead", g_year : jQuery('#viewtwo #elementor-tab-content-6462 #form-field-year').find("option:selected").attr('value'),month : jQuery('#viewtwo #elementor-tab-content-6462 #form-field-month').find("option:selected").attr('value'),_data : jQuery('#listMenu a.highlight-b').attr('_data'),tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                Object.keys(response.data).map(k => {
                                 // creating new table row element
                                       if(parseFloat(response.data[k].productivity) > 71){
                                          jQuery('#_productivity_tl').addClass('criteria-pass');
                                          jQuery('#_productivity_tl').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_productivity_tl').removeClass('criteria-pass');
                                          jQuery('#_productivity_tl').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].nonProductivity) < 30){
                                          jQuery('#_non_productivity_tl').addClass('criteria-pass');
                                          jQuery('#_non_productivity_tl').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_non_productivity_tl').removeClass('criteria-pass');
                                          jQuery('#_non_productivity_tl').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].unplannedLeave) < 30){
                                          jQuery('#_unplanned_leave_tl').addClass('criteria-pass');
                                          jQuery('#_unplanned_leave_tl').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_unplanned_leave_tl').removeClass('criteria-pass');
                                          jQuery('#_unplanned_leave_tl').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].scheduleAdherence) > 3){
                                          jQuery('#_schedule_adherence_tl').addClass('criteria-pass');
                                          jQuery('#_schedule_adherence_tl').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_schedule_adherence_tl').removeClass('criteria-pass');
                                          jQuery('#_schedule_adherence_tl').addClass('criteria-failed');
                                       }

                                        jQuery('#productivity_tl h2').html(displayPercent(response.data[k].productivity.toFixed(2)));
                                        jQuery('#non_productivity_tl h2').html(displayPercent(response.data[k].nonProductivity.toFixed(2)));
                                        jQuery('#unplanned_leave_tl h2').html(displayPercent(response.data[k].unplannedLeave.toFixed(2)));
                                        jQuery('#schedule_adherence_tl h2').html(response.data[k].scheduleAdherence.toFixed(2));
                                        jQuery('#tot_tat_tl p').html(response.data[k].totalTaskWithTat);
                                        jQuery('#avg_tat_min_tl p').html(response.data[k].avgTatInMin);
                                        jQuery('#tot_exeed_tat_tl p').html(response.data[k].totalTaskExeedsTat);
                                        jQuery('#tot_within_tat_tl p').html(response.data[k].totalTaskWithinTat);
                                        jQuery('#tot_completed_task_tl p').html(response.data[k].totalCompletedTask);
                                        jQuery('#daily_avg_completed_tast_tl p').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('#daily_avg_completed_tast_tl p').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('#hourly_avg_completed_task_tl p').html(response.data[k].hourlyAvgCompletedTask);
                                        jQuery('.team-lead-name').html(response.data[k].name);
                                });
                            }
                        }
                      }
        }); 
    }

    function production_quarterly_overallkpi_lead(){
        jQuery('#productivity_tl_q h2').html('<div class="loader"></div>');
        jQuery('#non_productivity_tl_q h2').html('<div class="loader"></div>');
        jQuery('#unplanned_leave_tl_q h2').html('<div class="loader"></div>');
        jQuery('#schedule_adherence_tl_q h2').html('<div class="loader"></div>');
        jQuery('.team-lead-name').html('Loading...');

        jQuery('#tot_tat_tl_q p').html('<div class="loader"></div>');
        jQuery('#avg_tat_min_tl_q p').html('<div class="loader"></div>');
        jQuery('#tot_exeed_tat_tl_q p').html('<div class="loader"></div>');
        jQuery('#tot_within_tat_tl_q p').html('<div class="loader"></div>');
        jQuery('#tot_completed_task_tl_q p').html('<div class="loader"></div>');
        jQuery('#daily_avg_completed_tast_tl_q p').html('<div class="loader"></div>');
        jQuery('#daily_avg_completed_tast_tl_q p').html('<div class="loader"></div>');
        jQuery('#hourly_avg_completed_task_tl_q p').html('<div class="loader"></div>');
        jQuery('#q_one_kpi p').html('<div class="loader"></div>');
        jQuery('#q_two_kpi p').html('<div class="loader"></div>');
        jQuery('#q_three_kpi p').html('<div class="loader"></div>');
        jQuery('#q_four_kpi p').html('<div class="loader"></div>');

        jQuery('#viewtwo .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-6462 .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewtwo .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-6462 .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');


        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_production_quarterly_overall_kpi_lead", g_year : jQuery('#viewtwo #elementor-tab-content-6461 #form-field-year').find("option:selected").attr('value'),quarter : jQuery('#viewtwo #elementor-tab-content-6461 #form-field-quarter').find("option:selected").attr('value'),_data : jQuery('#listMenu a.highlight-b').attr('_data'),tab : _tab, nonce: user_object.nonce},
             success: function(response) {
                        if(response.type == "success") {
                            if (response.data.length > 0) {
                                var i = 1;
                                // looping the returned data
                                Object.keys(response.data).map(k => {
                                 // creating new table row element
                                       if(parseFloat(response.data[k].productivity) > 71){
                                          jQuery('#_productivity_tl_q').addClass('criteria-pass');
                                          jQuery('#_productivity_tl_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_productivity_tl_q').removeClass('criteria-pass');
                                          jQuery('#_productivity_tl_q').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].nonProductivity) < 30){
                                          jQuery('#_non_productivity_tl_q').addClass('criteria-pass');
                                          jQuery('#_non_productivity_tl_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_non_productivity_tl_q').removeClass('criteria-pass');
                                          jQuery('#_non_productivity_tl_q').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].unplannedLeave) < 30){
                                          jQuery('#_unplanned_leave_tl_q').addClass('criteria-pass');
                                          jQuery('#_unplanned_leave_tl_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_unplanned_leave_tl_q').removeClass('criteria-pass');
                                          jQuery('#_unplanned_leave_tl_q').addClass('criteria-failed');
                                       }

                                       if(parseFloat(response.data[k].scheduleAdherence) > 3){
                                          jQuery('#_schedule_adherence_tl_q').addClass('criteria-pass');
                                          jQuery('#_schedule_adherence_tl_q').removeClass('criteria-failed');
                                       }else{
                                          jQuery('#_schedule_adherence_tl_q').removeClass('criteria-pass');
                                          jQuery('#_schedule_adherence_tl_q').addClass('criteria-failed');
                                       }

                                        jQuery('#productivity_tl_q h2').html(displayPercent(response.data[k].productivity.toFixed(2)));
                                        jQuery('#non_productivity_tl_q h2').html(displayPercent(response.data[k].nonProductivity.toFixed(2)));
                                        jQuery('#unplanned_leave_tl_q h2').html(displayPercent(response.data[k].unplannedLeave.toFixed(2)));
                                        jQuery('#schedule_adherence_tl_q h2').html(response.data[k].scheduleAdherence.toFixed(2));
                                        jQuery('#tot_tat_tl_q p').html(response.data[k].totalTaskWithTat);
                                        jQuery('#avg_tat_min_tl_q p').html(response.data[k].avgTatInMin);
                                        jQuery('#tot_exeed_tat_tl_q p').html(response.data[k].totalTaskExeedsTat);
                                        jQuery('#tot_within_tat_tl_q p').html(response.data[k].totalTaskWithinTat);
                                        jQuery('#tot_completed_task_tl_q p').html(response.data[k].totalCompletedTask);
                                        jQuery('#daily_avg_completed_tast_tl_q p').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('#daily_avg_completed_tast_tl_q p').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('#hourly_avg_completed_task_tl_q p').html(response.data[k].hourlyAvgCompletedTask);
                                        jQuery('.team-lead-name').html(response.data[k].name);
                                        jQuery('#q_one_kpi p').html(response.data[k].q1.toFixed(2));
                                        jQuery('#q_two_kpi p').html(response.data[k].q2.toFixed(2));
                                        jQuery('#q_three_kpi p').html(response.data[k].q3.toFixed(2));
                                        jQuery('#q_four_kpi p').html(response.data[k].q4.toFixed(2));                                        
                                });
                            }
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
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-7842 .prod-boxes .elementor-container .elementor-column').addClass('criteria-pass');
        jQuery('#viewone .elementor-tabs .elementor-tabs-content-wrapper #elementor-tab-content-7842 .prod-boxes .elementor-container .elementor-column').removeClass('criteria-failed');

        jQuery('.tat_info_q').hide();
        jQuery('.task_info_q').hide();
        jQuery('.task_info_q .task_completed_block').hide();
        jQuery('.task_info_q .revision_tasks_block').hide();
        jQuery('.task_info_q .revision_tasks_block_two').hide();
        jQuery('.task_info_q .rev_sip').hide();        
        
        jQuery.ajax({
             type : "post",
             dataType : "json",
             url : user_object.ajaxurl,
             data : {action: "g_production_quarterly_overall_kpi", g_year : jQuery('#viewone #elementor-tab-content-7842 #form-field-year').find("option:selected").attr('value'),quarter : jQuery('#viewone #elementor-tab-content-7842 #form-field-quarter').find("option:selected").attr('value'),_data : jQuery('#listMenu a.highlight-b').attr('_data'),tab : _tab, nonce: user_object.nonce},
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
                                        jQuery('#schedule_adherence_q h2').html(response.data[k].scheduleAdherence.toFixed(2));
                                        jQuery('#utilization_q h2').html(displayPercent(response.data[k].utilization.toFixed(2)));

                                        jQuery('.tat_info_q .dep_tat_block .tot_task_with_tat .target-score').html(response.data[k].totalTat);
                                        jQuery('.tat_info_q .dep_tat_block .avg_ata_in_min .target-score').html(response.data[k].avgTatInMin);
                                        jQuery('.tat_info_q .dep_tat_block .tot_tasks_exeed_tat .target-score').html(response.data[k].exeedsTat);
                                        jQuery('.tat_info_q .dep_tat_block .tot_tasks_within_tat .target-score').html(response.data[k].withinTat);

                                        jQuery('.task_info_q .task_completed_block .total-completed-task .target-score').html(response.data[k].noOfCompletedTasks);
                                        jQuery('.task_info_q .task_completed_block .daily-avg-completed-tasks .target-score').html(response.data[k].dailyAvgCompletedTask);
                                        jQuery('.task_info_q .task_completed_block .hourly-avg-completed-tasks .target-score').html(response.data[k].hourlyAvgCompletedTask);

                                        jQuery('.tat_info_q').show();
                                        jQuery('.task_info_q').show();
                                        jQuery('.task_info_q .task_completed_block').show();

                                        if(jQuery('#listMenu a.highlight-b').attr('_data') == "DMAU"){

                                        jQuery('.task_info_q .revision_tasks_block .total-completed-revision-task .target-score').html(response.data[k].totalCompletedRevisionTask);
                                        jQuery('.task_info_q .revision_tasks_block .daily-avg-completed-revisons-task .target-score').html(response.data[k].dailyAvgCompletedRevisonsTask.toFixed(0));
                                        jQuery('.task_info_q .revision_tasks_block .hourly-avg-completed-revision-task .target-score').html(response.data[k].hourlyAvgCompletedRevisionTask.toFixed(0));
                                        jQuery('.task_info_q .revision_tasks_block_two .total-percentage-of-revisions-task .target-score').html(displayPercent(response.data[k].totalPercentageOfRevisionsTask.toFixed(2)));


                                            jQuery('.task_info_q .revision_tasks_block').show();
                                            jQuery('.task_info_q .revision_tasks_block_two').show();
                                            jQuery('.task_info_q .rev_sip').show();
                                        }                                        

                                });
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

  });
})(jQuery);