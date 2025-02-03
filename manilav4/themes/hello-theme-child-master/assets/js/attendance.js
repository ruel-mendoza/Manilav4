


(function($){
  $(document).ready(function(){
      //$('#calendarModal').modal();
      //$('#createEventModal').modal();
      $('#calendar').fullCalendar({
          header: {
              left: 'prev,next today',
              center: 'title',
              right: 'month,agendaWeek,agendaDay'
          },
          eventStartEditable: false,
          disableDragging: true,
          disableResizing: true,
          selectable: true,
          selectMirror: true,
          selectHelper: true,
          //header and other values
          select: function(start, end, jsEvent) {
              var endtime = $.fullCalendar.moment(end).format('h:mm');
              var starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');
              var mywhen = starttime + ' - ' + endtime;
              start = moment(start).format();
              end = moment(end).format();
              var now = new Date();
              var old = new Date(start);

              if(old <= now){
                $('#createEventModal #startTime').val(start);
                $('#createEventModal #endTime').val(end);
                $('#createEventModal #when').text(mywhen);
                $('#createEventModal').modal();
              }else{
                $('#createEventModal #startTime').val(start);
                $('#createEventModal #endTime').val(end);
                $('#createEventModal #when').text(mywhen);
                $('#createEventModal').modal();
              }
         },
          events: function(start, end, timezone, callback) {
                  var userid = ($('#team_memberlist').length && $('#team_memberlist').val() != '') ? $('#team_memberlist').val() : user_object.userid;
                  $.ajax({
                        async: false,
                        type : "post",
                        dataType : "json",
                        url : user_object.ajaxurl,
                        data : {action: "get_individual_attendance", u_id : userid, nonce: user_object.nonce},
                        success: function(doc) {
                            var events = [];
                            if(!!doc.data){
                                $.map( doc.data, function( r ) {
                                  var now = new Date();
                                  var old = new Date(r.date);
                                  if(old < now){
                                   var alloweditable = false; 
                                  }else{
                                    var alloweditable = true; 
                                  }
                                  events.push({
                                      id: r.id,
                                      title: r.status,
                                      start: r.date,
                                      //editable: alloweditable,
                                  });
                                });
                            }
                            callback(events);
                        }                        
                  });
                },
          selectConstraint:{    
              start: moment().subtract(3, 'days').format('YYYY-MM-DD'),
              end: '2100-01-01'
          },              
          /*eventConstraint: {
                start: moment().subtract(3, 'days').format('YYYY-MM-DD'),
                end: '2100-01-01' // hard coded goodness unfortunately
          },*/
          editable: true,
          eventLimit: true,
          loading: function (bool) {
              $('#loading').toggle(bool);
          }
      });

      $('#submitButton').on('click', function(e){
         e.preventDefault();
         doSubmit();
      });

      $('#submitUpdate').on('click', function(e){
         e.preventDefault();
         doUpdate();
      });

      $('#team_memberlist').on('change', function(e){
         //e.preventDefault();
          $("#calendar").fullCalendar('refetchEvents');
      });      

      function doSubmit(){
        $("#createEventModal").modal('hide');
         var title = $('#createEventModal #title').val();
         var startTime = $('#createEventModal #startTime').val();
         var endTime = $('#createEventModal #endTime').val();
         var userid = ($('#team_memberlist').length && $('#team_memberlist').val() != '') ? $('#team_memberlist').val() : user_object.userid;

        var daysOfYear = [];
        for (var d = new Date(startTime); d < new Date(endTime); d.setDate(d.getDate() + 1)) {
          $.ajax({
                async: false,
                type : "post",
                dataType : "json",
                url : user_object.ajaxurl,
                data : {action: "guser_capacity_plan", u_id : userid,status: title ,date:moment(d).format(), nonce: user_object.nonce},
                success: function(doc) {
                  $("#calendar").fullCalendar('refetchEvents');        
                }                        
          });
        }
      }      

    });

})(jQuery);