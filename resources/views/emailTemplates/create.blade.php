@php
  $name = 'Create';
  $formRoute = route('emailTemplates.store');
  if(isset($emailTemplate)){
    $formRoute = route('emailTemplates.update', $emailTemplate->id);
    $name = 'Update';
  }
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Email Template Management > {{ $name }}
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
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ $name }} Email Template</h5>
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
                          @if(isset($emailTemplate))
                            @method('PUT')
                          @endif
                          <input type="hidden" name="emailTemplate_id" value="{{ $emailTemplate->id ?? '' }}" id="emailTemplateId">
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-12">
                              <label class="form-label" for="emailTemplateName">Name</label>
                              <input name="name" id="emailTemplateName" type="text" class="form-control" value="{{ old('name') ?? ($emailTemplate->name ?? '') }}" disabled readonly />
                             
                            </div>
                            <div class="mb-3 col-sm-12">
                              <label class="form-label" for="emailTemplateSubject">Subject</label>
                              <input name="subject" id="emailTemplateSubject" type="text" class="form-control @error('subject') is-invalid @enderror" autocomplete="off" value="{{ old('subject') ?? ($emailTemplate->subject ?? '') }}" maxlength="255"/>
                              @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="row gx-2">
                            <div class="mb-3 col-sm-12">
                              <label class="form-label" for="emailTemplateMessage">Message</label>
                              <textarea class="tinymce d-none @error('message') is-invalid @enderror" name="message" id="emailTemplateMessage">{{ old('message') ?? ($emailTemplate->message ?? '') }}</textarea>
                              @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ $name }} Email Template</button>
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
  <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
@endpush