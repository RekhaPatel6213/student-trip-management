@php
  $status = \App\Models\Schedule::STATUS;
@endphp
<div class="modal fade" id="tripDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-2 fs-1">Trip: <span id="tripDate"></span> <span class="schoolName"></span></h4>
          <span class="badge badge-soft-info rounded-pill fs--2 fw-normal tripPending statusLabel"></span>
          <span class="badge badge-soft-secondary rounded-pill fs--2 fw-normal tripConfirm statusLabel d-none"></span>
        </div>

        <div class="px-4  fs--1 text-black tripPending">
          <div class="row">
            <div class="col-3 col-sm-3">School</div>
            <div class="col schoolName"></div>
          </div>
          <div class="row">
            <div class="col-3 col-sm-3">Teacher</div>
            <div class="col teacherLabel"></div>
          </div>
          <div class="row mb-3">
            <div class="col-3 col-sm-3"># Students</div>
            <div class="col studentNo"></div>
          </div>

          <form class="needs-validation" novalidate id="tripDetailConfirm" method="POST" role="form">
            <input type="hidden" name="schedule_id" id="scheduleId" class="scheduleId">
            <input type="hidden" name="status" value="CONFIRMED">
            
            <div class="form-check mb-0">
              <input name="confirmation" class="form-check-input" id="confirmation" type="checkbox" value="YES" checked="" />
              <label class="form-check-label" for="confirmation">Send <a href="javascript://" onclick="confirmationLatter()" >confirmation</a> to the principal</label>
            </div>
            <div class="form-check mb-0 billLatterDiv d-none">
              <input name="bill" class="form-check-input" id="bill" type="checkbox" value="YES" checked="" />
              <label class="form-check-label" for="bill">Send <a href="javascript://" data-id="" class="tripDetailBill" onclick="billLatter('tripDetailBill')" >bill</a> to the super</label>
            </div>
          </form>
        </div>

        <div class="px-4  fs--1 text-black tripConfirm">
          <div class="row">
            <div class="col-3 col-sm-3">School</div>
            <div class="col schoolName"></div>
          </div>
          <div class="row">
            <div class="col-3 col-sm-3">Teacher</div>
            <div class="col teacherLabel"></div>
          </div>
          <div class="row mb-3">
            <div class="col-3 col-sm-3"># Students</div>
            <div class="col studentNo"></div>
          </div>
        </div>

        <div class="px-4 fs--1 text-black tripEdit d-none">
          <form class="needs-validation" novalidate id="tripDetailEdit" method="POST" role="form">
            <input type="hidden" name="schedule_id" id="scheduleId" class="scheduleId">
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">Status</div>
              <div class="col">
                <select name="status" id="status" class="form-select form-select-sm w-50" required>
                  <option value="">Select Status</option>
                  @if($status)
                    @foreach($status as $statuKey => $statusValue)
                      <option value="{{ $statuKey }}">{{ $statusValue }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">Date</div>
              <div class="col">
                <input name="trip_date" id="preferredDate" type="text" class="form-control form-control-sm w-50 preferredDate" value="" autocomplete="off" required />
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">Teacher</div>
              <div class="col">
                <input name="teacher" id="teacher" class="form-control form-control-sm w-50" value="" autocomplete="off" required />
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1"># Students</div>
              <div class="col">
                <input name="students" id="studentsEdit" class="form-control form-control-sm w-50" maxlength="2" max="99" value="" autocomplete="off" required />
              </div>
            </div>
          </form>
        </div>

      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <!-- <button class="btn btn-secondary btn-sm d-block mt-3 fs--1" type="button" data-bs-dismiss="modal">Cancel</button> -->
          <button class="tripPending btn btn-info btn-sm d-block fs--1" id="confirmTrip" type="button" onclick="confirmTrip()">Confirm Trip</button>
          <button class="tripPending btn btn-secondary btn-sm d-block fs--1" type="button" onclick="editTrip()">Edit</button>
          <button class="tripPending removeTripBtn btn btn-link p-0 ms-2" type="button" title="Delete" data-id="" onclick='removeTrip()'><span class="text-500 fas fa-trash-alt"></span></button>
          
          <button class="tripEdit btn btn-info btn-sm d-block fs--1 d-none" type="button" onclick="saveTrip()">Save Changes</button>
          <button class="tripEdit btn btn-secondary btn-sm d-block fs--1 d-none" type="button"onclick="cancelEditTrip()">Cancel</button>

          <button class="tripConfirm btn btn-secondary btn-sm d-block fs--1 d-none" type="button" onclick="editTrip()">Edit</button>
          <button class="tripConfirm removeTripBtn btn btn-link p-0 ms-2 d-none" type="button" title="Delete" data-id="" onclick='removeTrip()'><span class="text-500 fas fa-trash-alt"></span></button>
      </div>
    </div>
  </div>
</div>