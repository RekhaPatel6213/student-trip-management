<div class="row pb-3 mb-3 border-bottom">
	<div class="col-sm-9">
		<div id="weekCalendar"></div>
	</div>
	<div class="col-sm-auto mt-5 text-black fs--1">
		<div class="d-flex align-items-center mb-2">
			<div class="icon-item border rounded-3 shadow-none me-2 text-black">{{$schedules['weekOpenCount']}}</div>
			<div class="flex-1">Open</div>
		</div>
		<div class="d-flex align-items-center mb-2">
			<div class="icon-item border rounded-3 shadow-none me-2 text-black" style="background: rgb(184, 156, 58, 0.5);">{{$schedules['weekPendingCount']}}</div>
			<div class="flex-1">Pending Trips</div>
		</div>
		<div class="d-flex align-items-center mb-2">
			<div class="icon-item border rounded-3 shadow-none me-2 text-black" style="background: rgb(84, 84, 84, 0.5);">{{$schedules['weekConfirmedCount']}}</div>
			<div class="flex-1">Confirmed Trips</div>
		</div>
		<div class="d-flex align-items-center mb-2">
			<div class="icon-item border rounded-3 shadow-none me-2 text-black" style="background: rgb(39, 107, 100, 0.5);">{{$schedules['weekRegisteredCount']}}</div>
			<div class="flex-1">Registered Trips</div>
		</div>
	</div>
</div>

@push('styles')
<style type="text/css">
  .fc-col-resizer {
    display:none;
  }
  .fc .fc-toolbar.fc-header-toolbar
  {
    margin-bottom: 0px !important;
  }

  .fc .fc-button-primary{
    background-color: transparent !important;
    border-color: transparent !important;
    color: #000  !important;
  }
  .fc .fc-button-primary:focus{
    box-shadow: unset !important;
  }
  .fc-multimonth-month{
    width: 48% !important;
  }
  .fc-multimonth-daygrid {
    padding-top: 1rem !important;
  }

  .fc-multiMonthTwoMonth-view, .fc-multiMonthWeekTwoMonth-view{
    border-radius: 1rem;
    display: flex;
    justify-content: space-between;
    padding: 1rem;
  }

  .fc .fc-multimonth-title{
    font-size: 1rem !important;
    padding: 0em 0em 1em 0em !important;
  }

  .fc .fc-col-header-cell-cushion{
    font-size: 12px !important;
  }

  .fc-theme-standard td, .fc-theme-standard th{
    border: none !important;
  }

  #weekCalendar .fc-daygrid-day-frame.fc-scrollgrid-sync-inner{
    display: flex;
    padding-top: 0px !important;
    justify-content: center;
  }
  #weekCalendar .fc .fc-daygrid-day-top{
    flex-direction: column-reverse !important;
    margin-bottom:  0rem !important;
  }

  #weekCalendar th.fc-col-header-cell.fc-day{
    text-transform: uppercase;
  }

  #weekCalendar .fc-multimonth-title{
    color: #276b64 !important;
    font-weight: 600 !important;
    border-bottom: 1px solid #d8e2ef !important;
    margin-bottom: 1rem !important;
  }
  #weekCalendar .fc-multimonth-header-table {
    font-size: .8333333333rem !important;
    color: #000 !important;
  }

  #weekCalendar .fc .fc-daygrid-day-number{
    border-radius: 15% !important;
    background-color:  transparent !important;
  }

  .fc .fc-day-today:not(.fc-popover) .fc-daygrid-day-number {
    background-color: transparent !important;
    color: unset !important;
  }

  .fc .fc-day-disabled{
    background: transparent !important; 
  }

  .fc-day.fc-day-sat, .fc-day.fc-day-sun{
    opacity: 0.2;
  }

  #weekCalendar .fc-daygrid-more-link.fc-more-link
  {
    border: transparent !important;
    padding: 0.5rem !important;
    font-weight: 400 !important;
    color: transparent !important;
    margin: 0px;
  }

  #weekCalendar .fc-daygrid-day-events .fc-event-title.fc-sticky{
    color: transparent !important;
    padding: 0px !important;
  }

  .fc .fc-daygrid-day-bottom {
    margin: 0px 1px !important;
  }

  #weekCalendar .fc-daygrid-day-events .fc-event.fc-daygrid-event{
    padding: 0.5rem !important;
  }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/fullcalendar/index.global.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var weekCalendarEl = document.getElementById('weekCalendar');
    var weekCalendar = new FullCalendar.Calendar(weekCalendarEl, {
      //handleWindowResize: true,
    	height: 380,
    	aspectRatio: 2,
    	expandRows: false,
      initialView: 'multiMonthWeekTwoMonth',
      //defaultDate: moment(),
      editable: false,
      selectable: false,
      businessHours: false,
      showNonCurrentDates: false,
      dayMaxEvents: true, // allow "more" link when too many events
      headerToolbar: {
      	left: 'prev',
      	//center: 'title',
      	right:'next'
	  	},
      views: {
		    multiMonthWeekTwoMonth: {
		      type: 'multiMonth',
		      duration: { months: 2 },
		      //hiddenDays: [0,6 ],
		      multiMonthTitleFormat: { year: 'numeric', month: 'long' },
		      dayPopoverFormat : { month: 'numeric', day: 'numeric', year: 'numeric'}
		    }
		  },
		  firstDay: 1,
      events: "{{ route('schedule.trip.list',['week', base64_encode($village)]) }}",
    });

    weekCalendar.render();
  });
</script>
@endpush