@php
  $name = 'Create';
  $formRoute = route('cabins.store');
  if(isset($cabin)){
    $formRoute = route('cabins.update', $cabin->id);
    $name = 'Update';
  }
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Cabin Management > {{ $name }}
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
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ $name }} Cabin</h5>
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
                          @if(isset($cabin))
                            @method('PUT')
                          @endif
                          <input type="hidden" name="cabin_id" value="{{ $cabin->id ?? '' }}" id="cabinId">
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="cabinName">Cabin Name</label>
                              <input name="name" id="cabinName" type="text" class="form-control @error('name') is-invalid @enderror" autocomplete="off" value="{{ old('name') ?? ($cabin->name ?? '') }}" maxlength="50" />
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="cabinCode">Cabin Code</label>
                              <input name="code" id="cabinCode" type="text" class="form-control @error('code') is-invalid @enderror" autocomplete="off" value="{{ old('code') ?? ($cabin->code ?? '') }}" maxlength="5"/>
                              @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="cabinGender">Eligible Students</label>
                              <input name="eligible_student" id="eligibleStudent" type="number" class="form-control @error('eligible_student') is-invalid @enderror" autocomplete="off" value="{{ old('eligible_student') ?? ($cabin->eligible_student ?? '') }}" min="1" max="20"/>
                              @error('eligible_student')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="isDisability">Is Disability ?</label>
                              @component('components.yesnoradio', ['id' => 'isDisability', 'name' => 'is_disability','checked' => (old('is_disability') ?? ($cabin->is_disability ?? 'NO'))]) @endcomponent
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="cabinGender">Cabin For</label>
                              <div class="px-3">
                                <div class="form-check form-check-inline">
                                  @php
                                    $checked = (old('gender') ?? ($cabin->gender ?? 'Male'))
                                  @endphp
                                  <input class="form-check-input" id="cabinGenderMale" type="radio" name="gender" value="Male" {{ $checked === 'Male' ? 'checked' : '' }}/>
                                  <label class="form-check-label" for="cabinGenderMale">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" id="cabinGenderFemale" type="radio" name="gender" value="Female" {{ $checked === 'Female' ? 'checked' : '' }}/>
                                  <label class="form-check-label" for="cabinGenderFemale">Female</label>
                                </div>
                              </div>
                              @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                              <label class="form-label" for="isEaglePpoint">Is Eagle Point ?</label>
                              @component('components.yesnoradio', ['id' => 'isEaglePpoint', 'name' => 'is_eagle_point','checked' => (old('is_eagle_point') ?? ($cabin->is_eagle_point ?? 'NO'))]) @endcomponent
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ $name }} Cabin</button>
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