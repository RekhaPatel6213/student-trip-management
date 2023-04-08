@extends('layouts.default')

@section('content')
 <div class="container-fluid">
    <div class="row flex-center g-0">
      <div class="col-lg-11 col-xxl-8 py-3 position-relative">
        <div class="z-index-1 position-relative d-flex align-items-center mb-3">
          <img class="me-2 main_logo" src="{{ asset('assets/media/logos/logo.png') }}" alt="" width="50" />
          <span class="fs-3 d-inline-block fw-bolder text-scicon">SCICON</span>
        </div>
        <div class="card overflow-hidden z-index-1">
          <div class="card-body py-5 px-10">
            <div class="d-flex justify-content-center">
              <div class="text-center w-50">
                <img class="mb-3" src="{{ asset('assets/img/icons/success.png') }}" alt="" style="width: 80px;">
                <p class="fs-1 fw-bold">Meal provision information submitted successfully</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection