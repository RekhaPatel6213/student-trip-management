@php
  $name = 'Create';
  $formRoute = route('trips.store');
  $type = $type??'';
  $disabled = '';
  if(isset($trip)){
    $formRoute = route('trips.update', $trip->id);
    $name = 'Update';
    $disabled = 'disabled';
  }
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | {{ $type }} Trip Management > {{ $name }}
@endsection

@section('content')
  <main class="main" id="top">
    <div class="container" data-layout="container">
      <div class="content">
        <div class="row g-3 mb-3">
          <div class="col-md-12 col-xxl-12">
              <div class="card overflow-hidden z-index-1">
                <div class="card-header pb-0">
                  <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ $name }} {{ $type }} Trip</h5>
                    </div>
                    <div class="col-8 col-sm-auto text-end ps-2"></div>
                  </div>
                  @component('components.breadcrumb', ['breadCrumb' => $breadCrumb]) @endcomponent
                </div>
                <div class="card-body bg-light">
                  <div class="row g-0 h-100">
                    <div class="col-md-12 d-flex flex-center">
                      <div class="flex-grow-1">
                        <form method="POST" action="{{ $formRoute }}">
                          @csrf
                          @if(isset($trip))
                            @method('PUT')
                          @endif
                          <input type="hidden" name="trip_id" value="{{ $trip->id ?? '' }}" id="tripId">
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="tripType">Trip Type</label>
                              <div class="px-3">
                                <div class="form-check form-check-inline">
                                  @php
                                    $checked = (old('type') ?? ($trip->type ?? 'WEEK'))
                                  @endphp
                                  <input class="form-check-input" id="tripTypeWeek" type="radio" name="type" value="WEEK" {{ $checked === 'WEEK' ? 'checked' : '' }} {{ $disabled }} />
                                  <label class="form-check-label" for="tripTypeWeek">Week</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" id="tripTypeDay" type="radio" name="type" value="DAY" {{ $checked === 'DAY' ? 'checked' : '' }} {{ $disabled }}/>
                                  <label class="form-check-label" for="tripTypeDay">Day</label>
                                </div>
                              </div>
                              @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="tripStartDate">Start Date</label>
                              <input name="start_date" class="form-control datetimepicker @error('start_date') is-invalid @enderror" id="tripStartDate" type="text" placeholder='{{ config("constants.DATE_FORMATE") }}' value="{{ old('start_date') ?? ($trip->start_date ?? '') }}"/>
                              @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6 {{ $checked !== 'WEEK' ? 'd-none' : ''}}">
                              <label class="form-label" for="tripWeekDay">Week Day</label>
                              <select name="week_day" id="tripWeekDay" class="form-select @error('week_day') is-invalid @enderror">
                                  <option value="">Select District</option>
                                  @foreach(config('constants.weekDays') as $day => $week)
                                    <option value="{{ $day }}" {{ (old('week_day') ?? ($trip->week_day ?? '')) == $day ? "selected" : "" }}> {{ $week }} </option>
                                  @endforeach
                              </select>
                              @error('week_day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>

                          <div class="row gx-2">
                            <div class="mb-3">
                              <label class="form-label" for="tripDescription">Description</label>
                              <input name="description" id="tripDescription" type="text" class="form-control @error('description') is-invalid @enderror" autocomplete="off" value="{{ old('description') ?? ($trip->description ?? '') }}" maxlength="255"/>
                              @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ $name }} Trip</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@push('scripts')
  <script type="text/javascript">
    $('input[type=radio][name=type]').on('change', function() {
      if($(this).val() === 'WEEK'){
        $("#tripWeekDay").parent().removeClass('d-none');
      } else {
        $("#tripWeekDay").parent().addClass('d-none');
      }
    });
  </script>
@endpush