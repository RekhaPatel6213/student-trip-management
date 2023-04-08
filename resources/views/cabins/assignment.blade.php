@php
  $borderColors = ['#E77575', '#C5C5C5', '#45D4E8', '#000E89', '#E7EB44', '#D300D8', '#EE8F00', '#000000', '#D1FF71'];
  $schedulesColor = [];
  $cabins = $assignmentInfo['allCabins'];
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | {{ __('message.assignments').': '. __('message.cabins')}}
@endsection

@section('content')
<main class="main" id="top">
  <div class="container" data-layout="container">
    <div class="content">
      <div class="row flex-between-center mb-3">
        <div class="col-sm-5 pe-0">
          <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ __('message.assignments').': '. __('message.cabins')}}</h5>
        </div>
        <div class="col-sm-auto text-end ps-2 d-flex align-items-center">
          <button class="btn btn-sm me-1" type="button" title="Previous" onclick="previousBtn()"><span class="fas fa-arrow-left"></span></button>
          <select name="week" id="week" class="form-select form-select-sm fs--2">
            @if($weeks)
              @foreach($weeks as $weekNumber => $weekDates)
                <option value="{{ $weekNumber }}" {{ ($cutrrentWeek ?? '') == $weekNumber ? "selected" : "" }}>{{ $weekDates['start'].' - '.$weekDates['end'] }} </option>
              @endforeach
            @endif
          </select>
          <button class="btn btn-sm ms-1" type="button" title="Next" onclick="nextBtn()"><span class="fas fa-arrow-right"> </span></button>
        </div>
      </div>
      <div class="row g-3 mb-3">
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Total students this week</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$assignmentInfo['studentCount']}}</div> 
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Not assisgned to cabins</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{($assignmentInfo['notAssignStudent'])}}</div> 
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Assigned to cabins</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$assignmentInfo['assignStudent']}}</div> 
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Registered classes</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$assignmentInfo['scheduleCount']}}</div> 
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12 col-xxl-12">
          <div class="card mb-3">
            <div class="card-body p-0">
              <div class="tab-content">
                <div class="row m-0 border-bottom">
                  <div class="col-sm-3 border-end py-3">
                    <h5 class="fs--1 fw-semi-bold mb-2">Not assigned: {{$assignmentInfo['notAssignStudent']}}</h5>
                    <button type="button" class="btn btn-info btn-sm fs--2 w-auto" onclick="autoSortStudent()" {{$assignmentInfo['notAssignStudent'] === 0 ? 'disabled' : ''}} >Autosort Students</button>
                  </div>
                  <div class="col-sm-9 py-3">
                    <h5 class="fs--1 fw-semi-bold mb-2">Cabin assignments: {{($assignmentInfo['assignStudent'])}}</h5>
                    <div class="row flex-between-center mb-0">
                      <div class="col-sm-9 pe-0">
                        <button type="button" class="btn btn-secondary btn-sm fs--2 w-auto" onclick="expandAll()" {{$assignmentInfo['assignStudent'] === 0 ? 'disabled' : ''}}>Expand All</button>
                      </div>
                      <div class="col-sm-auto text-end ps-2">
                        <button type="button" class="btn btn-primary btn-sm fs--2 w-auto px-4" onclick="print()" {{$assignmentInfo['assignStudent'] === 0 ? 'disabled' : ''}} >Print</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row m-0 border-bottom">
                  <div class="col-sm-3 p-0 border-end">
                    <div class="accordion" id="scheduleClassList">
                      @if($assignmentInfo['scheduleCount'] > 0)
                        @foreach($assignmentInfo['schedules'] as $sKey => $schedule)
                          @php $schedulesColor[$schedule->id] = $borderColors[$sKey]; @endphp
                          <div class="accordion-item" style='border-left-color:{{ $borderColors[$sKey] }} !important;'>
                            <h2 class="accordion-header" id="heading{{$sKey}}">
                              <button class="accordion-button fs--2 fw-semi-bold mb-0 p-2 ms-2 text-black w-auto collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$sKey}}" aria-expanded="true" aria-controls="collapse{{$sKey}}">{{ $schedule->school->name}}: {{ $schedule->studentInfo->whereNotNull('cabin_id')->count() }}/{{ count($schedule->studentInfo)}}</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse{{$sKey}}" aria-labelledby="heading{{$sKey}}" data-bs-parent="#scheduleClassList">
                              <div class="accordion-body py-0 pb-2 fs--2 text-black">
                                <p class="mb-2">Teacher: {{ $schedule->teacher}}</p>
                                <div class="w-75">
                                  @if(count($schedule->studentInfo) > 0)
                                    @foreach($schedule->studentInfo as $student)
                                      <span class="badge badge-soft-secondary fs--2 w-100 fw-normal text-start text-black mb-2" style='border-left-color:{{ $borderColors[$sKey] }} !important;'>{{$student->student_name}}</span><br>
                                    @endforeach
                                  @endif
                                  <a href="javascript://" onclick='addStudent({{$schedule->id}}, "{{$schedule->status}}")' class="fs--2 text-black"> + Add Student </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <div class="row mb-4">
                      @if($assignmentInfo['cabins'] > 0)
                        @foreach($assignmentInfo['cabins'] as $gKey => $cabinList)
                        <div class="col-sm-6">
                          <p class="mt-2 text-black">{{ ucfirst($gKey) }}</p>
                          @if(count($cabinList) > 0)
                            <div class="accordion cabinList" id="cabinList{{$gKey}}">
                            @foreach($cabinList as $cKey => $cabin)
                              @php
                                $studentCount = count($cabin->students);
                                $disabledCabin = $cabin->block_week !== null && in_array($cutrrentWeek, $cabin->block_week) ? 'disabled' : '';
                              @endphp
                              <div class="accordion-item mx-0 mb-2 {{$disabledCabin}}" >
                                <h2 class="accordion-header m-1 mb-0" id="heading{{$gKey.'_'.$cKey}}">
                                  <div class="row mx-0">
                                    <div class="col-sm-11 p-0">
                                      <button class="accordion-button fs--2 fw-semi-bold mb-0 p-0 text-black collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$gKey.'_'.$cKey}}" aria-expanded="true" aria-controls="collapse{{$gKey.'_'.$cKey}}" {{ $disabledCabin}}>
                                        <!-- <div class="row"> -->
                                          <div class="col-sm-6 pe-0">
                                            <p class="p-2 fs--2 fw-semi-bold mb-0">{{ $cabin->name }}</p>
                                          </div>
                                          <div class="col-sm-6 fs--2 ps-2 text-end d-flex justify-content-end">
                                            <div class="row me-0 py-1 fs--2 fw-medium mb-0 align-items-center w-100">
                                              <div class="col-sm-6 p-0 pe-0">
                                                @if( in_array($cabin->id, $assignmentInfo['cabinIds']) && $studentCount > 0)
                                                  @foreach($cabin->students as $student)
                                                    <a href="javascript://" class="studentDetails" data-student-id="{{$student->id}}" data-colorCode="{{ $schedulesColor[$student->schedule_id] }}">
                                                      <span class="dot me-0" style="background:{{ $schedulesColor[$student->schedule_id] }} !important;"></span>
                                                    </a>
                                                  @endforeach
                                                @endif
                                              </div>
                                              <div class="col-sm fs--1 text-end p-0 pe-2">{{$studentCount}}/{{$cabin->eligible_student}}</div>
                                            </div>
                                          </div>
                                        <!-- </div> -->
                                      </button>
                                    </div>
                                    <div class="col-sm-1 p-0">
                                      <div class="dropdown font-sans-serif position-static d-flex">
                                        <a class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal px-2 mt-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" {{ $disabledCabin}}><span class="fas fa-ellipsis-v fs--1"></span></a>
                                        <div class="dropdown-menu dropdown-menu-end border py-0">
                                          <div class="bg-white fs--2 py-2">
                                            <a class="dropdown-item" href="javascript://" onclick="blockCabin({{$cabin->id}}, {{$studentCount}} )">Block For Week</a>
                                            <a class="dropdown-item" href="{{ route('cabins.edit', $cabin->id) }}" target="_blank">View/Edit</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </h2>
                                <div class="accordion-collapse collapse show" id="collapse{{$gKey.'_'.$cKey}}" aria-labelledby="heading{{$gKey.'_'.$cKey}}">
                                  <div class="accordion-body py-0 pb-2 fs--2 text-black">
                                    <div class="row" data-cabin-id="{{$cabin->id}}" data-type="{{$gKey}}" data-disability="{{$cabin->is_disability}}">
                                      @if( in_array($cabin->id, $assignmentInfo['cabinIds']) && $studentCount > 0)
                                        <div class="col-sm-6">
                                          @foreach($cabin->students as $csKey => $student)
                                          <a href="javascript://" class="studentDetails" data-student-id="{{$student->id}}" data-colorCode="{{ $schedulesColor[$student->schedule_id] }}">
                                            <span class="align-items-center badge badge-soft-secondary d-flex fs--2 fw-normal mb-2 position-relative text-black text-start w-100 studentBadge" data-cabin-id="{{$cabin->id}}" style="border-left-color:{{ $schedulesColor[$student->schedule_id] }} !important;" data-student-id="{{$student->id}}" data-type="{{$gKey}}" data-disability="{{$student->is_disability}}">
                                              {{ $student->student_name}}

                                              @if($student->teacher_cabin_id !== null)
                                              <div class="bg-light icon-item position-absolute rounded-3 shadow-none studentBadgeChild">
                                                {{$student->teacher_cabin_id}}
                                              </div>
                                              @endif

                                              @if($student->is_disability === 'YES')
                                              <div class="bg-light icon-item position-absolute rounded-3 shadow-none studentBadgeChild">
                                                <span class="fas fab fa-accessible-icon m-1 fs-1 text-scicon"></span>
                                              </div>
                                              @endif
                                            </span>
                                          </a>
                                            @if($csKey == round(($studentCount/2)-1))
                                              </div><div class="col-sm-6">
                                            @endif
                                          @endforeach
                                        </div>
                                      @else
                                      <div class="col-sm-6" style="height: 35px;"></div>
                                      @endif 
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                            </div>
                          @endif
                        </div>
                        @endforeach
                      @endif
                    </div>
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
  @include('cabins.modals.studentInfo')
  @include('cabins.modals.studentDetail')
  @include('cabins.modals.studentUpdate')
  @include('cabins.modals.droppableModals')
@endsection

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style type="text/css">
  #scheduleClassList .accordion-item {
    border-left: 10px solid !important;
  }
  #scheduleClassList .accordion-item:first-of-type{
    border-radius: 0px !important;
    border-top: 0px !important;
  }
  #scheduleClassList .accordion-item:last-of-type{
    border-radius: 0px !important;
    /*border-bottom: 0px !important;*/
  }
  #scheduleClassList .accordion-item {
    border-right: 0px !important;
  }
  #scheduleClassList .accordion-button, .accordion-button:focus{
    box-shadow: unset !important;
    border-color: transparent !important;
    border-top-left-radius: unset !important;
    border-top-right-radius: unset !important;
  }
  #scheduleClassList .accordion-button::after, .cabinList .accordion-button::after, .dropdown-toggle::after{
    background-image: unset !important;
    content: unset !important;
  }
  #scheduleClassList .accordion-collapse .badge{
    border-left: 10px solid !important;
  }

  .cabinList .accordion-item:not(:first-of-type) {
      border-top: 1px solid #00000020;
  }
  .cabinList .accordion-item {
    border-radius: 10px !important;
  }
  .cabinList .accordion-item:first-of-type, .cabinList .accordion-item:last-of-type {
    border-radius: 10px !important;
  }
  .cabinList .accordion-collapse .badge{
    border-left: 10px solid !important;
  }

  .cabinList .accordion-button, .accordion-button:focus{
    box-shadow: unset !important;
    border-color: transparent !important;
  }

  .cabinList .accordion-item.disabled{
    opacity: 0.3;
  }

  .studentBadge{
    border-left-color: #C5C5C5 !important;
    min-height: 26px
  }
  .studentBadgeChild{
    right: 2px;
    top: 50%;
    width: 22px;
    height: 22px;
    transform: translateY(-50%);
  }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript"> 

  var studentId;
  var studentType;
  var studentDisability;
  var cabinId;
  var cabinType;
  var cabinDisability;
  var draggableUi;
  var currentData;

  $( function() {
    //$(".badge-soft-secondary").draggable();
    $(".badge-soft-secondary" ).draggable({
      revert: "valid",
      drag: function (event, ui) {   
      }
    }); 

    $(".accordion-item .accordion-body .row .col-sm-6").droppable({
      drop: function (event, ui) {
        draggableUi = ui;
        currentData = $(this);
        studentId = $(ui.draggable).attr('data-student-id');
        studentType = $(ui.draggable).attr('data-type');
        studentDisability = $(ui.draggable).attr('data-disability');
        cabinId = $(this).parent().attr("data-cabin-id");
        cabinType = $(this).parent().attr("data-type");
        cabinDisability = $(this).parent().attr('data-disability');

        if(studentDisability == 'YES' && studentDisability != cabinDisability){
          $("#assignmentConfictModal").modal('show');
        } else if(studentType != cabinType){
          if(studentType === 'girls'){
            $(".maleStudent").addClass('d-none');
            $(".femaleStudent").removeClass('d-none');
          } else {
            $(".femaleStudent").addClass('d-none');
            $(".maleStudent").removeClass('d-none');
          }
          $("#genderConfictModal").modal('show');
        } else {
          var content = ui.draggable.next();
          ui.draggable.draggable('disable').appendTo(this);
          content.appendTo(this);
          updateCabinAjax(studentId, cabinId, 'normal', '');
        }
      }
    });
  });

  var colorCode;
  var studentDetail;
  var currentUrl = "{{ route('assignment.cabins', ':week') }}";
  function previousBtn(){
    var week = getWeekNumber($("#week").val(), 'previous');
    $(location).prop('href', currentUrl.replace(/:week/, week));
  }

  function nextBtn(){
    var week =getWeekNumber($("#week").val(), 'next');
    $(location).prop('href', currentUrl.replace(/:week/, week));
  }

  function getWeekNumber(weekNumberString, type){
    weekNumberString = weekNumberString.split('#');
    var weekNumber = weekNumberString[0];
    if(weekNumber == 52 && type == 'next'){
      weekNumber = 1;
    } else if(weekNumber == 1 && type == 'previous'){
      weekNumber = 52;
    } else {
        if(type == 'next'){
          weekNumber++;
        } else {
          weekNumber--;
        }
    }
    weekNumberString = weekNumber+'#'+weekNumberString[1];
    return btoa(weekNumberString);
  }

  $(document).on('change', '#week', function () {
    var week = $(this).val();
    $(location).prop('href', currentUrl.replace(/:week/, btoa(week)));
  });

  function autoSortStudent(){
    $(".loading").show();
    $.ajax({
      url: "{{ route('assignment.cabin.autosort') }}",
      method: "post",
      'beforeSend': function (request) {
        var token = $('meta[name=csrf-token]').attr("content");
        request.setRequestHeader("X-CSRF-TOKEN", token);
      },
      data: { 
        week: $("#week :selected").val(),
        dates: $("#week :selected").text(),
      },
      success: function (res) {
        swal.fire(
          res.status == true ? "{{__('actions.autosortCabinDone')}}" : "{{__('actions.autosortCabinNotDone')}}",
          res.message,
          res.status == true ? 'success' : 'error'
        );

        $(".loading").hide();
        if(res.status == true){
          location.reload();
        }
      },
      error: function (jqXHR, exception) {
        $(".loading").hide();
      }
    });
  }

  function expandAll(){
    if($('.cabinList').find('.accordion-collapse.collapse').hasClass('show')){
      $('.cabinList').find('.accordion-collapse.collapse').removeClass('show');
    } else {
      $('.cabinList').find('.accordion-collapse.collapse').addClass('show');
    }
  }
  function print(){}

  function blockCabin(cabinId, $studentCount){
    if($studentCount == 0){
      swal.fire({
        title: "{{__('actions.areYouSureWantBlock')}}",
        text: "",
        icon:'warning',
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"{{__('actions.blockButton')}}"
      }).then(function (e) {
        if (e.value) {
          $(".loading").show();
          $.ajax({
            url: "{{ route('assignment.cabin.block') }}",
            method: "post",
            'beforeSend': function (request) {
              var token = $('meta[name=csrf-token]').attr("content");
              request.setRequestHeader("X-CSRF-TOKEN", token);
            },
            data: { 
              cabinId: cabinId,
              blockWeek: $("#week :selected").val(),
            },
            success: function (res) {
              swal.fire(
                res.status == true ? "{{__('actions.blocked')}}" : "{{__('actions.notBlocked')}}",
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
    } else {
      swal.fire(
        'Warning',
        'Can\'t block this cabin because students was assigned.',
        'warning'
      );
    }
  }

  function addStudent(scheduleId, scheduleStatus){
    $("#studentInfoModal #scheduleId").val(scheduleId);
    $("#studentInfoModal #scheduleStatus").val(scheduleStatus);
    $("#studentInfoModal").modal('show');
  }

  $(document).on('click', '.studentDetails', function () {
    var studentId = $(this).attr('data-student-id');
    colorCode = $(this).attr('data-colorCode');
    getDetails(studentId, "{{ route('cabin.student.detail',':id') }}");
  });

  function showModal(data){
    var modalId  = 'studentDetailModal';
    studentDetail = data;

    $("#"+modalId+" .studentName").html(data.student_name);
    $("#"+modalId+" .schoolName").html(data.schedule.school.name);
    $("#"+modalId+" .teacherName").html(data.schedule.teacher);  
    $("#"+modalId+" .studentSex").html(data.gender == 'MALE' ? 'M' : 'F');
    $("#"+modalId+" .studentCabin").html(data.teacher_cabin_id??'-');
    $("#"+modalId+" .studentNotes").html(data.note??'-');
    $("#"+modalId+" .studentBorder").css( {borderLeft: '10px solid '+colorCode})

    var svgimg = $("#"+modalId+" .studentDisability");
    var svgimgClassArray =  svgimg.attr("class").split(' ');
    if(data.is_disability == 'NO' && $.inArray('text-scicon', svgimgClassArray) != -1){
      var svgimgClass = svgimg.attr("class").replace('text-scicon', 'text-scicon d-none');
    } else if(data.is_disability == 'YES' && $.inArray('text-scicon', svgimgClassArray) != -1){
      var svgimgClass = svgimg.attr("class").replace('d-none', '');
    }
    svgimg.attr("class", svgimgClass);

    $("#"+modalId).modal('show');
  };

  function editStudentDetail()
  {
    $("#studentDetailModal").modal('hide');
    showStudentDetail(studentDetail, true);
  }

  function removeStudent(){
    var studentId = studentDetail.id;
    deleteRecords("{{ route('schedule.student.delete') }}", [studentId], "Student");
    $("#studentDetailModal").modal('hide');
    $('.studentDetails[data-student-id="'+studentId+'"]').remove();
  }
</script>

<script src="{{ asset('assets/js/scicon/studentInfo.js') }}"></script>
@endpush