<style>
    .fc-direction-ltr .fc-daygrid-event.fc-event-end, .fc-direction-rtl .fc-daygrid-event.fc-event-start {
    margin-right: 2px;
    text-align: justify;
    white-space: pre-wrap;
    }
</style>
<!-- Delivery Transaction Tab -->
<div class="p-3">
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Delivery Date
        </h4>
        <div class="d-flex">
        </div>
    </div>
    
    
    <div class="admin-card">
    <button id="viewCalender" class="btn btn-primary btn-sm" title="Click to view calender">View Calender</button>
    <div id='calendar' class="px-3 py-4"></div>

<div class="modal fade" id="calander_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Add</h5>
             <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
         </div>
         <div class="modal-body">
             <form id="calander_form">
                 @csrf
                 <div class="row">
                     <div class="col-md-12">
                         <div class="form-group">
                             <label for="">Date</label>
                             <input type="date" name="date_time" class="form-control" id="calander_date" readonly>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="form-group">
                             <label for="">Limit</label>
                             <input type="text" name="limit" class="form-control" id="calander_remark">
                         </div>
                     </div>
                 </div>
             </form>
         </div>
         <div class="modal-footer">
             <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
             <a name="remove_status_btn_Info" class="btn btn-danger" id="remove_calender_event_btn">Remove</a>
             <a name="change_status_btn_Info" class="btn btn-primary" id="calender_form_btn">Save</a>
         </div>
     </div>
 </div>
</div>
</div>
    </div>
   

<button type="button" id="openmodel" class="btn btn-primary" data-toggle="modal" data-target="#calander_modal" style="display: none;">
    Launch demo modal
</button>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    document
    $('#viewCalender').on('click', function(){
        // calendar.render();
        updateTable();

    });
    // Add
    $(document).on('click', '#calender_form_btn', function() {

        let form = $('#calander_form')[0];
        let data = new FormData(form);
        var btnText = $('#calender_form_btn').text();
        data.append('service_management_id', "{{ request()->id }}")
        $.ajax({
            url: "{{route('SA-storedeliveryDate')}}",
            data: data,
            type: 'post',
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#calender_form_btn').html('loading...');
            },
            success: function(data) {
                $('#calander_form :input').prop('disabled', false);
                $('#calender_form_btn').html(btnText);
                $('#calander_form')["0"].reset();
                toastr.success(data.success);
                updateTable();
                $('#calander_modal .close').click();
            },
        })
    })


var calendar; 
    function updateTable() {
        var calendarEl = document.getElementById('calendar');
         calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            contentHeight: "auto",

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            dateClick: function(calEvent, jsEvent, view) {
                store_calendar_data(calEvent);
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: "{{route('SA-getDeliverDate')}}",
                    dataType: 'json',
                    success: function(doc, cell) {
                        console.log(doc);
                        var events = [];
                        doc.data.forEach(data => {
                            events.push({
                                title: 'Limit : '+data.limit,
                                start: data.date_time,
                                rendering: 'background',
                            });
                        });
                        doc.new_data.forEach(data => {
                            events.push({
                                title: 'Total Order: '+data.count,
                                // start: data.delivery_date,
                                start: data.delivery_date.split('/').reverse().toString().replaceAll(',', '-'),
                                rendering: 'background',
                            });
                        });
                        successCallback(events);
                        $('.fc-daygrid-event-harness').parent().parent().parent().css({
                            backgroundColor: "#fce29a"
                        });


                    }
                });
            }
        });

        calendar.render();
    }
    // document.addEventListener('DOMContentLoaded', function() {
    // $(document).ready(function(){
        
    //     var calendarEl = document.getElementById('calendar');
    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth',
    //         selectable: true,
    //         contentHeight: "auto",

    //         headerToolbar: {
    //             left: 'prev,next today',
    //             center: 'title',
    //             right: 'dayGridMonth'
    //         },
    //         dateClick: function(calEvent, jsEvent, view) {

    //             store_calendar_data(calEvent);

    //         },
    //         events: function(fetchInfo, successCallback, failureCallback) {
    //             $.ajax({
    //                 url: "{{route('SA-getDeliverDate')}}",
    //                 dataType: 'json',
    //                 success: function(doc, cell) {

    //                     // console.log(doc);

    //                     var events = [];
    //                     doc.data.forEach(data => {
    //                         events.push({
    //                             title: 'Limit : '+data.limit,
    //                             start: data.date_time,
    //                             rendering: 'background',
    //                         });
    //                     });
    //                     doc.new_data.forEach(data => {
    //                         events.push({
    //                             title: 'Total Order: '+data.count,
    //                             start: data.delivery_date.split('/').reverse().toString().replaceAll(',','-'),
    //                             rendering: 'background',
    //                         });
    //                     });
    //                     successCallback(events);
    //                     $('.fc-daygrid-event-harness').parent().parent().parent().css({
    //                         backgroundColor: "#fce29a"
    //                     });
    //                 }
    //             });
    //         }
    //     });
    //     calendar.render();
    // });



    function store_calendar_data(info) {
        $('#openmodel').click();

        // console.log(info);

        $('#calander_date').val(info.dateStr);
        let remark = info.dayEl.innerText;
        if (info.dayEl.innerText.indexOf('\n', 0) > 0) {
            $('#calander_remark').val();
            $('#remove_calender_event_btn').show();
            $('#calender_form_btn').html('Update');
        } else {
            $('#calander_remark').val('');
            $('#remove_calender_event_btn').hide();
            $('#calender_form_btn').html('Save');
        }
    }
    $("#calendar").fullCalendar("removeEvents", event._id);

</script>