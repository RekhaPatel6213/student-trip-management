@extends('layouts.default')

@section('content')
<div class="container-fluid">
  <div class="row min-vh-100 flex-center g-0">
    <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape" src="{{ asset('assets/img/icons/spot-illustrations/bg-shape.png') }}" alt="" width="250"><img class="bg-auth-circle-shape-2" src="{{ asset('assets/img/icons/spot-illustrations/shape-1.png') }}" alt="" width="150">
      <div class="card overflow-hidden z-index-1">              

        <div class="card-body p-0">
          <div class="row g-0 h-100">
            <div class="col-md-5 text-center bg-card-gradient">
              <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                <div class="bg-holder bg-auth-card-shape" style='background-image:url("{{ asset('assets/img/icons/spot-illustrations/half-circle.png') }}");''>
                </div>
                <!--/.bg-holder-->

                <div class="z-index-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" >SCICON</a>
                  <img class="me-2 main_logo" src="{{ asset('assets/media/logos/logo.png') }}" alt="" width="200" />
                </div>
              </div>                    
              
            </div>
            <div class="col-md-7 d-flex flex-center">
              <div class="card">
                <div class="card-body p-4 p-sm-5">
                  <div class="fw-black lh-1 text-300 fs-error">404</div>
                  <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold w-md-75 w-xl-100 mx-auto">The page you're looking for is not found.</p>
                  <hr />
                  <p>Make sure the address is correct and that the page hasn't moved. If you think this is a mistake, <a href="mailto:{{ env('CONTACT_MAIL') }}">contact us</a>.</p><a class="btn btn-primary btn-sm mt-3" href="{{ url('/') }}"><span class="fas fa-home me-2"></span>Take me home</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection