<div id="trip_{{ $tripId }}" class="mb-4 {{ $display ?? ''}}">
  <h5 class="mb-2 text-nowrap fs--1 fw-bold mb-0 text-scicon">Day Trip {{ $tripId + 1 }}</h5>
  <div class="row gx-2">
    <div class="mb-3 col-sm-3">
      <label class="form-label" for="preferredDate_{{ $tripId }}">{{ __('message.preferredDate') }} <span class="text-danger">*</span></label>
      <input name="preferred_date[{{ $tripId }}]" id="preferredDate_{{ $tripId }}" type="text" class="form-control preferredDate" autocomplete="off" />
        <a class="py-1 fs--1 font-sans-serif" href="javascript://" id="">+ Add preferred date</a>
    </div>
  </div>
  <input type="hidden" value="0" id="tripClassCount_{{ $tripId }}">

  @include('schools.preScheduleClass',['tripId' => $tripId, 'id' => 0, 'display' => ''])
  @include('schools.preScheduleClass',['tripId' => $tripId, 'id' => 1, 'display' => 'd-none'])
  @include('schools.preScheduleClass',['tripId' => $tripId, 'id' => 2, 'display' => 'd-none'])

  <a class="py-1 fs--1 font-sans-serif" href="javascript://" id="addTripClassBtn_{{ $tripId }}" onclick='addTripClass({{$tripId}})'>+ Add Class</a>
  <p class="mb-0 fs--2 text-secondary d-none" id="maxTripClassText_{{ $tripId }}">3 classes max per day</p>
</div>