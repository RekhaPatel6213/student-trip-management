@extends('layouts.admin')
@section('title')
    {{ config('app.name') }} | Schedule Calendar
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
		            <div class="card mb-3" id="studentsTable" data-list='{"valueNames":["studentname","schoolcode","tripdate","gender","cabin","eaglepoint"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
		              	<div class="card-header border-bottom">
			                <div class="row flex-between-center">
			                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
			                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">Calendar</h5>
			                  </div>
			                  <div class="col"></div>
			                </div>
		              	</div>
		              	<div class="card-body">
							<div class="row flex-between-center mb-3">
								<div class="col-6 col-sm-6 pe-0">
									<div class="alert alert-success border-2 d-flex align-items-center p-2 mb-0" role="alert">
									<div class="me-3">
										<img src="{{ asset('assets/img/icons/vector-group.png') }}" alt="" style="width: 28px;">
									</div>
									<p class="mb-0 flex-1 fs--1">Please review and confirm pending trips. You can drag and drop them to other days.</p>
									</div>
								</div>
								<div class="col">
									<span class="badge badge-soft-pending me-3">Pending</span>
									<span class="badge badge-soft-registered me-3">Registered</span>
									<span class="badge badge-soft-confirmed">Confirmed</span>
								</div>
							</div>
							<div class="row flex-between-center mb-3">
								<ul class="nav nav-tabs border-0">
									<li class="nav-item">
										<a class="nav-link fs--1 active" href="{{ route('schedule.calendar.view') }}">All trips</a>
									</li>
									<li class="nav-item">
										<a class="nav-link fs--1" href="{{ route('trips.index')}}">Day trips</a>
									</li>
									<li class="nav-item">
										<a class="nav-link fs--1" href="{{ url('trips/week')}}">Week trips</a>
									</li>
								</ul>
							</div>
							<div id="calendar"></div>
		              	</div>
		          </div>
				</div>
			</div>			
		</div>
	</div>
</main>
@endsection

@push('styles')
<style type="text/css">
	#calendar {
	    max-width: 1100px;
	    margin: 0 auto;
	}
  	.fc .fc-daygrid-event{
  		padding: 0px !important;
  		padding-left: 0.25rem !important;
  	}

	.fc .fc-daygrid-more-link {
		color : #276b64 !important;
		font-size: .6944444444rem !important;
	}
	@media (min-width: 768px){
		.fc .fc-daygrid-event {
		    font-size: .6944444444rem !important;
		}
		.fc .fc-daygrid-day-frame {
		    padding: 0rem !important;
		}
	}
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/fullcalendar/index.global.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 1000,
      editable: false,
      selectable: false,
      businessHours: true,
      dayMaxEvents: true, // allow "more" link when too many events
      headerToolbar: {
      	left: 'prev,next',
      	center: 'title',
      	right: 'dayGridMonth,timeGridWeek,timeGridDay'
	  },
      views: {
	    dayGridMonth: {
	      dayHeaderFormat: {
	        weekday: 'long'
	      },
	      hiddenDays: [0,6 ],
	      dayPopoverFormat : { month: 'numeric', day: 'numeric', year: 'numeric', }
	    },
	    timeGridWeek:{
	    	dayHeaderFormat: {
		        weekday: 'long'
		      },
	    	hiddenDays: [0,6 ],
	    	dayPopoverFormat : { month: 'numeric', day: 'numeric', year: 'numeric', }
	    }
	  },
      events: "{{ route('schedule.trip.list',['full']) }}" 
    });

    calendar.render();
  });
</script>
@endpush