<div class="modal fade" id="tripConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-2 fs-1">Confirm Trip</h4>
        </div>
        <div class="px-4  fs--1 text-black tripPending">
          <form class="needs-validation" novalidate id="tripConfirmForm" method="POST" role="form">
            <input type="hidden" name="schedule_id" id="scheduleId" class="scheduleId">
            <input type="hidden" name="status" value="CONFIRMED">
            
            <div class="form-check mb-0">
              <input name="confirmation" class="form-check-input" id="confirmation" type="checkbox" value="YES" checked="" required />
              <label class="form-check-label mb-0" for="confirmation">Send <a href="javascript://" onclick="confirmationLatter()" >confirmation</a> to the principal</label>
            </div>
            <div class="form-check mb-0 billLatterDiv d-none">
              <input name="bill" class="form-check-input" id="bill" type="checkbox" value="YES" checked="" />
              <label class="form-check-label mb-0" for="bill">Send <a href="javascript://" data-id="" class="tripDetailBillView" data-id="" onclick="billLatter('tripDetailBillView')" >bill</a> to the super</label>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="tripPending btn btn-info btn-sm d-block fs--1" type="button" onclick="confirmTripLetter()">Send</button>
          <button class="btn btn-outline-secondary btn-sm d-block fs--1" type="button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>