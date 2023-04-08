@php
  $name = 'Create';
  $formRoute = route('schools.store');
  if(isset($school)){
    $formRoute = route('schools.update', $school->id);
    $name = 'Update';
  }
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | School Management > {{ $name }}
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
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ $name }} School</h5>
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
                          @if(isset($school))
                            @method('PUT')
                          @endif
                          <input type="hidden" name="school_id" value="{{ $school->id ?? '' }}" id="schoolId">
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="schoolName">School Name</label>
                              <input name="name" id="schoolName" type="text" class="form-control @error('name') is-invalid @enderror" autocomplete="off" value="{{ old('name') ?? ($school->name ?? '') }}" maxlength="50" />
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="schoolCode">School Code</label>
                              <input name="code" id="schoolCode" type="text" class="form-control @error('code') is-invalid @enderror" autocomplete="off" value="{{ old('code') ?? ($school->code ?? '') }}" maxlength="10"/>
                              @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="schoolDistrictId">School District</label>
                              <select name="district_id" id="schoolDistrictId" class="form-select @error('district_id') is-invalid @enderror">
                                  <option value="">Select District</option>
                                  @if($districts)
                                    @foreach($districts as $districtId => $districtName)
                                      <option value="{{ $districtId }}" {{ (old('district_id') ?? ($school->district_id ?? '')) == $districtId ? "selected" : "" }}> {{ $districtName }} </option>
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
                              <label class="form-label" for="schoolType">School Type</label>
                              <select name="type" id="schoolType" class="form-select @error('type') is-invalid @enderror">
                                  <option value="">Select School Type</option>
                                  @foreach(config('constants.schoolTypes') as $key => $value)
                                    <option value="{{ $key }}" {{ (old('type') ?? ($school->type ?? '')) == $key ? "selected" : "" }}> {{ $value }} </option>
                                  @endforeach
                              </select>
                              @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="schoolEmail">Email</label>
                              <input name="email" id="schoolEmail" type="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" value="{{ old('email') ?? ($school->email ?? '') }}" maxlength="50" />
                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="schoolPhone">Phone</label>
                              <input name="phone" id="schoolPhone" type="text" class="form-control phonemask @error('phone') is-invalid @enderror" autocomplete="off" value="{{ old('phone') ?? ($school->phone ?? '') }}" maxlength="14" placeholder="(XXX) XXX-XXXX"/>
                              @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="schoolFax">Fax</label>
                              <input name="fax" id="schoolFax" type="text" class="form-control phonemask @error('fax') is-invalid @enderror" autocomplete="off" value="{{ old('fax') ?? ($school->fax ?? '') }}" maxlength="14" placeholder="(XXX) XXX-XXXX"/>
                              @error('fax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ $name }} School</button>
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