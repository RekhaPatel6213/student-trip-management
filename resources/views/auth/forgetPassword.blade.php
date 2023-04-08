@extends('layouts.app')

@section('content')
 <div class="container-fluid">
        <div class="row min-vh-100 flex-center g-0">
          <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape" src="../../../assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img class="bg-auth-circle-shape-2" src="../../../assets/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
            <div class="card overflow-hidden z-index-1">
            	@if (Session::has('message'))
                     <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
              <div class="card-body p-0">
                <div class="row g-0 h-100">
                  <div class="col-md-5 text-center bg-card-gradient">
                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                      <div class="bg-holder bg-auth-card-shape" style="background-image:url(../../../assets/img/icons/spot-illustrations/half-circle.png);">
                      </div>
                      <!--/.bg-holder-->

                      <div class="z-index-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder">SCICON</a>
                        <img class="me-2 main_logo" src="assets/media/logos/logo.png" alt="" width="200" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-7 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                      <div class="text-center text-md-start">
                        <h4 class="mb-0"> Forgot your password?</h4>
                        <p class="mb-4">Enter your email and we'll send you a reset link.</p>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-sm-8 col-md">
                          <form class="mb-3" action="{{ route('forget.password.post') }}" method="POST">
                          	@csrf
                            <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="Email address" />
                            @error('email')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
			             	 @enderror
                            <div class="mb-3"></div>
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Send reset link</button>
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
      </div>
      @endsection
