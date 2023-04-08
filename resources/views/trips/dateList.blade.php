@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | {{ __('message.calendar') }}
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
      <h5 class="mb-0 text-nowrap py-2 py-xl-0 mb-3">{{ __('message.calendar') }}: {{base64_decode($date)}}</h5>
			<div class="row g-3 mb-3">
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Total Classes</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$schedules['total']}}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Total Students</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$schedules['students']}}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Total Teachers</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{ $schedules['total'] }}</div>
              </div>
            </div>
          </div>
        </div>
  
				<div class="col-md-12 col-xxl-12">
          <div class="card mb-3" id="studentsTable" data-list='{"valueNames":["studentname","schoolcode","tripdate","gender","cabin","eaglepoint"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
            <div class="card-body p-0">
              <div class="row">
                <div class="col-8 col-sm-8 pe-0">
                  <h5 class="mb-0 text-nowrap p-3 border-bottom mb-3">{{ __('message.trips') }}</h5>
                  @if($schedules['list'])
                    @foreach($schedules['list'] as $skey => $schedule)
                      <div class="mb-3 {{ ($schedules['total']-1) !== $skey ? 'border-bottom' : ''}}">
                        <div class="row flex-between-center mb-0 px-3">
                          <div class="col-sm-9 pe-0">
                            <h4 class="mb-2 fs-0 fw-semi-bold">{{ ucfirst(strtolower($schedule->type)) }} Trip: {{ $schedule->school->name }}</h4>
                          </div>
                          <div class="col-sm-auto text-end ps-2">
                            <button class="btn btn-outline-success btn-sm" type="button" onclick='editTripList({{$schedule->id}})' >Edit</button>
                          </div>
                        </div>
                        <div class="fs--1 mb-2 px-3">
                          <p class="mb-0">Teacher: {{ $schedule->teacher }}</p>
                          <p class="mb-0">Students: {{ $schedule->students }}</p>
                          <span class="badge {{ $schedule->status === 'CONFIRMED' ? 'badge-soft-scicon' : 'badge-soft-info' }} rounded-pill fs--2 fw-normal">{{ ucfirst(strtolower($schedule->status)) }}</span>
                        </div>
                        @if(count($schedule->studentInfo) > 0)
                          <a class="fs--1 text-500 px-3" data-bs-toggle="collapse" href="#students_{{$schedule->id}}" role="button" aria-expanded="false" aria-controls="students_{{$schedule->id}}"><small>STUDENTS</small></a>
                          <div class="collapse show div-striped" id="students_{{$schedule->id}}">
                            @foreach($schedule->studentInfo as $sKey => $student)
                            <p class="mb-0 p-1 ps-3 fs--1 text-scicon">{{$student->student_name}}</p>
                            @endforeach
                          </div>
                        @endif
                      </div>
                    @endforeach
                  @endif
                </div>
                <div class="col-4 col-sm-4 ps-2">
                  <div id="daySingleCalendar"></div>
                  <div>
                    <h4 class="mt-3 mb-2 fs-0 fw-semi-bold">Trips on this day</h4>
                    @if($schedules['list'])
                      <ol class="fs--1 text-black">
                        @foreach($schedules['list'] as $schedule)
                          <li>{{$schedule->school->name.': '.$schedule->students}}</li>
                        @endforeach
                      </ol>
                    @endif
                    <a href="javascript://" class="btn btn-info btn-sm fs--2 w-auto mb-3" type="button" >Pre-Schedule trip</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
				</div>
			</div>			
		</div>
	</div>
</main>
@include('trips.modals.tripDetailPendingModal')
@endsection

@push('styles')
<style type="text/css">
  #daySingleCalendar{
    width: 290px;
  }
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
  /*.fc-multimonth-month{
    width: 90% !important;
  }*/
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

  #daySingleCalendar .fc-daygrid-day-frame.fc-scrollgrid-sync-inner{
    display: flex;
    padding-top: 0px !important;
    justify-content: center;
  }
  #daySingleCalendar .fc .fc-daygrid-day-top{
    flex-direction: column-reverse !important;
    margin-bottom:  0rem !important;
  }

  #daySingleCalendar th.fc-col-header-cell.fc-day{
    text-transform: uppercase;
  }

  #daySingleCalendar .fc-multimonth-title{
    color: #276b64 !important;
    font-weight: 600 !important;
    border-bottom: 1px solid #d8e2ef !important;
    margin-bottom: 1rem !important;
  }
  #daySingleCalendar .fc-multimonth-header-table {
    font-size: .8333333333rem !important;
    color: #000 !important;
  }

  #daySingleCalendar .fc .fc-daygrid-day-number{
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

  #daySingleCalendar .fc-daygrid-more-link.fc-more-link
  {
    border: transparent !important;
    padding: 0.5rem !important;
    font-weight: 400 !important;
    color: transparent !important;
    margin: 0px;
  }

  #daySingleCalendar .fc-daygrid-day-events .fc-event-title.fc-sticky{
    color: transparent !important;
    padding: 0px !important;
  }

  .fc .fc-daygrid-day-bottom {
    margin: 0px 1px !important;
  }

  #daySingleCalendar .fc-daygrid-day-events .fc-event.fc-daygrid-event{
    padding: 0.5rem !important;
  }
</style>
@endpush

@push('scripts')
<script type="text/javascript">
  function editTripList(scheduleId){
    tripView = 'view';
    $(".loading").show();
    $.ajax({
      url: "{{ route('schedule.trip.show',':id') }}".replace(':id',scheduleId),
      method: "get",
      'beforeSend': function (request) {
        var token = $('meta[name=csrf-token]').attr("content");
        request.setRequestHeader("X-CSRF-TOKEN", token);
      },
      success: function (res) {
        $(".loading").hide();
        showModal(res.data)
        $(".tripPending, .tripConfirm").addClass('d-none');
        $(".tripEdit").removeClass('d-none');

        $("#tripDetailConfirm, #confirmTrip").addClass('d-none');
        $('#tripDetailModal').modal('show');
      }
    });
  }

  function showModal(data){
    tripdata = data;
    $(".scheduleId").val(data.id);
    $("#tripDate").html(data.trip_date);
    $(".schoolName").html(data.school.name);
    $(".statusLabel").html(data.status);
    $(".teacherLabel").html(data.teacher);
    $(".studentNo").html(data.students);
    $("#status").val(data.status.toUpperCase());
    $("#preferredDate").val(data.trip_date);
    $("#teacher").val(data.teacher);
    $("#studentsEdit").val(data.students);

    if(data.type == 'DAY') {
      $(".billLatterDiv").addClass('d-none');
    } else {
      $(".billLatterDiv").removeClass('d-none');
    }

    $(".removeTripBtn, .tripDetailBill").attr("data-id", data.id);
    $('#tripDetailModal').modal('show');
  }

  function saveTrip(){
    if($('#tripDetailEdit').valid()){
        swal.fire({
          title: "{{__('actions.areYouSureWantSave')}}",
          text: "",
          icon:'warning',
          type:"warning",
          showCancelButton:!0,
          confirmButtonText:"{{__('actions.saveButton')}}"
        }).then(function (e) {
          if (e.value) {
            $(".loading").show();
            $.ajax({
              url: "{{ route('schedule.trip.update') }}",
              method: "post",
              'beforeSend': function (request) {
                var token = $('meta[name=csrf-token]').attr("content");
                request.setRequestHeader("X-CSRF-TOKEN", token);
              },
              data: $("#tripDetailEdit").serialize(),
              success: function (res) {
                swal.fire(
                  res.status == true ? "{{__('actions.saved')}}" : "{{__('actions.notSaved')}}",
                  res.message,
                  res.status == true ? 'success' : 'error'
                );

                $(".loading").hide();
                if(res.status == true){
                  location.reload();
                }
              }
            });
          }
        });
    }
  }
</script>
<script src="{{ asset('assets/js/fullcalendar/index.global.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var daySingleCalendarEl = document.getElementById('daySingleCalendar');
    var daySingleCalendar = new FullCalendar.Calendar(daySingleCalendarEl, {
      //handleWindowResize: true,
      height: 380,
      aspectRatio: 2,
      expandRows: false,
      initialView: 'multiMonthTwoMonth',
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
        multiMonthTwoMonth: {
          type: 'multiMonth',
          duration: { months: 1 },
          //hiddenDays: [0,6 ],
          multiMonthTitleFormat: { year: 'numeric', month: 'long' },
          dayPopoverFormat : { month: 'numeric', day: 'numeric', year: 'numeric', }
        }
      },
      //eventLimit: 2,
      firstDay: 1,
      events: "{{ route('schedule.trip.list') }}",
    });

    daySingleCalendar.render();
  });
</script>
@endpush