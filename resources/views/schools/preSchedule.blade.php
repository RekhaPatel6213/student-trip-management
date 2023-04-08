@php
  //$date = date('M dS, Y');
  $date = 'May 31st, '.date('Y');
@endphp

@extends('layouts.default')
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
@section('content')
 <div class="container-fluid">
    <div class="row min-vh-100 flex-center g-0">
      <div class="col-lg-11 col-xxl-8 py-3 position-relative">
        <h5 class="mb-3 text-nowrap py-2 py-xl-0">Pre-Schedule Trip to SCICON</h5>
        <div class="card overflow-hidden z-index-1">
          <div class="card-header d-none"></div>
          <div class="card-body p-0">
            <div class="p-3 p-md-4 flex-grow-1">
              <div class="row gx-2 mb-3">

                <div class="mb-3 col-sm-12">
                  <p class="fs-0 fw-bold mb-0" for="instructions">Instructions</p>
                  <p class="fs--1 fw-medium mb-3">Please fill out this form to pre-schedule your {{ str_replace('Trip', '', strtolower($type)) }} trip/s to SCICON. The deadline is {{ $date }}</p>
                  <p class="fs--1 fw-medium mb-3" id="getstucnt"></p>
                </div>
                <form method="POST" action="{{ route('schools.store.preSchedule') }}" name="preScheduleForm" id="preScheduleForm">
                  @csrf

                  <input type="hidden" name="invite_id" value="{{ $invite->id ?? '' }}" id="inviteId">
                  <input type="hidden" name="school_id" value="{{ $school->id ?? '' }}" id="schoolId">
                  <input type="hidden" name="district_id" value="{{ $school->district_id ?? '' }}" id="districtId">
                  <input type="hidden" name="type" value="{{ $type ?? '' }}" id="weekType">
                  <input type="hidden" name="is_eagle_point" value="{{ $isEaglePoint??'' }}" id="isEaglePoint">

                  <div>
                    <h5 class="mb-2 text-nowrap fs--1 fw-bold mb-0 text-scicon">School / Administrator Information</h5>
                    <div class="row mb-4">
                      <div class="col-md-12 col-lg-8">
                        <div class="border rounded-1 h-100 d-flex flex-column justify-content-between p-2 p-md-3">
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="school">School <span class="text-danger">*</span></label>
                              <input name="school" id="school" type="text" class="form-control w-75" autocomplete="off" value="{{ $school->name ?? '' }}" />
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="school">Admin Name <span class="text-danger">*</span></label>
                              <input name="admin_name" id="adminName" type="text" class="form-control w-75" autocomplete="off" value="{{ $school->administrator !== null ? $school->administrator->full_name : '' }}" />
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="school">District <span class="text-danger">*</span></label>
                              <input name="district" id="district" type="text" class="form-control w-75" autocomplete="off" value="{{ $school->district->name ?? '' }}" />
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="school">Phone <span class="text-danger">*</span></label>
                              <input name="phone" id="phone" type="text" class="form-control w-75" autocomplete="off" value="{{ $school->phone ?? '' }}" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col"></div>
                    </div>

                    @include('schools.preScheduleTrip', ['tripId' => 0, 'display' => ''])
                    @include('schools.preScheduleTrip', ['tripId' => 1, 'display' => 'd-none'])
                    @include('schools.preScheduleTrip', ['tripId' => 2, 'display' => 'd-none'])
                    <input type="hidden" value="0" id="tripCount">
                    <!-- <button class="btn btn-primary d-block my-3" type="button" name="button" id="addTripBtn" onclick="addTrip()">Add a Day Trip</button> -->
                  </div>

                  <div class="mb-3 d-flex">
                    <button class="btn btn-primary d-block mt-3" type="submit" name="submit" onclick="submitRequest()">{{ __('message.preSchedule') }}</button>
                    <button class="btn btn-secondary d-block mt-3 ms-3" type="button" >{{ __('message.cancel') }}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script type="text/javascript">
    function getstudntno(tripId, classId){      
     var  getval1 =  $("input[name='students[0][0]']").val();
     var  getval2 =  $("input[name='students[0][1]']").val();
     var  getval3 =  $("input[name='students[0][2]']").val();
      var cntofstudent = parseInt(getval1) +parseInt(getval2) + parseInt(getval3);
      // $('#getstucnt').html('Total head count: '+cntofstudent+'/40');
      if (cntofstudent > 40 || getval1 > 40 || getval2 > 40 || getval3 > 40) {         
          swal({
           title: "You can not add more than 40 students",
          closeOnConfirm: true,
          });          
          $("input[name='students[0][2]']").val('');
      } else {   
         $('#errorMsg').css('display','none');     
      }
    }
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      var weekType = $("#weekType").val();
      $(".preferredDate").flatpickr({
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

      $('#preScheduleForm').validate({
        rules: {
          school: "required",
          admin_name: "required",
          district: "required",
          phone: "required",
          'preferred_date[0]': "required",
          'teacher[0][0]': { required: true, minlength: 3 },
          'students[0][0]': {required: true},
          'teacher[0][1]': { required: true, minlength: 3 },
          'students[0][1]': {required: true},
          'teacher[0][2]': { required: true, minlength: 3 },
          'students[0][2]': {required: true},

          'preferred_date[1]': "required",
          'teacher[1][0]': { required: true, minlength: 3 },
          'students[1][0]': {required: true},
          'teacher[1][1]': { required: true, minlength: 3 },
          'students[1][1]': {required: true},
          'teacher[1][2]': { required: true, minlength: 3 },
          'students[1][2]': {required: true},

          'preferred_date[2]': "required",
          'teacher[2][0]': { required: true, minlength: 3 },
          'students[2][0]': {required: true},
          'teacher[2][1]': { required: true, minlength: 3 },
          'students[2][1]': {required: true},
          'teacher[2][2]': { required: true, minlength: 3 },
          'students[2][2]': {required: true},
        },
        messages: {
          school_id: "{{__('validation.required',['attribute'=>__('message.school')])}}",
          admin_name: "{{__('validation.required',['attribute'=>__('message.adminName')])}}",
          district: "{{__('validation.required',['attribute'=>__('message.district')])}}",
          phone: "{{__('validation.required',['attribute'=>__('message.phone')])}}",
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          error.insertAfter(element).addClass('invalid-feedback');
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {                    
                validator.errorList[0].element.focus();
            }
            $("input.form-control").each(function() {
                if($(this).val() == "" && $(this).val().length < 1) {
                    $(this).addClass('error is-invalid');
                } else {
                    $(this).removeClass('error is-invalid');
                }
            });             
        },

      });
    });

    function addTrip(){
      var tripCount = $("#tripCount").val();
      if(tripCount <= 2){
        tripCount++;
        $("#trip_"+tripCount).removeClass('d-none');
        $("#tripCount").val(tripCount);

        if(tripCount == 2){
          $("#addTripBtn").addClass('d-none');
        }
      }
    }

    function addTripClass(tripId){
      var tripClassCount = $("#tripClassCount_"+tripId).val();
      if(tripClassCount <= 2){
        tripClassCount++;
        $("#tripClass_"+tripId+tripClassCount).removeClass('d-none');
        $("#tripClassCount_"+tripId).val(tripClassCount);

        if(tripClassCount == 2){
          $("#addTripClassBtn_"+tripId).addClass('d-none');
          $("#maxTripClassText_"+tripId).removeClass('d-none');
        }
      }
    }

    function removeTripClass(tripId, classId){
      var tripClassCount = $("#tripClassCount_"+tripId).val();
      if(classId == 1 && $("#tripClass_"+tripId+"2").hasClass('d-none')){
        classId = 1;
      } else {
        classId = 2;
      }

      $("#tripClass_"+tripId+classId).addClass('d-none');
      $("#maxTripClassText_"+tripId).removeClass('d-none');

      tripClassCount--;
      $("#tripClassCount_"+tripId).val(tripClassCount);

      if(tripClassCount < 3){
        $("#addTripClassBtn_"+tripId).removeClass('d-none');
        $("#maxTripClassText_"+tripId).addClass('d-none');
      }
    }

    function submitRequest(){
      if($('#preScheduleForm').valid()){
        $('#preScheduleForm').submit();
      }
    }
  </script>
@endpush