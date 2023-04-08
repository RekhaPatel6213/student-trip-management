@extends('layouts.default')

@section('content')
  <div class="container-fluid">
    <div class="row min-vh-100 flex-center g-0">
      <div class="col-lg-11 col-xxl-8 py-3 position-relative">
        <h5 class="mb-3 text-nowrap py-2 py-xl-0">Add Student Details</h5>
        <div class="card overflow-hidden z-index-1">
          <div class="card-body p-0">
            <div class="p-3 p-md-4 flex-grow-1">
              <div class="row gx-2 mb-3">
                <div class="mb-3 col-sm-12">
                  <p class="fs-0 fw-bold mb-0" for="instructions">Instructions</p>
                  <p class="fs--1 fw-medium mb-3">Please add detailed information on the students to confirm the trips.</p>
                </div>
                @if($schedules)
                  <ul class="nav nav-tabs" id="registrationTab" role="tablist">
                    @foreach($schedules as $key => $schedule)
                      <li class="nav-item"><a class="nav-link {{ $key === 0 ? 'active' : ''}}" id="class{{$schedule->id}}-tab" data-bs-toggle="tab" href="#tab-class{{$schedule->id}}" role="tab" aria-controls="tab-class{{$schedule->id}}" aria-selected="{{ $key === 0 ? 'true' : 'false'}}">Class {{$key+1}}</a></li>
                    @endforeach
                  </ul>
                  <div class="tab-content border-x border-bottom p-3" id="registrationTabContent">
                    @foreach($schedules as $key => $schedule)
                      <div class="tab-pane fade {{ $key === 0 ? 'show active' : ''}}" id="tab-class{{$schedule->id}}" role="tabpanel" aria-labelledby="class{{$schedule->id}}-tab">
                        @include('trips.studentInformation',['schedule' => $schedule, 'key' => $key])
                      </div>
                    @endforeach
                  </div>
                @endif 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('trips.modals.requestMealInformation')
@endsection

@push('styles')
<style type="text/css">
  .form-check-inline{
    margin-right: 0.5rem !important;
  }
  .form-select.is-invalid:not([multiple]):not([size]){
    padding-left:  0.75rem !important;
  }
</style>
@endpush

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#tracherRegistration_1').validate({
        rules: {
          'firstname_1[]' : { required: true, minlength: 3 },
          'lastname_1[]' : { required: true, minlength: 3 },
          //'cabin_id_1[]' : { required: true},
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          error.insertAfter(element).addClass('invalid-feedback');
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        },
      });
      $('#tracherRegistration_2').validate({
        rules: {
          'firstname_2[]' : { required: true, minlength: 3 },
          'lastname_2[]' : { required: true, minlength: 3 },
          //'cabin_id_2[]' : { required: true},
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          error.insertAfter(element).addClass('invalid-feedback');
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        },
      });
      $('#tracherRegistration_3').validate({
        rules: {
          'firstname_3[]' : { required: true, minlength: 3 },
          'lastname_3[]' : { required: true, minlength: 3 },
          //'cabin_id_3[]' : { required: true},
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          error.insertAfter(element).addClass('invalid-feedback');
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        },
      });
      $('#mealRequestForm').validate({
        rules: {
          meal_name : { required: true, minlength: 3 },
          meal_email : { required: true, email: true },
          meal_phone : { required: true}
        },
        messages: {
          meal_name: { 
            required: "{{__('validation.required',['attribute'=>__('message.name')])}}",
          },
          meal_email: { 
            required: "{{__('validation.required',['attribute'=>__('message.email')])}}",
          },
          meal_phone: { 
            required: "{{__('validation.required',['attribute'=>__('message.phone')])}}",
          }
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          error.insertAfter(element).addClass('invalid-feedback');
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        }
      });
    })

    //$(".addStudentBtn").click(function () {
    $(document).on('click', '.addStudentBtn', function () {
      var classId = $(this).attr('data-id');
      var count = $("#studentCount_"+classId).val();
      ++count;
      var text = $("#mainDivOfStudent_"+classId).html();
      text = text.replace(/_0/g,'_'+count);
      text = text.replace('[0]','['+count+']');
      text = text.replace('[0]','['+count+']');
      text = text.replace('studentNote', 'studentNote d-none');
      text = text.replace('addNoteBtn d-none', 'addNoteBtn');
      text = text.replace('text-scicon', 'text-scicon-disable');
      text = text.replace('text-scicon-disable-disable', 'text-scicon-disable');
      text = text.replace('value="YES"', 'value="NO"');
      text = text.replace('removeStudent d-none', 'removeStudent');
      text = text.replace(/error is-invalid/g, 'form-control');
      text = text.replace('<label id="firstName_'+classId+'_'+count+'-error" class="error invalid-feedback" for="firstName_'+classId+'_'+count+'">The First Name field is required.</label>','');
      text = text.replace('<label id="lastName_'+classId+'_'+count+'-error" class="error invalid-feedback" for="lastName_'+classId+'_'+count+'">The Last Name field is required.</label>','');
      text = text.replace('<label id="cabinId_'+classId+'_'+count+'-error" class="error invalid-feedback" for="cabinId_'+classId+'_'+count+'">This field is required.</label>','');
      $("#divOfStudents_"+classId).append(text);
      $("#studentCount_"+classId).val(count);

      var boyCount = $('.gender_'+classId+'[value="MALE"]:checked').length;
      var girlCount = $('.gender_'+classId+'[value="FEMALE"]:checked').length;
      $("#studentCountInfo_"+classId).text((count+1)+' ('+boyCount+'M, '+girlCount+'F)');

      var cabinId = 'cabinId_'+classId+'_'+count;
      $('#'+cabinId+' option').prop('disabled', false);
      $('#'+cabinId+' option[data-gender="Female"]').prop('disabled', true);
    });

    $(document).on('click', '.removeStudent', function () {
      var classId = $(this).attr('data-class-id');
      var key = $(this).attr('data-key');
      swal.fire({
        title:'Confirm removal',
        text:'You are about to remove Edward Gembe from this trip. Please confirm this action.',
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:'Remove',
        cancelButtonText:'Keep',
      }).then(function (e) {
        if (e.value) {
          $("#divOfStudents_"+key+" #studentInfo_"+classId).remove();
        }
      });
    });

    function mealRequest(classId, scheduleId){
        if($('#tracherRegistration_'+classId).valid()) {
          $("#scheduleId").val(scheduleId);
          $("#classId").val(classId);
          $("#mealName, #mealEmail, #mealPhone").val('');
          $("#mealRequestModal").modal('show');
        }
    }

    function submitMealRequest() 
    {
      if($('#mealRequestForm').valid()){
        //$("#mealRequestModal").modal('hide');
        $(".loading").show();

        var classId = $("#classId").val();
        var data = $("#tracherRegistration_"+classId).serializeArray();
        //data.push($("#mealRequestForm").serializeArray());
        data.push({name: 'meal_name', value: $("#mealName").val()}, {name: 'meal_email', value: $("#mealEmail").val()}, {name: 'meal_phone', value: $("#mealPhone").val()});
        //console.log(data);

        $.ajax({
          url: "{{ route('schedule.student.store') }}",
          method: "post",
          'beforeSend': function (request) {
            var token = $('meta[name=csrf-token]').attr("content");
            request.setRequestHeader("X-CSRF-TOKEN", token);
          },
          data: data,
          success: function (res) {
            if(res.status == true){
              swal.fire(
                'Sent!',
                'Meal information request has been send',
                'success'
              );
              setTimeout(function() {
                location.reload();
              }, 2500);
            }
            $(".loading").hide();
          }
        });
      }
    }

    function submitRequest(classId, scheduleId) 
    {
      if($('#tracherRegistration_'+classId).valid()) {
        $(".loading").show();
        var data = $("#tracherRegistration_"+classId).serializeArray();
        data.push({name: 'status', value: 'REGISTERED'});

        $.ajax({
          url: "{{ route('schedule.student.store') }}",
          method: "post",
          'beforeSend': function (request) {
            var token = $('meta[name=csrf-token]').attr("content");
            request.setRequestHeader("X-CSRF-TOKEN", token);
          },
          data: data,
          success: function (res) {
            if(res.status == true){
              setTimeout(function() {
                $(location).prop('href', "{{ route('schedule.teacher.registration.success') }}");
              }, 2500);
            }
            $(".loading").hide();
          }
        });
      }
    }

    $(document).on('change', '.cabinId', function(){
      var currentCabin = $(this).val();
      var currentId = $(this).attr('id');
      var selectCabinCount = 0; 

      $('.cabinId').each(function(key, value){
          var getVal = $(value).val();
          var getId = $(value).attr('id');

          if(getVal.length > 0 && currentCabin === getVal){
            selectCabinCount++;
            if(selectCabinCount > 3){
              $("#"+currentId).val('');
              swal.fire(
                'No more than 3 students per cabin.',
                '',
                'warning'
              );
            }
          }
      });
    });

  </script>
  <script src="{{ asset('assets/js/scicon/studentInfo.js') }}"></script>
@endpush