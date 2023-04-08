@extends('layouts.default')

@push('styles')
<style type="text/css">
  .alert-dismissible .btn-close{
    left: unset;
  }
</style>
@endpush

@section('content')
 <div class="container-fluid">
    <div class="row flex-center g-0">
      <div class="col-lg-11 col-xxl-8 py-3 position-relative">
        <h5 class="mb-3 text-nowrap py-2 py-xl-0">Pre-Schedule Trip to SCICON</h5>
        <div class="card overflow-hidden z-index-1">
          <div class="card-body">
            <div class="d-flex justify-content-center">
              <div class="text-center w-50">
                <img class="mb-5" src="{{ asset('assets/img/icons/success.png') }}" alt="" style="width: 80px;">
                <p class="fs-1 fw-bold text-scicon">Thank you for your submission.</p>
                <p class="fs-0 fw-bold">We will notify you via email after your request is processed and the dates are confirmed.</p>

                <a class="btn btn-primary btn-sm mt-3 w-auto" href="mailto:{{ env('CONTACT_MAIL') }}">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection