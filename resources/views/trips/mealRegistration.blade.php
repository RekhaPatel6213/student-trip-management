@extends('layouts.default')

@push('styles')
<style type="text/css">
.nav-pills .nav-link {
    background: 0 0;
    border: 0;
    border-radius: 0.25rem;
    width: 180px;
    height: 147.47px;
    background: #FFFFFF;
    border: 1px solid #276B64;
    border-radius: 10px;
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;
    text-align: center;
    color: #000000;
    margin-right: 24px;
    display:flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 20px;

  }
   .nav-pills .nav-link.active, .nav-pills .show>.nav-link {        
      background-color: #276b64;      
  }
  .nav-pills .nav-link.active  #studentimg {
    content: url({{asset('/assets/img/icons/student-active.svg')}});
  }
  .nav-pills .nav-link.active  #homeicon {
    content: url({{asset('/assets/img/icons/school-active.png')}});
  }
  .nav-pills .nav-link.active  #caicon {
    content: url({{asset('/assets/img/icons/ca-active.png')}});
  }
  #pargraph1 {
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 21px;

    color: #000000;
  }
</style>
@endpush

@section('content')
  <div class="container-fluid">
    <div class="row min-vh-100 flex-center g-0">
      <div class="col-lg-11 col-xxl-8 py-3 position-relative">
        <h5 class="mb-3 text-nowrap py-2 py-xl-0">Add meal provision</h5>
        <div class="card overflow-hidden z-index-1">
          <div class="card-body p-0">
            <div class="p-3 p-md-4 flex-grow-1">
              <div class="row gx-2 mb-3">
                <div class="mb-3 col-sm-12">
                  <p class="fs-0 fw-bold mb-0" for="instructions">Instructions</p>
                  <p class="fs--1 fw-medium mb-3 fw-semi-bold">Please add detailed information on the students’ meal provision.<br>Please select one of the following options:</p>
                  <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                  <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" onclick="visible()" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">
                    <img src="{{asset('/assets/img/icons/student.svg')}}" id="studentimg" class="mb-2">
                    By Student eligibility status</a></li>
                  <li class="nav-item"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile" onclick="eligibilitysts()" aria-selected="false">
                    <img src="{{asset('/assets/img/icons/school.png')}}" id="homeicon" class="mb-2">
                    By school eligibility status</a></li>
                  <li class="nav-item"><a class="nav-link" id="pill-contact-tab" data-bs-toggle="tab" href="#pill-tab-contact" role="tab" aria-controls="pill-tab-contact" onclick="mealsprogram()" aria-selected="false">
                    <img src="{{asset('/assets/img/icons/ca.png')}}" id="caicon" class="mb-2">
                  California Universal Meals Program</a></li>
                </ul> 
                </div>
                @if($schedules)
                  <ul class="nav nav-tabs" id="registrationTab" role="tablist">
                    @foreach($schedules as $key => $schedule)
                      <li class="nav-item"><a class="nav-link {{ $key === 0 ? 'active' : ''}}" id="class{{$schedule->id}}-tab" data-bs-toggle="tab" href="#tab-class{{$schedule->id}}" role="tab" aria-controls="tab-class{{$schedule->id}}" aria-selected="{{ $key === 0 ? 'true' : 'false'}}">Class {{$key+1}}</a></li>    
                    @endforeach
                  </ul>
                  <div class="tab-content border-x border-bottom p-3 " id="registrationTabContent">
                    @foreach($schedules as $key => $schedule)
                      <div class="tab-pane fade {{ $key === 0 ? 'show active' : ''}}" id="tab-class{{$schedule->id}}" role="tabpanel" aria-labelledby="class{{$schedule->id}}-tab">
                        @include('trips.mealInformation',['schedule' => $schedule, 'key' => $key])
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
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#mealRegistration_1').validate({
        rules: {
          free_amount: {
            required: function(){
                if($('#paidAmount_1').val().length > 0 || $('#reducedAmount_1').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          paid_amount: {
            required: function(){
                if($('#freeAmount_1').val().length > 0 || $('#reducedAmount_1').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          reduced_amount: {
            required: function(){
                if($('#freeAmount_1').val().length > 0 || $('#paidAmount_1').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          "meal_type_1[]": {required: true},
          "meal_amount_1[]": {required: true,number: true},
          meal_name_1 : { required: true, minlength: 3 },
          tesrms_policy_1 : { required: true },
          meal_signature_1 : { required: true, extension: "png|jpe?g|gif", uploadFile:true}
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          if (element.parent().hasClass('has-validation')) {
            element.parent().append(error.addClass('invalid-feedback'));
          } else {
            error.insertAfter(element).addClass('invalid-feedback');
          }
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        }
      });
      $('#mealRegistration_2').validate({
        rules: {
          free_amount: {
            required: function(){
                if($('#paidAmount_2').val().length > 0 || $('#reducedAmount_2').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          paid_amount: {
            required: function(){
                if($('#freeAmount_2').val().length > 0 || $('#reducedAmount_2').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          reduced_amount: {
            required: function(){
                if($('#freeAmount_2').val().length > 0 || $('#paidAmount_2').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          "meal_type_2[]": {required: true},
          "meal_amount_2[]": {required: true,number: true},
          meal_name_2 : { required: true, minlength: 3 },
          meal_signature_2 : { required: true, extension: "png|jpe?g|gif", uploadFile:true},
          tesrms_policy_2 : { required: true }
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          if (element.parent().hasClass('has-validation')) {
            element.parent().append(error.addClass('invalid-feedback'));
          } else {
            error.insertAfter(element).addClass('invalid-feedback');
          }
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        }
      });
      $('#mealRegistration_3').validate({
        rules: {
          free_amount: {
            required: function(){
                if($('#paidAmount_3').val().length > 0 || $('#reducedAmount_3').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          paid_amount: {
            required: function(){
                if($('#freeAmount_3').val().length > 0 || $('#reducedAmount_3').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          reduced_amount: {
            required: function(){
                if($('#freeAmount_3').val().length > 0 || $('#paidAmount_3').val().length > 0)
                    return false;
                else
                    return true;
            },
            number: true
          },
          "meal_type_3[]": {required: true},
          "meal_amount_3[]": {required: true,number: true},
          meal_name_3 : { required: true, minlength: 3 },
          meal_signature_3 : { required: true, extension: "png|jpe?g|gif", uploadFile:true},
          tesrms_policy_3 : { required: true }
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          if (element.parent().hasClass('has-validation')) {
            element.parent().append(error.addClass('invalid-feedback'));
          } else {
            error.insertAfter(element).addClass('invalid-feedback');
          }
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        }
      });
    })

    $(document).on('blur', '.freeAmount', function () {
      var key = $(this).attr('data-id');
      $(".mealType_"+key).val('Free');
      $(".mealTypeText_"+key).text('Free');
      $("#paidAmount_"+key+", #reducedAmount_"+key).val('');
      $(".mealAmount_"+key).val($(this).val());
    });

    $(document).on('blur', '.paidAmount', function () {
      var key = $(this).attr('data-id');
      $(".mealType_"+key).val('Paid');
      $(".mealTypeText_"+key).text('Paid');
      $("#freeAmount_"+key+", #reducedAmount_"+key).val('');
      $(".mealAmount_"+key).val($(this).val());
    });

    $(document).on('blur', '.reducedAmount', function () {
      var key = $(this).attr('data-id');
      $(".mealType_"+key).val('Reduced');
      $(".mealTypeText_"+key).text('Reduced');
      $("#freeAmount_"+key+", #paidAmount_"+key).val('');
      $(".mealAmount_"+key).val($(this).val());
    });

    function reviewMeal(classId, scheduleId) {
      if($('#mealRegistration_'+classId).valid()) {
        if($("#signature64_"+classId).val().length > 0){
          $("#signature_"+classId+"-error").css("display", "none");
          $("#reviewSignature_"+classId).attr("src", $("#signature64_"+classId).val());
        
          $("#reviewMealTitle_"+classId).text($("#mealTitle_"+classId).val());
          $("#freeMealCount").text($('.mealType_'+classId+' option[value="Free"]:selected ').length);
          $("#paidMealCount").text($('.mealType_'+classId+' option[value="Paid"]:selected').length);
          $("#reducedMealCount").text($('.mealType_'+classId+' option[value="Reduced"]:selected').length);
          $("#editMealRegistration_"+classId).addClass('d-none');
          $("#viewMealRegistration_"+classId).removeClass('d-none');
        } else {
          $("#signature_"+classId+"-error").css("display", "block");
        }
      }
    }

    function editMeal(classId, scheduleId) {
      $("#editMealRegistration_"+classId).removeClass('d-none');
      $("#viewMealRegistration_"+classId).addClass('d-none');
    }

    function eligibilitysts() {
     $(".hidestudents").hide();
     $(".hidedefaultpro").show();
     $(".noteshide").hide();
    }

    function mealsprogram() {
      $(".hidestudents").hide();
      $(".hidedefaultpro").hide();
      $(".noteshide").show();
    }

    function visible() {
      $(".hidestudents").show();
      $(".hidedefaultpro").show();
      $(".noteshide").hide();
    }

    function submitMeal(classId, scheduleId) 
    {
      if($('#mealRegistration_'+classId).valid()) {
        $(".loading").show();

        var data = new FormData($('#mealRegistration_'+classId)[0]);
        data.append('student_eligibility',$("input.form-check-input[name=student_eligibility]:checked").val());
        //data.append('meal_signature',$('#mealSignature_'+classId)[0].files[0]);

        $.ajax({
          url: "{{ route('schedule.meal.store') }}",
          method: "POST",
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          'beforeSend': function (request) {
            var token = $('meta[name=csrf-token]').attr("content");
            request.setRequestHeader("X-CSRF-TOKEN", token);
          },
          success: function (res) {
            if(res.status == true){
              swal.fire(
                'Submit!',
                'Meal provision has been submitted successfully.',
                'success'
              );

              setTimeout(function() {
                $(location).prop('href', "{{ route('schedule.meal.success') }}");
              }, 2500);
            }
            $(".loading").hide();
          }
        });
      }
    }
  </script>
@endpush