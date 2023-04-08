@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Scheduling
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="studentsTable" data-list='{"valueNames":["studentname","schoolcode","tripdate","gender","cabin","eaglepoint"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">Scheduling</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                  </div>
                </div>
                @component('components.breadcrumb', ['breadCrumb' => $breadCrumb]) @endcomponent
              </div>
              <div class="card-body bg-light">
                <div class="row g-0 h-100">
                  <div class="col-md-12 d-flex flex-center">
                    <div class="flex-grow-1">
                      <div class="row gx-2 mb-3">
                        <div class="mb-3 col-sm-3">
                          <label class="form-label" for="arrivalDate">Arrival Date</label>
                          <input name="arrival_date" class="form-control datetimepicker" id="arrivalDate" type="text" placeholder='{{ config("constants.DATE_FORMATE") }}' value="{{ $arrivalDate ?? '' }}"/>
                        </div>
                        <div class="mb-3 col-sm-3">
                          <label class="form-label" for="weekStartDate">Week Start Date</label>
                          <input name="arrival_date" class="form-control datetimepicker" id="weekStartDate" type="text" placeholder='{{ config("constants.DATE_FORMATE") }}' value="{{ $weekStartDate ?? '' }}"/>
                        </div>
                      
                        <div class="mb-3 col-sm-1"></div>
                      
                        <div class="mb-3 col-sm-5">
                          <div class="row pb-2">
                            <div class="col-sm-8 fs--1 fw-bold">Number of students for this week</div>
                            <div class="col-sm-3 text-center border">{{ $weekStudentCount }}</div>
                          </div>
                          <div class="row">
                            <div class="col-sm-8 fs--1 fw-bold">Number of students for this Year</div>
                            <div class="col-sm-3 text-center border">{{ $yearStudentCount }}</div>
                          </div>
                        </div>
                      </div>

                      <div class="row gx-2">
                        <div class="mb-3 col-sm-3">
                            <a href="{{ route('schedule.student') }}">
                              <button class="btn btn-success btn-sm me-1 mb-1 w-100" type="button">Cabin Sorting</button>
                            </a>
                            <a href="{{ route('schedule.trailgroup') }}">
                              <button class="btn btn-success btn-sm me-1 mb-1 w-100" type="button">Trailgroup Assignment </button>
                            </a>
                            <button class="btn btn-success btn-sm me-1 mb-1 w-100" type="button" disabled>Assign Counselor Cabin</button>
                        </div>
                        <div class="mb-3 col-sm-3">
                          <button class="btn btn-success btn-sm me-1 mb-1 w-100" type="button" disabled>5th Gread Scheduling</button>
                          <button class="btn btn-success btn-sm me-1 mb-1 w-100" type="button" disabled>6th Gread Scheduling</button>
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
	</div>
</main>
@endsection