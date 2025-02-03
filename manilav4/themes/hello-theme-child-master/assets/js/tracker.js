(function($){
	'use strict';

	// --
	// -- INIT
	// --

	var _tasks = [];
	var _timerformatteddata = {};
	$(document).ready(function(){
		// ADD TASKS TO BOARD
		$('.warning_red.elementor-widget-alert').css("display","none");
		$('.warning_green.elementor-widget-alert').css("display","none");
		$('.warning_yellow.elementor-widget-alert').css("display","none");
		$('.warning_blue.elementor-widget-alert').css("display","none");
		$('.gform_wrapper .gform-button.sp_task_duplicate').hide();
		_tasks = sp_tracker_obj.tasks;
		if(_tasks.length > 0){
			Object.entries(_tasks).forEach(([key, data]) => {
				var task_spon = (data.Spon) ? data.Spon : "------";
				var duration = (data.duration) ? time_stamp_to_hms(data.duration/86400) : "0:0:00";
				var elm = "<div>"+ "<b>ID : "+ data.ID +"</b> <sup>Duration : "+ duration +" </sup><sub>SP : "+ task_spon + "</sub><br>" + data['Task Type'] +"</div>";
				var task_name = (data['Task Type']) ? elm : 'New Task';
				var task_id = data.ID;
				var task_status = data.status;
				$('#sp-list-'+task_status+' .elementor-tab-content').prepend('<a href="#" data-id="'+task_id+'" class="task-item task-item-active">'+task_name+'</a>');
				if(data.status == 'progress'){
					update_task_time(task_id);	
				}
				
				var tmstmp = new Date(data.date);
				var tmstmps = new Date(data.timestamp);

				var tmp_ZONE = {timeZone: 'Asia/Manila'};
				var tmstmp_PST = tmstmps.toLocaleString('en-US', tmp_ZONE);

				var year = tmstmp.toLocaleString("default", { year: "numeric" });
				var month = tmstmp.toLocaleString("default", { month: "2-digit" });
				var day = tmstmp.toLocaleString("default", { day: "2-digit" });					
				var formattedDate = year + "-" + month + "-" + day;
				data.timestamp = tmstmp_PST;
				data.date = formattedDate;
			});
		}
	});



	$(window).load(function(){	
		// CREATE EMPTY TASK INITIALLY
		create_task();
		count_tab_content();
		hide_break_lunch_break();
	});

	// --
	// -- TRIGGERS
	// --

	// ON CREATE NEW TASK	
	$(document).on('click','#sp-button-new',function(){
		save_active_task();
		create_task();
		count_tab_content();
		hide_break_lunch_break();
		return false;
	});

	// ON TASK CLICK
	$(document).on('click','.task-list .task-item',function(){
		save_active_task();
		$('.elementor-tab-content .task-item').removeClass('task-item-active');
		if(!$(this).hasClass('task-item-active')) $(this).addClass('task-item-active');
		var task_id = $(this).data('id');
		var task = get_task_by_id(task_id);
		console.log(task.status);
		if(task.status == "progress-saving"){
			$('.gform_wrapper #field_16_13').append("<p class='noticemessage'>You're data is being saved Please Wait!!!</p>" );		
			$('.gform_wrapper .sp_task_next').hide();
		}

		if(task.status == "paused"){
			//diff = date2 - date1;
			var date1 = task.date;
			var date2 = $.date(new Date());
			var date3 = new Date(date1 + ' 23:59:59');
			var date4 = new Date(date2);
			var millisBetween = date4.getTime() - date3.getTime();  
			var days = millisBetween / 1000;
			days /= 3600/60;
			days = Math.round(Math.abs(days));
			$('.gform_wrapper #field_16_13 .noticemessage').remove();
			if(( $.date(task.date) != $.date(new Date())) && days > 90)
			{
				$('.gform_wrapper .gform-button.sp_task_duplicate').show();
				$('.gform_wrapper .gform-button.sp_task_next').css('opacity','0');
				$('.gform_wrapper .gform-button.sp_task_next').attr('disabled','true');
			}else{
				$('.gform_wrapper .gform-button.sp_task_duplicate').hide();
				$('.gform_wrapper .gform-button.sp_task_next').css('opacity','100');
				$('.gform_wrapper .gform-button.sp_task_next').addClass('pausedstyle');
				$('.gform_wrapper .gform-button.sp_task_next').removeAttr('disabled');
			}
		}else{
			$('.gform_wrapper .gform-button.sp_task_duplicate').hide();
			$('.gform_wrapper .gform-button.sp_task_next').css('opacity','100');
			$('.gform_wrapper .gform-button.sp_task_next').removeAttr('disabled');
			$('.gform_wrapper .gform-button.sp_task_next').removeClass('pausedstyle');
			$('.gform_wrapper #gform_submit_button_16').css('opacity','100');
			$('.gform_wrapper #gform_submit_button_16').removeAttr('disabled');			
		}
		if(task.status == "completed"){
			if($.date(task.date) < $.date(new Date()))
			{
				console.log('date less');
				$('.gform_wrapper .gform-button.sp_task_duplicate').hide();
				$('.gform_wrapper #gform_submit_button_16').css('opacity','0');
				$('.gform_wrapper #gform_submit_button_16').attr('disabled','true');
				$('.gform_wrapper .gform-button.sp_task_next').css('opacity','0');
				$('.gform_wrapper .gform-button.sp_task_next').attr('disabled','true');
			}else{
				console.log('date match');
				$('.gform_wrapper .gform-button.sp_task_duplicate').hide();
				$('.gform_wrapper #gform_submit_button_16').css('opacity','100');
				$('.gform_wrapper #gform_submit_button_16').removeAttr('disabled');
				$('.gform_wrapper .gform-button.sp_task_next').css('opacity','100');
				$('.gform_wrapper .gform-button.sp_task_next').removeAttr('disabled');
			}
		}
		



		restore_task_data(task_id);
		update_task_buttons(task_id);
		return false;
	});
	
	//Paused Item Click event
	// ON GFORM SUBMIT
	$(document).on('click','.gform_wrapper .gform-button.sp_task_duplicate',function(){
		var task_id = $('#sp-list-paused .elementor-tab-content .task-item.task-item-active').data('id');
		var task_pos = get_task_index_by_id(task_id);
		var task_status = 'completed';

		if(_tasks[task_pos].status.includes('-saving')){
			//alert('Unable to proceed, task is being saved');
			$('#calendarModal').modal();
			return false;
		}

		var duration = (_tasks[task_pos].duration) ? time_stamp_to_hms(_tasks[task_pos].duration/86400) : "0:0:00";
		var task_spon = (_tasks[task_pos].Spon) ? _tasks[task_pos].Spon : "------";
		var elm = "<div>"+ "<b>ID : "+ _tasks[task_pos].ID +"</b> <sup>Duration : "+ duration +" </sup><sub>SP : "+ task_spon + "</sub><br>" + _tasks[task_pos]['Task Type'] +"</div>";
		var task_name = (_tasks[task_pos]['Task Type']) ? elm : 'New Task';		

		//var task_name = (_tasks[task_pos].Task) ? _tasks[task_pos].Task : 'New Task';
		$('.elementor-tab-content .task-item.task-item-active').remove();
		$('#sp-list-'+task_status+' .elementor-tab-content').prepend('<a href="#" data-id="'+task_id+'" class="task-item task-item-active">'+task_name+'</a>');

		_tasks[task_pos]['Parent'] = (_tasks[task_pos].Parent == "") ? task_id : _tasks[task_pos].Parent;

		update_task_status(task_id,task_status);
		send_task_to_gsheet(task_id);
		update_task_status(task_id,task_status+'-saving');		

		create_new_child_task_data(_tasks[task_pos].Parent);
		create_child_task_data(task_id);
		count_tab_content();
	});	

	// ON GFORM NEXT CLICK
	$(document).on('click','.gform_wrapper .gform-button.sp_task_next',function(){
		var task_id = $('.elementor-tab-content .task-item.task-item-active').data('id');
		var task_pos = get_task_index_by_id(task_id);
		var task_status = (_tasks[task_pos].status == 'progress') ? 'paused' : 'progress';
		console.log('started');
		$('.gform_wrapper #field_16_13').append("<p class='noticemessage'>You're data is being saved Please Wait!!!</p>" );		
		$('.gform_wrapper .sp_task_next').hide();

		if(_tasks[task_pos].status.includes('-saving')){
			//alert('Unable to proceed, task is being saved');
			$('#calendarModal').modal();
			return false;
		}
		
		// CHECK IF USER CAN MULTITASK
		if(check_multitask_tracking() && task_status=='progress'){
			//alert('Unable to proceed, a task is already running');
			$('#calendarModal').modal();
			return false;
		}
		
		save_active_task(task_id);
		var duration = (_tasks[task_pos].duration) ? time_stamp_to_hms(_tasks[task_pos].duration/86400) : "0:0:00";
		var task_spon = (_tasks[task_pos].Spon) ? _tasks[task_pos].Spon : "------";
		var elm = "<div>"+ "<b>ID : "+ _tasks[task_pos].ID +"</b> <sup>Duration : "+ duration +" </sup> <sub>SP : "+ task_spon + "</sub><br>" + _tasks[task_pos]['Task Type'] +"</div>";
		var task_name = (_tasks[task_pos]['Task Type']) ? elm : 'New Task';


		//var task_name = (_tasks[task_pos].Task) ? _tasks[task_pos].Task : 'New Task';
		$('.elementor-tab-content .task-item.task-item-active').remove();
		$('#sp-list-'+task_status+' .elementor-tab-content').prepend('<a href="#" data-id="'+task_id+'" class="task-item task-item-active">'+task_name+'</a>');

		update_task_status(task_id,task_status);
		update_task_buttons(task_id);
		if(task_status == 'paused' || task_status == 'progress'){
// 			if(task_status == 'progress'){
				update_task_time(task_id);
// 			}
			send_task_to_gsheet(task_id);
			update_task_status(task_id,task_status+'-saving');
		}
		count_tab_content();
		$('#input_16_3').trigger("change");
		return false;
	});



	// ON GFORM SUBMIT
	//$(document).on('click','.gform_wrapper .gform-button.gform-button--white',function(){
	$(document).on('click','.gform_wrapper #gform_submit_button_16',function(e){
		var task_id = $('.elementor-tab-content .task-item.task-item-active').data('id');
		var task_pos = get_task_index_by_id(task_id);
		var task_status = 'completed';
		if($('#field_16_26').css('display') !== 'none'){
			var arr = ["EU","AU"];
			if($.inArray($('input[name="input_26"]:checked').val(),arr) != -1){
			}else{
				jQuery('.warning_red.elementor-widget-alert').css("display","block");
				jQuery('.warning_red.elementor-widget-alert .elementor-alert').css("display","");
				jQuery('.warning_red.elementor-widget-alert .elementor-alert .elementor-alert-title').text('Tagging Info');
				jQuery('.warning_red.elementor-widget-alert .elementor-alert .elementor-alert-description').text('Region is Required');
				e.preventDefault();
				return;
			}		
		}else{
			console.log('Display None');
		}
		if(_tasks[task_pos].status.includes('-saving')){
			//alert('Unable to proceed, task is being saved');
			$('#calendarModal').modal();			
			return false;
		}
		if(_tasks[task_pos].status != "paused"){
			console.log('track time');
			update_task_time(task_id);	
		}

		save_active_task(task_id);
		var duration = (_tasks[task_pos].duration) ? time_stamp_to_hms(_tasks[task_pos].duration/86400) : "0:0:00";
		var task_spon = (_tasks[task_pos].Spon) ? _tasks[task_pos].Spon : "------";
		var elm = "<div>"+ "<b>ID : "+ _tasks[task_pos].ID +"</b> <sup>Duration : "+ duration +" </sup><sub>SP : "+ task_spon + "</sub><br>" + _tasks[task_pos]['Task Type'] +"</div>";
		var task_name = (_tasks[task_pos]['Task Type']) ? elm : 'New Task';		

		//var task_name = (_tasks[task_pos].Task) ? _tasks[task_pos].Task : 'New Task';
		$('.elementor-tab-content .task-item.task-item-active').remove();
		$('#sp-list-'+task_status+' .elementor-tab-content').prepend('<a href="#" data-id="'+task_id+'" class="task-item task-item-active">'+task_name+'</a>');

		update_task_status(task_id,task_status);
		update_task_buttons(task_id);
		//update_task_time(task_id);
		send_task_to_gsheet(task_id);
		update_task_status(task_id,task_status+'-saving');
		count_tab_content();
		return false;
	});

	// --
	// -- METHODS
	// --

	// CREATE TASK
	function create_task(){
		var task_id = Date.now();
		$('.elementor-tab-content .task-item').removeClass('task-item-active');
		$('#sp-list-new .elementor-tab-content').prepend('<div href="#" data-id="'+task_id+'" class="task-item task-item-active">New Task | <a href="" class="task-delete">Delete</a></div>');
		$('.elementor-tab-title:not(.elementor-active)').trigger('click');
		

		var tmstmps = new Date();

		var tmp_ZONE = {timeZone: 'Asia/Manila'};
		var tmstmp_PST = tmstmps.toLocaleString('en-US', tmp_ZONE);


		var date2 = $.date(new Date());
		var date3 = new Date(date2 + ' 0:30:00');


		console.log(tmstmp_PST);
		console.log(date3.toLocaleString('en-US', tmp_ZONE));	

		console.log(date3.getTime());
		console.log(tmstmps.getTime());

		var millisBetween = tmstmps.getTime() - date3.getTime();
		var days = millisBetween / 1000;
		days /= 3600/60;

		if(days < 0){
			_tasks.push({'Name':sp_tracker_obj.user,'ID':task_id,'status':'new','date':$.date(deductOneDayToDate(tmstmps))});
		}else{
			_tasks.push({'Name':sp_tracker_obj.user,'ID':task_id,'status':'new','date':$.date(tmstmps)});			
		}


		console.log('new');
		console.log(_tasks);
		update_task_buttons(task_id);
		clear_gform();
		jQuery('#choice_16_12_0').prop('checked',true);
		jQuery('#choice_16_18_0').prop('checked',true);
		return task_id;
	}


	$(document).on('click','.task-delete',function(e){
		e.preventDefault;
		$(this).parent().remove();
		count_tab_content();
	});

	//Hide Ragion Option for Non Tat task

	$(document).on('change','#input_16_3',function(e){
		var tat = ['Select Task Type','Admin Tasks','Break / Lunch break','Manila Dashboard Improvement','Internal Research and Development Projects','Training','Coaching / 1on1','Idle Time','Catchup / Meeting','1on1 Session','Coaching 1on1 / Training']
		console.log($.inArray(this.value, tat));		
		if($.inArray(this.value, tat) != -1) {
		    $('#field_16_26').hide();
		    $('input[name="input_26"]').attr('checked', false).removeAttr("checked"); 
		} else {
		    $('#field_16_26').show();
		}
	});

	// HIDE Break / Lunch break
	function hide_break_lunch_break(task_id = false){

		var dt = new Date();
		var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();		

		var diff = ( new Date("1970-1-1 " + time) - new Date("1970-1-1 " + user_object.starttime) ) / 1000 / 60 / 60; 

		if(diff < 1.6 || diff > 7.4){
			jQuery('.warning_blue.elementor-widget-alert').css("display","block");
			jQuery('.warning_blue.elementor-widget-alert .elementor-alert').css("display","");
			jQuery('.warning_blue.elementor-widget-alert .elementor-alert .elementor-alert-title').text('Tagging Info');
			jQuery('.warning_blue.elementor-widget-alert .elementor-alert .elementor-alert-description').text('Break / Lunch break Tagging will be available after 1.5 hours from start of shift until 1.5 hours before end of shift');
			jQuery("#input_16_3 option[value='Break / Lunch break']").hide();
		}else{
			jQuery('.warning_blue.elementor-widget-alert').css("display","none");
			jQuery('.warning_blue.elementor-widget-alert .elementor-alert').css("display","none");
			jQuery("#input_16_3 option[value='Break / Lunch break']").show();
		}

	}




	
	// SAVE ACTIVE TASK
	function save_active_task(task_id = false){
		if(task_id === false) var task_id = $('.elementor-tab-content .task-item.task-item-active').data('id');
		var task_pos = get_task_index_by_id(task_id);
		if(task_pos !== false){
			$('.gform_wrapper .gform_fields > .gfield').each(function(){
				if($(this).hasClass('gfield--type-html') || $(this).hasClass('gfield--type-submit')) return;
				var field_inpt = '>.ginput_container > *';
				if($(this).find('>.ginput_container').hasClass('ginput_container_radio')) {
					field_inpt = '>.ginput_container input[type="radio"]:checked';
				}
				var field_lbl_val = $(this).find('>.gfield_label').html();
				var field_inpt_val = $(this).find(field_inpt).val();
				_tasks[task_pos][field_lbl_val] = (field_inpt_val) ? field_inpt_val : '';		
			});
		}
	}

	// RESTORE TASK DATA TO GFORM FIELDS
	function restore_task_data(task_id){
		var task = get_task_by_id(task_id);
		if(task){
			$('.gform_wrapper .gform_fields > .gfield').each(function(){
				if($(this).hasClass('gfield--type-html') || $(this).hasClass('gfield--type-submit')) return;
				var field_inpt = '>.ginput_container > *';
				var field_inpt_val = task[$(this).find('>.gfield_label').html()];
				if($(this).find('>.ginput_container').hasClass('ginput_container_radio')) {
					field_inpt = '>.ginput_container input[type="radio"]';
					$(this).find(field_inpt).prop('checked',false);
					if(field_inpt_val) $(this).find(field_inpt + '[value="'+field_inpt_val+'"]').prop('checked',true);
				}else{
					$(this).find(field_inpt).val(field_inpt_val);		
				}
			});
			$('#input_16_3').trigger('change');
			return task;
		}else{
			return false;
		}
	}
	//Create Child Task

	function create_new_child_task_data(ptask_id){
		var task_id = Date.now();
		while(get_task_by_id(task_id)) task_id = Date.now();
		$('.elementor-tab-content .task-item').removeClass('task-item-active');
		$('#sp-list-new .elementor-tab-content').prepend('<div href="#" data-id="'+task_id+'" class="task-item task-item-active">New Task | <a href="" class="task-delete">Delete</a></div>');
		$('.elementor-tab-title:not(.elementor-active)').trigger('click');


		var tmstmps = new Date();

		var tmp_ZONE = {timeZone: 'Asia/Manila'};
		var tmstmp_PST = tmstmps.toLocaleString('en-US', tmp_ZONE);


		var date2 = $.date(new Date());
		var date3 = new Date(date2 + ' 0:30:00');


		var millisBetween = tmstmps.getTime() - date3.getTime();
		var days = millisBetween / 1000;
		days /= 3600/60;

		if(days < 0){
			_tasks.push({'Name':sp_tracker_obj.user,'ID':task_id,'status':'new','date':$.date(deductOneDayToDate(tmstmps)),'Parent':ptask_id});
		}else{
			_tasks.push({'Name':sp_tracker_obj.user,'ID':task_id,'status':'new','date':$.date(tmstmps),'Parent':ptask_id});			
		}


		update_task_buttons(task_id);
		clear_gform();
		return task_id;
	}

	function create_child_task_data(task_id){
		var task = get_task_by_id(task_id);
		if(task){
			$('.gform_wrapper .gform_fields > .gfield').each(function(){
				if($(this).hasClass('gfield--type-html') || $(this).hasClass('gfield--type-submit')) return;
				var field_inpt = '>.ginput_container > *';
				var field_inpt_val = task[$(this).find('>.gfield_label').html()];
				if($(this).find('>.ginput_container').hasClass('ginput_container_radio')) {
					field_inpt = '>.ginput_container input[type="radio"]';
					$(this).find(field_inpt).prop('checked',false);
					if(field_inpt_val) $(this).find(field_inpt + '[value="'+field_inpt_val+'"]').prop('checked',true);
				}else{
					$(this).find(field_inpt).val(field_inpt_val);		
				}
			});
			return task;
		}else{
			return false;
		}
	}	
	
	// CLEAR GFORM FIELDS
	function clear_gform(){
		$('.gform_wrapper .gform_fields > .gfield').each(function(){
			if($(this).hasClass('gfield--type-html') || $(this).hasClass('gfield--type-submit')) return;
			var field_inpt = '>.ginput_container > *';
			if($(this).find('>.ginput_container').hasClass('ginput_container_radio')) {
				field_inpt = '>.ginput_container input[type="radio"]';
				$(this).find(field_inpt).prop('checked',false);
			}else{
				$(this).find(field_inpt).val('');
			}
		});
	}
	
	// UPDATE FORM BUTTONS
	function update_task_buttons(task_id){
		var task = get_task_by_id(task_id);
		var task_status = "Start Task";
		if(task.status == "progress") task_status = "Pause Task";
		console.log(task.status);
		$('.gform_wrapper .gform-button.sp_task_next').html(task_status);
		if(task.status == "paused" || task.status == "completed" || task.status == "progress"){
			$('.gform_wrapper #gform_submit_button_16').show();
			$('.gform_wrapper .sp_task_next').show();
			$('.gform_wrapper #field_16_13 .noticemessage').remove();			
		}else{
			$('.gform_wrapper #gform_submit_button_16').hide();
		}
	}
	

	// UPDATE TASK STATUS
	function update_task_status(task_id = false,status){
		$('.gform_wrapper #gform_submit_button_16').hide();
		$('.gform_wrapper .sp_task_next').hide();
		$('#calendarModal').modal('hide');
		if(task_id === false) task_id = $('.elementor-tab-content .task-item.task-item-active').data('id');
		var	task_pos = get_task_index_by_id(task_id);
		if(task_pos !== false) _tasks[task_pos]['status'] = status;
	}

	// UPDATE TASK TIME
	function update_task_time(task_id){
		if(task_id === false) task_id = $('.elementor-tab-content .task-item.task-item-active').data('id');
		var	task_pos = get_task_index_by_id(task_id);
		var _asda = 0;
		_timerformatteddata = _tasks[task_pos]
		if(_tasks[task_pos]['status'] == 'completed'){
			return;
		}
		if(task_pos !== false){
			var tmstmp = new Date();
// 			var tmstmp_PST = tmstmp.toLocaleString('PST');
			var tmp_ZONE = {timeZone: 'Asia/Manila'};
			var tmstmp_PST = tmstmp.toLocaleString('en-US', tmp_ZONE);
			if(_tasks[task_pos]['pause']){
				_tasks[task_pos]['pause'].push(tmstmp_PST);
				if (_tasks[task_pos]['pause'].length % 2 == 0) {
					_tasks[task_pos]['duration'] = getTimeDiff('pause','sec');
					_tasks[task_pos]['displaydame'] = sp_tracker_obj.displayname;
				}
			}else{
				var year = tmstmp.toLocaleString("default", { year: "numeric" });
				var month = tmstmp.toLocaleString("default", { month: "2-digit" });
				var day = tmstmp.toLocaleString("default", { day: "2-digit" });					
				var formattedDate = year + "-" + month + "-" + day;

				_tasks[task_pos]['timestamp'] = tmstmp_PST
				_tasks[task_pos]['pause'] = [tmstmp_PST];
				_tasks[task_pos]['duration'] = 0;
				//_tasks[task_pos]['date'] = formattedDate;
				_tasks[task_pos]['team'] = sp_tracker_obj.team;
				_tasks[task_pos]['displaydame'] = sp_tracker_obj.displayname;
			}
		}
	}

	// SUBMIT TASK TO GSHEET
	function send_task_to_gsheet(task_id){
		if(task_id === false) task_id = $('.elementor-tab-content .task-item.task-item-active').data('id');
		var	task_pos = get_task_index_by_id(task_id);
		if(task_pos !== false){
			$.get(sp_tracker_obj.daily_sheet, {action:'add_task',data:JSON.stringify(_tasks[task_pos])}, function(response, textStatus, jqXHR){
				if(response.success){
					update_task_status(task_id,_tasks[task_pos].status.replace('-saving',''));
					update_task_buttons(task_id);
				}
			});
		}
	}
	
	// 	CHECK IF USER CAN MULTITASK
	function check_multitask_tracking(){
		var team_can_multitask = ['DMEU'];
		if(team_can_multitask.includes(sp_tracker_obj.team)) return false;
		return (get_task_by_status('progress')) ? true : false;
	}

	// GET TASK BY ID
	function get_task_by_id(task_id){
		if(task_id === false) return false;
		var task = _tasks.filter(task => task.ID == task_id)
		return ((task) && task.length > 0) ? task[0] : false;
	}

	// GET TASK POS BY ID
	function get_task_index_by_id(task_id){
		if(task_id === false) return false;
		var task_pos = false;
		_tasks.map((task,ind) => {
			if(task.ID == task_id){
				task_pos = ind;
			}
			return task;
		});
		return task_pos;
	}
	
	// GET TASK BY STATUS
	function get_task_by_status(status){
		if(status === false) return false;
		var task = _tasks.filter(task => task.status == status || task.status == status + '-saving')
		return ((task) && task.length > 0) ? task[0] : false;
	}

	// get time diff
	function getTimeDiff(timerkey,format = 'mins'){
		var timeres = 0;
		if(_timerformatteddata.hasOwnProperty(timerkey)){
			for(var i=0;i < _timerformatteddata[timerkey].length;i+=2){
				var initime = Date.parse(_timerformatteddata[timerkey][i]);
				var timestamp = Date.parse(_timerformatteddata[timerkey][i+1]);
				var difference = timestamp - initime;
				timeres += (format == 'mins') ? Math.floor(difference/1000/60) : difference/1000;
			}

			if(timeres){
				if(format == 'mins') return timeres;
				else return Math.abs(timeres);
			}
		}

		return "";
	}

	//Count Tad Item
	function count_tab_content(){
		$('.task-list').each(function(e){
			$('.elementor-tab-title a span',$(this)).remove();
			$('<span> ('+ $('.elementor-tab-content .task-item',$(this)).length +') </span>').appendTo($('.elementor-tab-title a',$(this)));
		});
	}

	$.date = function(dateObject) {
	    var d = new Date(dateObject);
	    var day = d.getDate();
	    var month = d.getMonth() + 1;
	    var year = d.getFullYear();
	    if (day < 10) {
	        day = "0" + day;
	    }
	    if (month < 10) {
	        month = "0" + month;
	    }
	    var date = year + "-" + month + "-" + day;

	    return date;
	};

	$.date = function(dateObject) {
	    var d = new Date(dateObject);
	    var day = d.getDate();
	    var month = d.getMonth() + 1;
	    var year = d.getFullYear();
	    if (day < 10) {
	        day = "0" + day;
	    }
	    if (month < 10) {
	        month = "0" + month;
	    }
	    var date = year + "-" + month + "-" + day;

	    return date;
	};	

	const addOneDayToDate = (date) => {
	  date.setDate(date.getDate() + 1)
	  
	  return date
	}

	const deductOneDayToDate = (date) => {
	  date.setDate(date.getDate() - 1)
	  
	  return date
	}

})(jQuery);