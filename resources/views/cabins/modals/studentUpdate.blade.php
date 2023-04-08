@php
  $teacherCabins = config('constants.teacherCabins');
@endphp
<div class="modal fade" id="studentUpdateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-2 fs-1">Edit Student Profile</h4>
        </div>

        <div class="px-4 fs--1 text-black">
          <form class="needs-validation" novalidate id="studentUpdateForm" method="POST" role="form">
            <input type="hidden" name="student_id" id="studentId">
            <input type="hidden" name="cutrrentWeek" value="{{$cutrrentWeek}}">

            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.firstName')}}</div>
              <div class="col">
                <input name="first_name" id="firstName" class="form-control form-control-sm" value="" autocomplete="off" required />
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.lastName')}}</div>
              <div class="col">
                <input name="last_name" id="lastName" class="form-control form-control-sm" value="" autocomplete="off" required />
              </div>
            </div>

            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.school')}}</div>
              <div class="col">
                <select name="school_id" id="schoolId" class="form-select form-select-sm" required>
                  <option value="">Select School</option>
                </select>
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.teacher')}}</div>
              <div class="col">
                <input name="teacher" id="teacher" class="form-control form-control-sm" value="" autocomplete="off" required />
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.sex')}}</div>
              <div class="col ms-3 mt-1">
                <div class="form-check form-check-inline px-1 mb-0">
                  <input class="form-check-input" name="gender" id="male" type="radio" value="MALE"/>
                  <label class="form-check-label mb-0" for="male">M</label>
                </div>
                <div class="form-check form-check-inline px-1 mb-0">
                  <input class="form-check-input" name="gender" id="female" type="radio" value="FEMALE"/>
                  <label class="form-check-label mb-0" for="female">F</label>
                </div>
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.disability')}}</div>
              <div class="col">
                <a href="javascript://" class="disabilityChangeBtn">
                  <input type="hidden" name="disability" id="disability" value="">
                  <span class="fas fab fa-accessible-icon mx-2 mt-1 mb-2 fs-1 text-scicon-disable"></span>
                </a>
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.cabin')}} Pref</div>
              <div class="col">
                <select name="cabin_id" id="cabinId" class="form-select form-select-sm">
                  <option value="">No Preference</option>
                  @if($teacherCabins)
                    @foreach($teacherCabins as $gender => $allCabin)
                      @foreach($allCabin as $cabin)
                        <option value="{{ $cabin }}" {{ ($student->teacher_cabin_id ?? '') == $cabin ? "selected" : "" }} data-gender="{{ $gender }}"> {{ $cabin }} </option>
                      @endforeach
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.note')}}</div>
              <div class="col">
                <textarea class="form-control form-control-sm" name="note" id="note" rows="3"></textarea>
              </div>
            </div>
          </form>
        </div>

      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-info btn-sm d-block fs--1" type="button" onclick="saveStudent()">Save Changes</button>
          <button class="btn btn-secondary btn-sm d-block fs--1" type="button"onclick="cancelStudentEdit()">Cancel</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $('#studentUpdateForm').validate({
      rules: {
        'first_name' : { required: true, minlength: 3 },
        'last_name' : { required: true, minlength: 3 },
        'school_id' : { required: true},
        'teacher' : { required: true, minlength: 3 },
        'gender' : { required: true },
      },
      errorPlacement: function(error, element) {
        $(element).addClass('is-invalid');
        error.insertAfter(element).addClass('invalid-feedback');
      },
      unhighlight: function(element) { // revert the change done by hightlight
        $(element).removeClass('is-invalid').next('div.error').remove();
      },
    });
  });

  function saveStudent() 
  {
    if($('#studentUpdateForm').valid()) {
      //$(".loading").show();
      $.ajax({
        url: "{{ route('cabin.student.store',':id') }}".replace(/:id/, $("#studentId").val()),
        method: "post",
        'beforeSend': function (request) {
          var token = $('meta[name=csrf-token]').attr("content");
          request.setRequestHeader("X-CSRF-TOKEN", token);
        },
        data: $("#studentUpdateForm").serializeArray(),
        success: function (res) {
          if(res.status == true){
            location.reload();
          }
        },
        error: function (jqXHR, exception) {
          $(".loading").hide();
          swal.fire(
            'Warning',
            'Please try again...!',
            'warning'
          );
        }
      });
    }
  }

  function cancelStudentEdit() 
  {
    //$("#studentDetailModal").modal('show');
    $("#studentUpdateModal").modal('hide');
  }

  $(document).on('click', '#female, #male', function () {
    var gender = $(this).val();
    var cabinId ="cabinId";

    $('#cabinId option').prop('disabled', false);
    if(gender == 'FEMALE'){
      $('#cabinId option[data-gender="Male"]').prop('disabled', true);
    } else {
      $('#cabinId option[data-gender="Female"]').prop('disabled', true);
    }
  });

  $(document).on('click', '.disabilityChangeBtn', function () {
    var svgimg = $('.fa-accessible-icon');
    var disability = $("#disability").val();

    if(disability == 'NO'){
      $("#disability").val('YES');
      var svgimgClass = svgimg.attr("class").replace('text-scicon-disable', 'text-scicon');
    } else {
      $("#disability").val('NO');
      var svgimgClass = svgimg.attr("class").replace('text-scicon', 'text-scicon-disable');
    }

    svgimg.attr("class", svgimgClass);  
  });
</script>
@endpush