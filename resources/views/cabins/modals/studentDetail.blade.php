@php
  $teacherCabins = config('constants.teacherCabins');
@endphp
<div class="modal fade" id="studentDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1" style="left: unset !important;">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 mt-2">

        <div class="rounded-top-lg py-3 pe-6 bg-light">
          <h4 class="mb-2 fs-1">
            <span class="border-left rounded-end-lg me-3 py-2 studentBorder"></span>
            <span class="fas fab fa-accessible-icon fs-0 text-scicon studentDisability"></span>
            <span class="studentName"></span>
          </h4>
        </div>
        <div class="px-4 fs--1 text-black">
          <div class="row">
            <div class="col-3 col-sm-3">School</div>
            <div class="col schoolName"></div>
          </div>
          <div class="row">
            <div class="col-3 col-sm-3">Teacher</div>
            <div class="col teacherName"></div>
          </div>
          <div class="row">
            <div class="col-3 col-sm-3">Sex</div>
            <div class="col studentSex"></div>
          </div>
          <div class="row">
            <div class="col-3 col-sm-3">Disability</div>
            <div class="col"><span class="fas fab fa-accessible-icon fs-0 text-scicon studentDisability"></span></div>
          </div>
          <div class="row">
            <div class="col-3 col-sm-3">Cabin Pref</div>
            <div class="col studentCabin"></div>
          </div>
          <div class="row mb-3">
            <div class="col-3 col-sm-3">Notes</div>
            <div class="col studentNotes"></div>
          </div>
        </div>

      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-secondary btn-sm d-block fs--1" type="button" onclick="editStudentDetail()">Edit</button>
          <button class="tripPending removeTripBtn btn btn-link p-0 ms-2" type="button" title="Delete" data-id="" onclick='removeStudent()'><span class="text-500 fas fa-trash-alt"></span></button>
      </div>
    </div>
  </div>
</div>