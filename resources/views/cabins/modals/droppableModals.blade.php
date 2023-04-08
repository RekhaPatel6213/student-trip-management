<div class="modal fade" id="assignmentConfictModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1" style="left: unset !important;">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg p-4 pb-2 bg-light">
          <h4 class="mb-2 fs-1">Assignment confict</h4>
        </div>
        <div class="ps-4 w-75 fs--1 text-black">
          <p>You are trying to assign a student with a disability to a standard cabin.</p>
        </div>
      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-info btn-sm d-block fs--1" type="button" onclick="overrideCabin()">Override & assign</button>
          <button class="btn btn-outline-success btn-sm d-block fs--1 ms-2" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="genderConfictModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1" style="left: unset !important;">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg p-4 pb-2 bg-light">
          <h4 class="mb-2 fs-1">Gender confict</h4>
        </div>
        <div class="ps-4 w-75 fs--1 text-black">
          <p class="femaleStudent d-none">You are trying to assign a female student to a male cabin</p>
          <p class="maleStudent d-none">You are trying to assign a male student to a female cabin</p>
        </div>
      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-info btn-sm d-block fs--1" type="button" onclick="overrideGender()">Override & assign</button>
          <button class="btn btn-outline-success btn-sm d-block fs--1 ms-2" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cabinConfictModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1" style="left: unset !important;">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg p-4 pb-2 bg-light">
          <h4 class="mb-2 fs-1">Cabin preference conflict</h4>
        </div>
        <div class="ps-4 w-75 fs--1 text-black">
          <p><span class="studentOne"></span> has the same cabin preference with <span class="studentTwo"></span>. <span class="studentTwo"></span> will also be moved to the new cabin</p>
        </div>
      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-info btn-sm d-block fs--1" type="button" onclick="moveBoth()">Move both</button>
          <button class="btn btn-primary btn-sm d-block fs--1" type="button" onclick="moveOne()">Move one only</button>
          <button class="btn btn-outline-success btn-sm d-block fs--1 ms-2" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  function overrideCabin(){
    var content = draggableUi.draggable.next();
    draggableUi.draggable.draggable('disable').appendTo(currentData);
    content.appendTo(currentData);
    updateCabinAjax(studentId, cabinId, 'disability', 'assignmentConfictModal');
  }

  function overrideGender(){
    var content = draggableUi.draggable.next();
    draggableUi.draggable.draggable('disable').appendTo(currentData);
    content.appendTo(currentData);
    updateCabinAjax(studentId, cabinId, 'gender', 'genderConfictModal');
  }

  function updateCabinAjax(studentId, cabinId, type, modalId){
    $(".loading").show();
    $.ajax({
      url: "{{ route('assignment.cabin.update') }}",
      method: "post",
      'beforeSend': function (request) {
        var token = $('meta[name=csrf-token]').attr("content");
        request.setRequestHeader("X-CSRF-TOKEN", token);
      },
      data: { 
        student_id: studentId,
        cabin_id: cabinId,
        type: type
      },
      success: function (res) {
        swal.fire(
          res.status == true ? "{{__('actions.autosortCabinDone')}}" : "{{__('actions.autosortCabinNotDone')}}",
          res.message,
          res.status == true ? 'success' : 'error'
        );

        $(".loading").hide();
        if(res.status == true){
          $("#"+modalId).modal('hide');
          setTimeout(function() {
            location.reload();
          }, 2500);
        }
      },
      error: function (jqXHR, exception) {
        $(".loading").hide();
      }
    });
  }

  function moveBoth(){}
  function moveOne(){}
</script>
@endpush