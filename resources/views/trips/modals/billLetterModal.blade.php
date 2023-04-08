<div class="modal fade" id="billLetterModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-2 fs-1"><span class="billModalTitle"></span></h4>
        </div>

        <div class="px-4 fs--1 text-black">
          <form class="needs-validation" novalidate id="billLetterEdit" method="POST" role="form">
            <input type="hidden" name="schedule_id" id="billScheduleId" class="scheduleId">
            <div class="" id="billMessage"></div>
          </form>
        </div>

      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-info btn-sm d-block fs--1 sendBillLetterBtn" type="button" data-id="" onclick="billLetterSend('sendBillLetterBtn')">send</button>
          <button class="btn btn-outline-secondary btn-sm d-block fs--1" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-outline-secondary btn-sm d-block fs--1 downloadMealBill" data-id="" type="button" onclick="downloadBillPdf('downloadMealBill')">Download PDF</button>
      </div>
    </div>
  </div>
</div>