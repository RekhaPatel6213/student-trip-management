@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <div class="row min-vh-100 flex-center g-0">
          <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape" src="../../../assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img class="bg-auth-circle-shape-2" src="../../../assets/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
            <div class="card overflow-hidden z-index-1">
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
                      <h3>Register</h3>
                      <form method="POST" action="{{ route('register.custom') }}">
                      	@csrf
                        <div class="mb-3">
                          <label class="form-label" for="card-name">Name</label>
                          <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" autocomplete="on" id="card-name" />
                          @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="card-email">Email address</label>
                          <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" autocomplete="on" id="card-email" />
                          @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div class="row gx-2">
                          <div class="mb-3 col-sm-6">
                            <label class="form-label" for="card-password">Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" autocomplete="on" id="card-password" />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          	@enderror
                          </div>
                          <div class="mb-3 col-sm-6">
                            <label class="form-label" for="card-confirm-password">Confirm Password</label>
                            <input class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" type="password" autocomplete="on" id="card-confirm-password" />
                            @error('confirm-password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          	@enderror
                          </div>
                        </div>
                        <div class="mb-3">
                          <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
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
@endsection