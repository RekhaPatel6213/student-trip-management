@php
  $status = \App\Models\Schedule::STATUS;
@endphp
<div class="modal fade" id="mealRequestModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1" style="left: unset !important;">
        <!-- <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-2 fs-1">Request meal information</h4>
          <p class="fs--1 text-black">You added a student to the class that was already registered.<br>Please request the meal information for the new student/s.</p>
        </div>

        <div class="px-4 fs--1 text-black">
          <form class="needs-validation" novalidate id="mealRequestForm" method="POST" role="form">
            <input type="hidden" name="schedule_id" id="scheduleId">
            <input type="hidden" name="class_id" id="classId">

            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.name')}}</div>
              <div class="col">
                <input name="meal_name" id="mealName" type="text" class="form-control form-control-sm w-50" maxlength="50" value="" autocomplete="off" required />
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.email')}}</div>
              <div class="col">
                <input name="meal_email" id="mealEmail" type="email" class="form-control form-control-sm w-50" maxlength="50" value="" autocomplete="off" required />
              </div>
            </div>
            <div class="row gx-2 mb-2">
              <div class="col-3 col-sm-3 fs--1 fw-medium p-1">{{__('message.phone')}}</div>
              <div class="col">
                <input name="meal_phone" id="mealPhone" type="input" class="form-control form-control-sm phonemask w-50" maxlength="50" value="" autocomplete="off" required />
              </div>
            </div>
          </form>
        </div>

      </div>
      <div class="modal-footer border-top-0 justify-content-start">
          <button class="btn btn-primary btn-sm d-block fs--1" type="button" onclick="submitMealRequest()">Request</button>
      </div>
    </div>
  </div>
</div>