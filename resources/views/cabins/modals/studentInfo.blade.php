@php
  $teacherCabins = config('constants.teacherCabins');
@endphp
<div class="modal fade" id="studentInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1" style="left: unset !important;">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-2 fs-1">Add New Students</h4>
          <p class="fs--1 text-black">Please add detailed information on the students to confirm the trips.</p>
        </div>

        <div class="px-4 fs--1 text-black">
          <form class="needs-validation" novalidate id="studentInfoForm" method="POST" role="form">
            <input type="hidden" name="schedule_id" id="scheduleId">
            <input type="hidden" name="class_id" id="classId">
            <input type="hidden" id="studentCount" value="0">
            <input type="hidden" name="key" value="1">
            <input type="hidden" name="status" id="scheduleStatus">
            <input type="hidden" name="deleteSchedule" value="false">

            <div class="div-striped mb-3">
              <div id="mainDivOfStudent" class="mainDivOfStudent">
                @include('trips.studentDiv',['student' => null, 'key' => 1, 'sKey' => 0, 'weekYear' => $cutrrentWeek, 'showDelete' => true])
              </div>
              <div id="divOfStudents">
                
              </div>
            </div>
            <a class="py-1 fs--1 font-sans-serif addStudentBtn" href="javascript://" data-id="1" id="addStudentBtn">+ {{ __('message.addStudent') }}</a>
            
          </form>
        </div>

      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-primary btn-sm d-block fs--1" type="button" onclick="submitStudentInfo()">Submit</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $('#studentInfoForm').validate({
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
  });

  $(document).on('click', '.addStudentBtn', function () {
    var classId = $(this).attr('data-id');
    var count = $("#studentCount").val();
    ++count;
    var text = $("#mainDivOfStudent").html();
    text = text.replace(/_0/g,'_'+count);
    text = text.replace('[0]','['+count+']');
    text = text.replace('[0]','['+count+']');
    text = text.replace('studentNote', 'studentNote d-none');
    text = text.replace('addNoteBtn d-none', 'addNoteBtn');
    text = text.replace('removeStudent d-none', 'removeStudent');
    text = text.replace(/error is-invalid/g, 'form-control');
    text = text.replace('<label id="firstName_'+classId+'_'+count+'-error" class="error invalid-feedback" for="firstName_'+classId+'_'+count+'">The First Name field is required.</label>','');
    text = text.replace('<label id="lastName_'+classId+'_'+count+'-error" class="error invalid-feedback" for="lastName_'+classId+'_'+count+'">The Last Name field is required.</label>','');
    text = text.replace('<label id="cabinId_'+classId+'_'+count+'-error" class="error invalid-feedback" for="cabinId_'+classId+'_'+count+'">This field is required.</label>','');
    $("#divOfStudents").append(text);
    $("#studentCount").val(count);

    var cabinId = 'cabinId_'+classId+'_'+count;
    $('#'+cabinId+' option').prop('disabled', false);
    $('#'+cabinId+' option[data-gender="Female"]').prop('disabled', true);
  });

  $(document).on('click', '.removeStudent', function () {
    var classId = $(this).attr('data-class-id');
    var key = $(this).attr('data-key');
    $("#divOfStudents #studentInfo_"+classId).remove();
  });

  function submitStudentInfo() 
  {
    if($('#studentInfoForm').valid()) {
      $(".loading").show();
      submitStudentForm('studentInfoForm', "{{ route('schedule.student.store') }}");
    }
  }
</script>
@endpush