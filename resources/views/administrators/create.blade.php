@php
  $name = 'Create';
  $formRoute = route('administrators.store');
  if(isset($administrator)){
    $formRoute = route('administrators.update', $administrator->id);
    $name = 'Update';
  }
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Administrator Management > {{ $name }}
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
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ $name }} Administrator</h5>
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
                          @if(isset($administrator))
                            @method('PUT')
                          @endif
                          <input type="hidden" name="administrator_id" value="{{ $administrator->id ?? '' }}" id="administratorId">
                          <input type="hidden" name="schoolId" value="{{ $schoolId }}">
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorFirstName">First Name</label>
                              <input name="first_name" id="administratorFirstName" type="text" class="form-control @error('first_name') is-invalid @enderror" autocomplete="off" value="{{ old('first_name') ?? ($administrator->first_name ?? '') }}" maxlength="30" />
                              @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorLastName">Last Name</label>
                              <input name="last_name" id="administratorLastName" type="text" class="form-control @error('last_name') is-invalid @enderror" autocomplete="off" value="{{ old('last_name') ?? ($administrator->last_name ?? '') }}" maxlength="30"/>
                              @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorTitle">Title</label>
                              <select name="title" id="administratorTitle" class="form-select @error('title') is-invalid @enderror">
                                  <option value="">Select Title</option>
                                  @foreach(config('constants.administratorTitles') as $titleKey => $title)
                                    <option value="{{ $titleKey }}" {{ in_array( (old('title') ?? ($administrator->title ?? '')) , [$titleKey, $title]) ? "selected" : "" }}> {{ $title }} </option>
                                  @endforeach
                              </select>
                              @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorPosition">Position</label>
                              <select name="position" id="administratorPosition" class="form-select @error('position') is-invalid @enderror">
                                  <option value="">Select Position</option>
                                  @foreach(config('constants.administratorPositions') as $positionKey => $position)
                                    <option value="{{ $positionKey }}" {{ in_array( (old('position') ?? ($administrator->position ?? '')),  [$positionKey, $position]) ? "selected" : "" }}> {{ $position }} </option>
                                  @endforeach
                              </select>
                              @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorEmail">Email</label>
                              <input name="email" id="administratorEmail" type="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" value="{{ old('email') ?? ($administrator->email ?? '') }}" maxlength="50" />
                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorPhone">Phone</label>
                              <input name="phone" id="administratorPhone" type="text" class="form-control phonemask @error('phone') is-invalid @enderror" autocomplete="off" value="{{ old('phone') ?? ($administrator->phone ?? '') }}" maxlength="14" placeholder="(XXX) XXX-XXXX"/>
                              @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorFax">Fax</label>
                              <input name="fax" id="administratorFax" type="text" class="form-control phonemask @error('fax') is-invalid @enderror" autocomplete="off" value="{{ old('fax') ?? ($administrator->fax ?? '') }}" maxlength="14" placeholder="(XXX) XXX-XXXX"/>
                              @error('fax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorDistrictId">District</label>
                              <select name="district_id" id="administratorDistrictId" class="form-select @error('district_id') is-invalid @enderror">
                                  <option value="">Select District</option>
                                  @if($districts)
                                    @foreach($districts as $districtKId => $districtName)
                                      <option value="{{ $districtKId }}" {{ (old('district_id') ?? ($administrator->district_id ?? $districtId)) == $districtKId ? "selected" : "" }}> {{ $districtName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('district_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorSchoolId">School</label>
                              <select name="school_id" id="administratorSchoolId" class="form-select @error('school_id') is-invalid @enderror">
                                  <option value="">Select School</option>
                                  @if($schools)
                                    @foreach($schools as $school)
                                      <option value="{{ $school['id'] }}" data-district="{{ $school['district_id'] }}" {{ (old('school_id') ?? ($administrator->school_id ?? $schoolId)) == $school['id'] ? "selected" : "" }}  {{ isset($administrator->district_id) && ($administrator->district_id !== $school['district_id']) ? 'disabled' : '' }} > {{ $school['name'] }} </option>
                                    @endforeach

                                  @endif
                              </select>
                              @error('school_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorAddress">Address</label>
                              <input name="address" id="administratorAddress" type="text" class="form-control @error('address') is-invalid @enderror" autocomplete="off" value="{{ old('address') ?? ($administrator->address ?? '') }}" maxlength="30" />
                              @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorstateId">State</label>
                              <select name="state_id" id="administratorstateId" class="form-select @error('state_id') is-invalid @enderror">
                                  <option value="">Select State</option>
                                  @if($states)
                                    @foreach($states as $stateId => $stateName)
                                      <option value="{{ $stateId }}" {{ (old('state_id') ?? ($administrator->state_id ?? '')) == $stateId ? "selected" : "" }}> {{ $stateName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorCity">City</label>
                              <select name="city_id" id="administratorCity" class="form-select @error('city_id') is-invalid @enderror">
                                  <option value="">Select City</option>
                                  @if($cities)
                                    @foreach($cities as $cityId => $cityName)
                                      <option value="{{ $cityId }}" {{ (old('city_id') ?? ($administrator->city_id ?? '')) == $cityId ? "selected" : "" }}> {{ $cityName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('city_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="administratorCZip">Zip</label>
                              <input name="zip" id="administratorCZip" type="text" class="form-control @error('zip') is-invalid @enderror" autocomplete="off" value="{{ old('zip') ?? ($administrator->zip ?? '') }}" maxlength="7" />
                              @error('zip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3">
                              <label class="form-label" for="administratorComment">Comment</label>
                              <input name="comments" id="administratorComment" type="text" class="form-control @error('comments') is-invalid @enderror" autocomplete="off" value="{{ old('comments') ?? ($administrator->comments ?? '') }}" maxlength="255"/>
                              @error('comments')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ $name }} Administrator</button>
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
    $('#administratorDistrictId').on('change', function() {
      $('#administratorSchoolId option').removeAttr("selected");
      var districtId =  $(this).val();
      if(districtId > 0){
        $('#administratorSchoolId option').prop('disabled',true);
        $('#administratorSchoolId option[data-district="'+districtId+'"]').prop('disabled',false);
        $("#administratorSchoolId option[value='']").prop('disabled', false);
      } else {
        $('#administratorSchoolId option').prop('disabled',false);
        $("#administratorSchoolId option[value='']").prop('selected', true);
      }
    });
  </script>
@endpush