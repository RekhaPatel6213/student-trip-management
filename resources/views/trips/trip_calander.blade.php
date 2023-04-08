@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | {{ __('message.trips') }}
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
      <div class="row flex-between-center mb-0">
        <div class="col-sm-6 pe-0">
          <h5 class="mb-0 text-nowrap py-2 py-xl-0 mb-3">{{ __('message.trips') }}</h5>
        </div>
        <div class="col-sm-auto text-end ps-2 mb-3">
          <div class="d-flex align-items-center">
            <select class="form-select form-select-sm me-3 w-auto villageType" id="villageType">
              @foreach(config('constants.villageTypes') as $villageName => $villageType)
                <option value="{{ base64_encode(strtolower($villageName)) }}" {{ strtolower($villageName) === $village ? 'selected' : '' }}> {{ ucwords(strtolower($villageType['name'])) }}</option>
              @endforeach
            </select>
            <a href="javascript://" class="btn btn-info btn-sm fs--2 w-auto" type="button" onclick="openInviteSchool('both')" >Pre-Schedule Trip</a>
          </div>
        </div>
      </div>
			<div class="row g-3 mb-3">
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Trips scheduled this year</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$schedules['totalCount']}}</div> 
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Pending Trips</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{($schedules['dayTotalPendingCount'] + $schedules['weekTotalPendingCount'])}}</div> 
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Confirmed Day Trips</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$schedules['dayTotalConfirmedCount']}}</div> 
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Confirmed Week Trips</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$schedules['weekTotalConfirmedCount']}}</div> 
              </div>
            </div>
          </div>
        </div>
        <div class="w-20">
          <div class="card">
            <div class="card-header p-2 pb-0">
              <h5 class="mb-0 mt-1 fs--2">Registered Week Trips</h5>
            </div>
            <div class="card-body p-2">
              <div class="row justify-content-between">
                <div class="fs-0 fw-semi-bold lh-1 mb-1 text-black">{{$schedules['weekTotalRegisteredCount']}}</div> 
              </div>
            </div>
          </div>
        </div>

				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="studentsTable" data-list='{"valueNames":["studentname","schoolcode","tripdate","gender","cabin","eaglepoint"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header border-bottom d-none">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ __('message.trips') }}</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2"></div>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="row flex-between-center mb-0">
                    <div class="col-sm-9">
                      <div class="row flex-between-center">
                        <div class="col-sm-4">
                          <!-- <h5 class="mb-0 text-nowrap py-2 py-xl-0">Calendar</h5> -->
                          <ul class="nav nav-tabs border-0 mb-2" id="tripTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link fs--1 {{ $type === 'day' ? 'active' : ''}}" id="day-trip-tab" data-bs-toggle="tab" href="#tab-day-trip" role="tab" aria-controls="tab-day-trip" aria-selected="true" onclick='location.href = "{{ url('trips/day/'.base64_encode($village))}}"' >Day Trips</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link fs--1 {{ $type === 'week' ? 'active' : ''}}" id="week-trip-tab" data-bs-toggle="tab" href="#tab-week-trip" role="tab" aria-controls="tab-week-trip" aria-selected="true" onclick='location.href = "{{ url('trips/week/'.base64_encode($village))}}"'>Week Trips</a>
                            </li>
                          </ul>
                        </div>
                        <div class="col-sm-auto text-end ps-2">
                          <a class="nav-link text-scicon fs--1" href="{{ route('schedule.calendar.view') }}">Full Calendar</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-auto text-end ps-2">
                      <!-- <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                        <button class="btn btn-sm {{ $type === 'day' ? 'active' : ''}}" type="button" onclick='location.href = "{{ route('trips.index')}}"' >Day Trip</button>
                        <button class="btn btn-sm {{ $type === 'week' ? 'active' : ''}}" type="button" onclick='location.href = "{{ url('trips/week')}}"' >Week Trip</button>
                      </div> -->
                    </div>
                  </div>

                  <div class="tab-pane {{ $type === 'day' ? 'active' : ''}}" role="tabpanel" aria-labelledby="tab-dayTrip" id="dayTrip">
                    @include('trips.dayTrip')
                  </div>
                  <div class="tab-pane {{ $type === 'week' ? 'active' : ''}}" role="tabpanel" aria-labelledby="tab-weekTrip" id="weekTrip">
                    @include('trips.weekTrip')
                  </div>
                </div>
              </div>
          </div>
				</div>
			</div>			
		</div>
	</div>
</main>
@include('trips.modals.inviteSchoolsModal')
@include('trips.modals.tripDetailPendingModal')
@include('trips.modals.tripConfirmModal')
@include('trips.modals.confirmedLetterModal')
@include('trips.modals.billLetterModal')
@include('trips.modals.billLetterViewModal')
@endsection

@push('scripts')
  <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
  <script type="text/javascript">
    var tripdata;
    var weekType;
    var confirmationLatterData;
    var tripView;

    $(document).ready(function () {
      var weekType = 'weekTrip';// $("#weekType").val();
      $(".preferredDate").flatpickr({
        dateFormat: datePickerFormate,
        disableMobile:true,

        "disable": [
          function(date) {
            if(weekType == 'd2Vla1RyaXA=') {
              return (date.getDay() === 0 || date.getDay() === 3 || date.getDay() === 4 || date.getDay() === 5 || date.getDay() === 6);
            } else {
              return (date.getDay() === 0 || date.getDay() === 6);
            }
          }
        ]
      });

      $('#tripDetailEdit').validate({
        rules: {
          status: "required",
          preferredDate: "required",
          teacher: "required",
          studentsEdit: "required",
        },
        messages: {
          status: "{{__('validation.required',['attribute'=>__('message.status')])}}",
          preferredDate: "{{__('validation.required',['attribute'=>__('message.date')])}}",
          teacher: "{{__('validation.required',['attribute'=>__('message.teacher')])}}",
          studentsEdit: "{{__('validation.required',['attribute'=>__('message.student')])}}",
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          error.insertAfter(element).addClass('invalid-feedback');
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        },
      });

      $('#tripConfirmForm').validate({
        rules: {
          confirmation: "required",
          //bill: "required",
        },
        errorPlacement: function(error, element) {
          $(element).addClass('is-invalid');
          if (element.parent().hasClass('form-check')) {
            element.parent().append(error.addClass('invalid-feedback'));
          } else {
            error.insertAfter(element).addClass('invalid-feedback');
          }
        },
        unhighlight: function(element) { // revert the change done by hightlight
          $(element).removeClass('is-invalid').next('div.error').remove();
        },
      });
    });

    
    $(document).on('change', '#villageType', function(){
      var village = $(this).val();
      $(location).prop('href', "{{ url('trips/'.$type.'/:village') }}".replace(/:village/, village));
    });

    function openInviteSchool(type){
      $("#sendNewRequestModal #requestType").val(type);
      $("#sendNewRequestModal").modal('show'); 
    }

    function confirmDate(type, id){
      weekType = type;
      tripView = 'popup';
      getDetails(id, "{{ route('schedule.trip.show',':id') }}");
    }

    function showModal(data){
      tripdata = data;
      cancelEditTrip(data.status)

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

    function editTrip(){
      $(".tripPending, .tripConfirm").addClass('d-none');
      $(".tripEdit").removeClass('d-none');
    }

    function cancelEditTrip(status){
      $(".tripEdit").addClass('d-none');
      if(status == 'Pending'){
        $(".tripPending").removeClass('d-none');
        $(".tripConfirm").addClass('d-none');
      } else if(status == 'Confirmed'){
        $(".tripPending").addClass('d-none');
        $(".tripConfirm").removeClass('d-none');
      } else {
        $(".tripPending").removeClass('d-none');
        $(".tripConfirm").addClass('d-none');
      }

      if(tripView == 'view'){
        $("#tripDetailConfirm, #confirmTrip").addClass('d-none');
      } else {
        $("#tripDetailConfirm, #confirmTrip").removeClass('d-none');
      }
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

                  $(".statusLabel").html(res.data.status);
                  $("#tripDate").html(res.data.trip_date);
                  $(".teacherLabel").html(res.data.teacher);
                  $(".studentNo").html(res.data.students);

                  swal.fire(
                    res.status == true ? "{{__('actions.saved')}}" : "{{__('actions.notSaved')}}",
                    res.message,
                    res.status == true ? 'success' : 'error'
                  );

                  $(".loading").hide();
                  cancelEditTrip(res.data.status);
                }
              });
            }
          });
      }
    }

    function removeTrip(){
        var scheduleId = $(".removeTripBtn").attr('data-id');
        swal.fire({
          title:'Confirm Deleting the trip', //deleteTitle.replace(":page", 'Trip'),
          text:'You are about to delete this trip.The data associated with this trip will be lost.',//deleteSubText,
          //icon:'warning',
          type:"warning",
          showCancelButton:!0,
          confirmButtonText:'Delete', //deleteButton
          cancelButtonText:'Keep', //deleteButton
        }).then(function (e) {
          if (e.value) {
            $(".loading").show();
            $.ajax({
              url: "{{ route('schedule.trip.destroy',':id') }}".replace(/:id/, scheduleId),
              method: "delete",
              'beforeSend': function (request) {
                var token = $('meta[name=csrf-token]').attr("content");
                request.setRequestHeader("X-CSRF-TOKEN", token);
              },
              data:{},
              success: function (res) {
                swal.fire(
                  deletedIcon,
                  res.message,
                  res.result == true ? 'success' : 'error'
                );

                if(res.result == true){
                  location.reload();
                }

                $(".loading").hide();
              }
            });
          }
        });
    }

    function confirmTrip(){
        if($('#tripDetailConfirm').valid()){
          swal.fire({
            title: "{{__('actions.areYouSureWantConfirm')}}",
            text: "",
            icon:'warning',
            type:"warning",
            showCancelButton:!0,
            confirmButtonText:"{{__('actions.confirmButton')}}"
          }).then(function (e) {
            if (e.value) {
              $(".loading").show();
              $.ajax({
                url: "{{ route('schedule.trip.confirm') }}",
                method: "post",
                'beforeSend': function (request) {
                  var token = $('meta[name=csrf-token]').attr("content");
                  request.setRequestHeader("X-CSRF-TOKEN", token);
                },
                data: $("#tripDetailConfirm").serialize(),
                success: function (res) {
                  /*swal.fire(
                    res.status == true ? "{{__('actions.confirmed')}}" : "{{__('actions.notConfirmed')}}",
                    res.message,
                    res.status == true ? 'success' : 'error'
                  );
                  if(res.status == true){
                    //location.reload();
                  }
                  $(".loading").hide();*/
                  $(location).prop('href', "{{ route('schedule.trip.confirm.success') }}");
                }
              });
            }
          });
        }
    }

    function confirmationLatter(){
      if(confirmationLatterData == undefined)
      {
        var emailTemplatesRoute;
        if(weekType == 'week'){
          emailTemplatesRoute = "{{ route('emailTemplates.show','WeekTripConfirmed') }}";
        } else {
          emailTemplatesRoute = "{{ route('emailTemplates.show','DayTripConfirmed') }}";
        }

        $.ajax({
          url:emailTemplatesRoute,
          method: "get",
          beforeSend:function(){
            $('.loading').show();
          },
          success: function (result) {
            $('.loading').hide();
            confirmationLatterData = result.data;
            assignValueConfirmation(confirmationLatterData);
          },
          error: function(xhr, status, error){
            $('.loading').hide();
          }
        })
      } else {
        assignValueConfirmation(confirmationLatterData);
      }
    }

    function assignValueConfirmation(latterData){
      $(".sendConfirmedLetterBtn").attr("data-id", tripdata.id);
      $("#confirmedScheduleId").val(tripdata.id);

      /*latterData.subject = latterData.subject.replace("{type}", weekType);
      latterData.message = latterData.message.replace("{type}", weekType);
                                                            .replace("{first_name}", tripdata.school.principal.first_name)
                                                            .replace("{last_name}", tripdata.school.principal.last_name);*/

      var optionName = tripdata.school.principal.first_name+' '+tripdata.school.principal.last_name+' | '+tripdata.school.name;
      $("#confirmedSchoolPricinpal").empty().append('<option value="'+tripdata.school.principal.id +'" selected>'+optionName +'</option>');
      $("#confirmedSubject").val(latterData.subject);
      tinymce.get("confirmedMessage").setContent(latterData.message);

      $('#confirmedLetterModal').modal('show');
    }

    function getConfirmationLatter(type, id){
      $.ajax({
        url:"{{ route('schedule.trip.show',':id') }}".replace(':id', id), //WeekTripConfirmed
        method: "get",
        beforeSend:function(){
          $('.loading').show();
        },
        success: function (result) {
          tripdata = result.data;
          weekType = type;
          //confirmationLatter()
          if(tripdata.type == 'DAY') {
            $(".billLatterDiv").addClass('d-none');
          } else {
            $(".billLatterDiv").removeClass('d-none');
          }

          $("#tripConfirmModal #scheduleId").val(tripdata.id)
          $("#tripConfirmModal .tripDetailBillView").attr("data-id", tripdata.id);
          $('#tripConfirmModal').modal('show');
          $('.loading').hide();
        },
        error: function(xhr, status, error){
          $('.loading').hide();
        }
      })
    }

    function confirmTripLetter(){
        if($('#tripConfirmForm').valid()){
          swal.fire({
            title: "{{__('actions.areYouSureWantConfirm')}}",
            text: "",
            icon:'warning',
            type:"warning",
            showCancelButton:!0,
            confirmButtonText:"{{__('actions.confirmButton')}}"
          }).then(function (e) {
            if (e.value) {
              $(".loading").show();
              $.ajax({
                url: "{{ route('schedule.trip.confirm') }}",
                method: "post",
                'beforeSend': function (request) {
                  var token = $('meta[name=csrf-token]').attr("content");
                  request.setRequestHeader("X-CSRF-TOKEN", token);
                },
                data: $("#tripConfirmForm").serialize(),
                success: function (res) {
                  /*swal.fire(
                    res.status == true ? "{{__('actions.confirmed')}}" : "{{__('actions.notConfirmed')}}",
                    res.message,
                    res.status == true ? 'success' : 'error'
                  );*/
                  if(res.status == true){
                    location.reload();
                  }
                  $(".loading").hide();
                  //$(location).prop('href', "{{ route('schedule.trip.confirm.success') }}");
                }
              });
            }
          });
        }
    }

    function confirmedLetterSend(className){
      var scheduleId = $("."+className).attr('data-id'); //sendConfirmedLetterBtn
      sendMail(scheduleId, 'Confirmed', 'confirmedLetter');
    }

    function billLatter(className, showView = false){
      var scheduleId = $("."+className).attr('data-id');
      $(".downloadMealBill, .sendBillLetterBtn, .remindBillLetterBtn, .billLetterEditBtn, .billMarkPaidBtn").attr("data-id", scheduleId);
      $("#billScheduleId").val(scheduleId);

      $.ajax({
        url:"{{ route('schedule.trip.bill',':id') }}".replace(':id', scheduleId),
        method: "get",
        beforeSend:function(){
          $('.loading').show();
        },
        success: function (result) {
          $('.loading').hide();
          $('#billMessage, #viewBillMessage').html(result.data)
          $('.billModalTitle').html($('#billMessage #billTilte').val());
          $(".editBillFormate, .viewBillFormate, .billLetterEditBtn, .remindBillLetterBtn, .billMarkPaidBtn").removeClass('d-none');
          $('.billName').removeClass('fw-bold').addClass('fw-medium');

          if(className == 'tripViewBill_'+scheduleId && showView == true){
            $(".editBillFormate").addClass('d-none');
            $('.billName').removeClass('fw-medium').addClass('fw-bold');
            $('.billNameMessage').removeClass('border rounded-3');
            $('#billLetterViewModal').modal('show');
            console.log($(".billStatus").text()+'//'+$(".billStatus").html());
            if($(".billStatus").html() == 'Paid'){
              $('.billLetterEditBtn, .remindBillLetterBtn, .billMarkPaidBtn').addClass('d-none');
            }
          } else {
            $(".viewBillFormate").addClass('d-none');
            $('.billNameMessage').addClass('border rounded-3');
            $('#billLetterModal').modal('show');
          }
        },
        error: function(xhr, status, error){
          $('.loading').hide();
        }
      })
    }

    function downloadBillPdf(className){
      var scheduleId = $("."+className).attr('data-id');
      $.ajax({
        url:"{{ route('schedule.trip.billPDF',':scheduleId') }}".replace(':scheduleId', scheduleId),
        method: "get",
        beforeSend:function(){
          $('.loading').show();
        },
        success: function(response){
          $('.loading').hide();
          var url = response.data.filePath;
          var a = document.createElement('a');
          a.href = url;
          a.download = url;
          document.body.append(a);
          a.click();
          a.remove();
        },
        error: function(blob){
          $('.loading').hide();
          console.log(blob);
        }
      })
    }

    function billLetterSend(className){
      var scheduleId = $("."+className).attr('data-id'); //sendBillLetterBtn
      sendMail(scheduleId, 'Bill', 'billLetter')
    }

    function sendMail(id, type, name){
      $(".loading").show();
      var data = $("#"+name+'Edit').serializeArray();

      if(type == 'Confirmed'){
        data.push({name: 'messageBody', value: tinyMCE.get('confirmedMessage').getContent()});
      }
      data.push({name: 'type', value: type});

      $.ajax({
        url: "{{ route('schedule.trip.mail.send') }}",
        method: "post",
        'beforeSend': function (request) {
          var token = $('meta[name=csrf-token]').attr("content");
          request.setRequestHeader("X-CSRF-TOKEN", token);
        },
        data: data,
        success: function (res) {
          swal.fire(
            res.status == true ? "{{__('actions.send')}}".replace(":page", type+' Letter') : "{{__('actions.notSend')}}".replace(":page", type+' Letter'),
            res.message,
            res.status == true ? 'success' : 'error'
          );

          $(".loading").hide();
          $('#'+name+'Modal').modal('hide');

          if(!$("#tripDetailModal").hasClass('show')){
            location.reload();
          }
        }
      });
    }

    function billLetterEdit(className){
      var scheduleId = $("."+className).attr('data-id');
      $('#billLetterViewModal').modal('hide');
      billLatter('tripViewBill_'+scheduleId, false);
    }

    function billMarkPaid(className){
      var scheduleId = $("."+className).attr('data-id');
      $(".loading").show();
      $.ajax({
        url: "{{ route('schedule.bill.update.status') }}",
        method: "post",
        'beforeSend': function (request) {
          var token = $('meta[name=csrf-token]').attr("content");
          request.setRequestHeader("X-CSRF-TOKEN", token);
        },
        data: {
          'schedule_id': scheduleId,
          'bill_status': 'PAID',
        },
        success: function (res) {
          swal.fire(
            res.status == true ? "{{__('actions.saved')}}" : "{{__('actions.notSaved')}}",
            res.message,
            res.status == true ? 'success' : 'error'
          );

          $(".loading").hide();
          location.reload();
        }
      });
    }

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
          //$(".tripPending, .tripConfirm").addClass('d-none');
          //$(".tripEdit").removeClass('d-none');

          $("#tripDetailConfirm, #confirmTrip").addClass('d-none');
          $('#tripDetailModal').modal('show');
        }
      });
    }

    function confirmListTrip(type, id){
      $(".loading").show();
      $.ajax({
        url: "{{ route('schedule.trip.status.update') }}",
        method: "post",
        'beforeSend': function (request) {
          var token = $('meta[name=csrf-token]').attr("content");
          request.setRequestHeader("X-CSRF-TOKEN", token);
        },
        data: {
          schedule_id: id,
          status: 'REGISTERED',
        },
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
  </script>
@endpush