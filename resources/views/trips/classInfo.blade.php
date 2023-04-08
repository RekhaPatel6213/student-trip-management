@php 
  $key = 1;
  $studentCount = count($schedule->studentInfo);
  $boyCount = $schedule->studentInfo->where('gender', 'MALE')->count();
  $girlCount = $schedule->studentInfo->where('gender', 'FEMALE')->count();
  $weekYear = $cutrrentWeek = \Carbon\Carbon::create($schedule->trip_date)->format('W#Y');
  $tripEndDate =  \Carbon\Carbon::create($schedule->trip_date)->addDays($schedule->days - 1)->format(config('constants.DATE_FORMATE'));
  $weekType = 'WEEK';
@endphp
@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | {{ __('message.trip') }} View
@endsection

@section('content')
<main class="main" id="top">
  <div class="container" data-layout="container">
    <div class="content">
      <div class="row flex-between-center mb-0">
        <div class="col-sm-9 pe-0">
          <h5 class="mb-0 text-nowrap py-2 py-xl-0 mb-3">{{ $schedule->school->name}}: {{$schedule->trip_date.' - '.$tripEndDate}}</h5>
        </div>
        <div class="col-sm-auto text-end ps-2">
        </div>
      </div>
      <div class="row g-3 mb-3">
        <div class="col-md-12 col-xxl-12">
          <div class="card mb-3">
            <div class="card-header">
              <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                  <h5 class="mb-0 text-nowrap py-2 py-xl-0">Class Info</h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
                  <button type="button" class="btn btn-sm btn-outline-success"><span class="fas fa-print"></span></button>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="tab-content">
                <form method="POST" name="tracherRegistration_{{$key}}" id="tracherRegistration_{{$key}}" novalidate="" class="tracherRegistration">
                  @csrf
                  <input type="hidden" name="schedule_id" value="{{ $schedule->id ?? '' }}">
                  <input type="hidden" name="all_classes" value="{{ base64_encode($scheduleId) }}">
                  <input type="hidden" id="studentCount_{{$key}}" value="{{ count($schedule->studentInfo) > 0 ? (count($schedule->studentInfo)-1) : 0 }}">
                  <input type="hidden" name="key" id="key" value="{{$key}}">
                  <input type="hidden" name="days" value="{{$schedule->days}}">

                  <div class="fs--1 mb-3 text-black px-3">
                    <div class="row gx-2">
                      <div class="col-3 col-sm-2 fw-semi-bold">Teacher</div>
                      <div class="col">
                        <span>{{ $schedule->teacher }}</span>
                        <input type="text" name="teacher" value="{{ $schedule->teacher }}" class="form-control form-control-sm w-25 editTeacherInput d-none">
                        <button class="btn btn-link p-0 editTeacherBtn" type="button"><span class="text-500 fas fa-pen"></span></button>
                      </div>
                    </div>
                    <div class="row gx-2">
                      <div class="col-3 col-sm-2 fw-semi-bold">No. of students</div>
                      <div class="col" Id="studentCountInfo_{{$key}}">{{ count($schedule->studentInfo) > 0 ? count($schedule->studentInfo) : 1 }} ({{$boyCount}}M, {{$girlCount}}F)</div>
                    </div>
                    <div class="row gx-2">
                      <div class="col-3 col-sm-2 fw-semi-bold">Trip date</div>
                      <div class="col billStatus">
                        <span>{{$schedule->trip_date.' - '.$tripEndDate}}</span>

                        <input name="trip_date" value="{{$schedule->trip_date}}" type="text" class="form-control form-control-sm w-25 editTripDateInput d-none" autocomplete="off" data-day="{{($schedule->days-1)}}"/>
                        <button class="btn btn-link p-0 editTripDateBtn" type="button"><span class="text-500 fas fa-pen"></span></button>
                      </div>
                    </div>
                  </div>
                </form>


                  <div class="table-responsive scrollbar">
                  <table class="table table-striped fs--1 mb-0 overflow-hidden">
                    <thead class="text-600 fs--2">
                      <tr>
                        <th class="pe-1 align-middle white-space-nowrap border-0">Name</th>
                        <th class="pe-1 align-middle white-space-nowrap border-0 text-center">Sex</th>
                        <th class="pe-1 align-middle white-space-nowrap border-0 text-center">Disability</th>
                        <th class="pe-1 align-middle white-space-nowrap border-0">Notes</th>
                        <th class="pe-1 align-middle white-space-nowrap border-0 text-center">Cabin</th>
                        <th class="pe-1 align-middle white-space-nowrap border-0">Meal Provision</th>
                        <th class="text-end no-sort"></th>
                      </tr>
                    </thead>
                    <tbody class="list  fs--1 text-black">
                      @if(count($schedule->studentInfo) > 0)
                        @foreach($schedule->studentInfo as $sKey => $student)

                        <input type="hidden" id="studentInfoJson_{{$student->id}}" value="{{ json_encode($student) }}">
                        <tr class="btn-reveal-trigger" data-id="Student#{{ $student->id }}">
                          <td class="border-0 ">{{ $student->student_name }}</td>
                          <td class="border-0 text-center">{{ $student->gender === 'MALE' ? 'M' : 'F' }}</td>
                          <td class="border-0 text-center">
                            @if($student->is_disability === 'YES')
                              <span class="fas fab fa-accessible-icon mx-2 mt-1 fs-1 text-scicon"></span>
                            @endif
                          </td>
                          <td class="border-0 ">{{ $student->note }}</td>
                          <td class="border-0 text-center">{{ $student->cabin->name??'' }}</td>
                          <td class="border-0 ">
                            {{ $student->free_meal == 'YES' ? $student->free_amount.'% Free' : ($student->paid_meal == 'YES' ? $student->paid_amount.'% Paid' : $student->reduced_amount.'% Reduced')}}
                          </td>
                          <td class="border-0 align-middle white-space-nowrap py-2 text-end">
                            <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="updateStudent({{$student->id}})"><span class="text-500 fas fa-edit"></span></button>

                            <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="removeStudentInfo({{$student->id}})"><span class="text-500 fas fa-trash-alt"></span></button>
                          </td>
                        </tr>
                        @endforeach
                      @else
                        <tr><td colspan="7">No records found.</td></tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
{{--@include('cabins.modals.studentInfoUpdate')--}}
@include('cabins.modals.studentUpdate')
@endsection

@push('styles')
<style type="text/css">
  .form-check-inline{
    /*margin-right: 0.5rem !important;*/
  }
  .form-select.is-invalid:not([multiple]):not([size]){
    padding-left:  0.75rem !important;
  }
</style>
@endpush

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      var weekType = "{{$weekType}}";
      $(".editTripDateInput").flatpickr({
        dateFormat: datePickerFormate,
        minDate: "today",
        disableMobile:true,
        "disable": [
          function(date) {
            if(weekType == 'WEEK') {
              return (date.getDay() === 0 || date.getDay() === 3 || date.getDay() === 4 || date.getDay() === 5 || date.getDay() === 6);
            } else {
              return (date.getDay() === 0 || date.getDay() === 6);
            }
          }
        ]
      });
    });

    function updateStudent(studentId){
      var studentDetail =  jQuery.parseJSON($("#studentInfoJson_"+studentId).val());
      showStudentDetail(studentDetail, false);
    }

    function removeStudentInfo(studentId){
      deleteRecords("{{ route('schedule.student.delete') }}", [studentId], "Student");
    };
  </script>
  <script src="{{ asset('assets/js/scicon/studentInfo.js') }}"></script>
@endpush