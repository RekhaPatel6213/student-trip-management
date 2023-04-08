<div class="row mb-3 {{ $display ?? ''}}" id="tripClass_{{ $tripId.$id }}">
    <div class="col-md-6 col-lg-4">
      <div class="card border rounded-3">
        <div class="card-header bg-soft-dark fw-bold p-2 ps-3">
          <div class="row flex-between-center">
            <div class="col-4 col-sm-auto d-flex align-items-center ps-3">
              <h5 class="mb-0 text-nowrap py-2 py-xl-0 fs--1 fw-bold">Class {{ $id + 1 }}</h5>
            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
              @if($id !== 0)
                <button class="btn btn-link p-0 ms-2" type="button" title="Delete" id="removeTripClassBtn_{{ $tripId }}" onclick='removeTripClass({{$tripId}}, {{$id}})'><span class="text-500 fas fa-trash-alt"></span></button>
              @endif
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-3">
            <label class="form-label" for="teacher_{{ $tripId.$id }}">{{ __('message.teacher') }} <span class="text-danger">*</span></label>
            <input name="teacher[{{ $tripId }}][{{$id}}]" id="teacher_{{ $tripId.$id }}" type="text" class="form-control" autocomplete="off" maxlength="30" />
          </div>

          <!-- <div class="mb-3">
            <label class="form-label" for="email_{{ $tripId.$id }}">{{ __('message.email') }} <span class="text-danger">*</span></label>
            <input name="email[{{ $tripId }}][{{$id}}]" id="email_{{ $tripId.$id }}" type="email" class="form-control" autocomplete="off" maxlength="50"/>
          </div> -->

          <div class="mb-3">
            <label class="form-label" for="students_{{ $tripId.$id }}">{{ __('message.noOfStudents') }} <span class="text-danger">*</span></label>
            <input name="students[{{ $tripId }}][{{$id}}]" id="students_{{ $tripId.$id }}" type="number" class="form-control" onblur='getstudntno({{$tripId}}, {{$id}})' autocomplete="off" />
          </div>
        </div>
        <div class="alert alert-danger" id="errorMsg" style="display: none;" role="alert">
          <h4 class="alert-heading fw-semi-bold">Alert!</h4>
          <p>You can add maximum 40 no of students only.</p>
        </div>
      </div>
    </div>
  </div>