@php 
  $key = $key+ 1;
  $studentCount = count($schedule->studentInfo);
  $boyCount = $schedule->studentInfo->where('gender', 'MALE')->count();
  $girlCount = $schedule->studentInfo->where('gender', 'FEMALE')->count();
@endphp
<form method="POST" name="tracherRegistration_{{$key}}" id="tracherRegistration_{{$key}}" novalidate="" class="tracherRegistration">
  @csrf
  <input type="hidden" name="schedule_id" value="{{ $schedule->id ?? '' }}" id="schoolId">
  <input type="hidden" name="all_classes" value="{{ base64_encode($scheduleId) }}">
  <input type="hidden" id="studentCount_{{$key}}" value="{{ count($schedule->studentInfo) > 0 ? (count($schedule->studentInfo)-1) : 0 }}">
  <input type="hidden" name="key" id="key" value="{{$key}}">
  @php $weekYear = \Carbon\Carbon::create($schedule->trip_date)->format('W#Y') @endphp

  <div class="fs--1 mb-3">
      <div class="row gx-2">
        <div class="col-3 col-sm-2 fw-bold">Teacher</div>
        <div class="col">
          <span>{{ $schedule->teacher }}</span>
          <input type="text" name="teacher" value="{{ $schedule->teacher }}" class="form-control form-control-sm w-25 editTeacherInput d-none">
          <button class="btn btn-link p-0 editTeacherBtn" type="button"><span class="text-500 fas fa-pen"></span></button>
        </div>
      </div>
      @if($schedule->send_meal_request === 'YES')
        <div class="row gx-2">
          <div class="col-3 col-sm-2 fw-bold">Meal preferences</div>
          <div class="col">Completed</div>
        </div>
      @endif
      <div class="row gx-2">
        <div class="col-3 col-sm-2 fw-bold">No. of students</div>
        <div class="col" Id="studentCountInfo_{{$key}}">{{ count($schedule->studentInfo) > 0 ? count($schedule->studentInfo) : 1 }} ({{$boyCount}}M, {{$girlCount}}F)</div>
      </div>
      <div class="row gx-2">
        <div class="col-3 col-sm-2 fw-bold">Trip date</div>
        <div class="col billStatus">{{ $schedule->trip_date }} @if($schedule->type === 'WEEK') {{ '- '.\Carbon\Carbon::create($schedule->trip_date)->addDays($schedule->days)->format(config('constants.DATE_FORMATE'))}} @endif</div>
      </div>
  </div>

  <div class="div-striped mb-3">
    <div id="mainDivOfStudent_{{$key}}" class="mainDivOfStudent {{ count($schedule->studentInfo) > 0 ? 'd-none' : '' }}">
      @include('trips.studentDiv',['student' => null, 'key' => $key, 'sKey' => 0, 'weekYear' => $weekYear, 'showDelete' => true])
    </div>
    <div id="divOfStudents_{{$key}}">
      @if(count($schedule->studentInfo) > 0)
        @foreach($schedule->studentInfo as $sKey => $student)
          @include('trips.studentDiv',['student' => $student, 'key' => $key, 'skey' => $sKey, 'weekYear' => $weekYear, 'showDelete' => true])
        @endforeach
      @endif
    </div>
  </div>

  <a class="py-1 fs--1 font-sans-serif addStudentBtn" href="javascript://" data-id="{{$key}}" id="addStudentBtn">+ {{ __('message.addStudent') }}</a>

  <div class="mb-3 d-flex">
    @if($schedule->send_meal_request === 'NO' && $schedule->status === 'CONFIRMED')
      <button class="btn btn-primary d-block mt-3 me-3 ms-0" type="button" onclick="mealRequest({{$key}}, {{ $schedule->id ?? '' }})">{{ __('message.requestMealPreferences') }}</button>
    @endif

    @if($schedule->status === 'CONFIRMED')
      <button class="btn btn-info d-block mt-3" {{ $schedule->send_meal_request === 'YES' &&  $schedule->meal_signature !== null ? '' : 'disabled' }} type="button" onclick="submitRequest({{$key}}, {{ $schedule->id ?? '' }})">{{ __('message.submitInformation') }}</button>
    @endif
  </div>
</form>                                                                                        