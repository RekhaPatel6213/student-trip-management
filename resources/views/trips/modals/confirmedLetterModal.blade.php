<div class="modal fade" id="confirmedLetterModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-2 fs-1">Template: Letter to pricinpal</h4>
        </div>

        <div class="px-4 fs--1 text-black">
          <form class="needs-validation" novalidate id="confirmedLetterEdit" method="POST" role="form">
            <input type="hidden" name="schedule_id" id="confirmedScheduleId" class="scheduleId">
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-2 fs--1 fw-medium p-1">Pricinpal</div>
              <div class="col">
                <select name="school_pricinpal" id="confirmedSchoolPricinpal" class="form-select form-select-sm w-50" required>
                </select>
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-2 fs--1 fw-medium p-1">Subject Line</div>
              <div class="col">
                <input name="subject" id="confirmedSubject" type="text" class="form-control form-control-sm w-50" value="" autocomplete="off" required />
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-2 fs--1 fw-medium p-1">Teacher</div>
              <div class="col min-vh-50">
                <textarea class="tinymce d-none" name="message" id="confirmedMessage"></textarea>
              </div>
            </div>
           
          </form>
        </div>
      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-info btn-sm d-block fs--1 sendConfirmedLetterBtn" type="button" onclick="confirmedLetterSend('sendConfirmedLetterBtn')">send</button>
          <button class="btn btn-outline-secondary btn-sm d-block fs--1" type="button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>