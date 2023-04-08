@php
  $name = 'Create';
  $formRoute = route('users.store');
  if(isset($user)){
    $formRoute = route('users.update', $user->id);
    $name = 'Update';
  }
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | User Management > {{ $name }}
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
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ $name }} User</h5>
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
                          @if(isset($user))
                            @method('PUT')
                          @endif
                          <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}" id="userId">
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userFirstName">First Name</label>
                              <input name="first_name" id="userFirstName" type="text" class="form-control @error('first_name') is-invalid @enderror" autocomplete="off" value="{{ old('first_name') ?? ($user->first_name ?? '') }}" maxlength="30" />
                              @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userLastName">Last Name</label>
                              <input name="last_name" id="userLastName" type="text" class="form-control @error('last_name') is-invalid @enderror" autocomplete="off" value="{{ old('last_name') ?? ($user->last_name ?? '') }}" maxlength="30"/>
                              @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userEmail">Email</label>
                              <input name="email" id="userEmail" type="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" value="{{ old('email') ?? ($user->email ?? '') }}" maxlength="50" />
                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userRole">Role</label>
                              <select name="role_id" id="userRole" class="form-select @error('role_id') is-invalid @enderror">
                                  <option value="">Select Role</option>
                                  @if($roles)
                                    @foreach($roles as $roleId => $roleName)
                                      <option value="{{ $roleId }}" {{ (old('role_id') ?? ($user->role_id ?? '')) == $roleId ? "selected" : "" }}> {{ $roleName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('role_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="birthDate">BirthDate</label>
                              <input name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" id="birthDate" type="text" placeholder='{{ config("constants.DATE_FORMATE") }}' value="{{ old('birth_date') ?? ($user->birth_date ?? '') }}"/>
                              @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6"></div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userPhone">Phone</label>
                              <input name="phone" id="userPhone" type="text" class="form-control phonemask @error('phone') is-invalid @enderror" autocomplete="off" value="{{ old('phone') ?? ($user->phone ?? '') }}" maxlength="14" placeholder="(XXX) XXX-XXXX"/>
                              @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userFax">Fax</label>
                              <input name="fax" id="userFax" type="text" class="form-control phonemask @error('fax') is-invalid @enderror" autocomplete="off" value="{{ old('fax') ?? ($user->fax ?? '') }}" maxlength="14" placeholder="(XXX) XXX-XXXX"/>
                              @error('fax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <h5 class="mb-0">Current Address</h5>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userCStreet">Street</label>
                              <input name="c_street" id="userCStreet" type="text" class="form-control @error('c_street') is-invalid @enderror" autocomplete="off" value="{{ old('c_street') ?? ($user->c_street ?? '') }}" maxlength="30" />
                              @error('c_street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userCStateId">State</label>
                              <select name="c_state_id" id="userCStateId" class="form-select @error('c_state_id') is-invalid @enderror">
                                  <option value="">Select State</option>
                                  @if($states)
                                    @foreach($states as $stateId => $stateName)
                                      <option value="{{ $stateId }}" {{ (old('c_state_id') ?? ($user->c_state_id ?? '')) == $stateId ? "selected" : "" }}> {{ $stateName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('c_state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userCCity">City</label>
                              <select name="c_city_id" id="userCCity" class="form-select @error('c_city_id') is-invalid @enderror">
                                  <option value="">Select City</option>
                                  @if($cities)
                                    @foreach($cities as $cityId => $cityName)
                                      <option value="{{ $cityId }}" {{ (old('c_city_id') ?? ($user->c_city_id ?? '')) == $cityId ? "selected" : "" }}> {{ $cityName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('c_city_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userCZip">Zip</label>
                              <input name="c_zip" id="userCZip" type="text" class="form-control @error('c_zip') is-invalid @enderror" autocomplete="off" value="{{ old('c_zip') ?? ($user->c_zip ?? '') }}" maxlength="30" />
                              @error('c_zip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          
                          <div class="row gx-2">
                            <h5 class="mb-0">Permanent Address</h5>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userPStreet">Street</label>
                              <input name="p_street" id="userPStreet" type="text" class="form-control @error('p_street') is-invalid @enderror" autocomplete="off" value="{{ old('p_street') ?? ($user->p_street ?? '') }}" maxlength="30" />
                              @error('p_street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userPStateId">State</label>
                              <select name="p_state_id" id="userPStateId" class="form-select @error('p_state_id') is-invalid @enderror">
                                  <option value="">Select State</option>
                                  @if($states)
                                    @foreach($states as $stateId => $stateName)
                                      <option value="{{ $stateId }}" {{ (old('p_state_id') ?? ($user->p_state_id ?? '')) == $stateId ? "selected" : "" }}> {{ $stateName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('p_state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userPCity">City</label>
                              <select name="p_city_id" id="userPCity" class="form-select @error('p_city_id') is-invalid @enderror">
                                  <option value="">Select City</option>
                                  @if($cities)
                                    @foreach($cities as $cityId => $cityName)
                                      <option value="{{ $cityId }}" {{ (old('p_city_id') ?? ($user->p_city_id ?? '')) == $cityId ? "selected" : "" }}> {{ $cityName }} </option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('p_city_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div> 
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="userPZip">Zip</label>
                              <input name="p_zip" id="userPZip" type="text" class="form-control @error('p_zip') is-invalid @enderror" autocomplete="off" value="{{ old('p_zip') ?? ($user->p_zip ?? '') }}" maxlength="30" />
                              @error('p_zip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ $name }} User</button>
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
  $("#birthDate").flatpickr({
    dateFormat: datePickerFormate,
    maxDate: "today",
    disableMobile:true,
  });
</script>
@endpush