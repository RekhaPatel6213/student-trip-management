@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Dashboard
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<!-- <div class="row g-3 mb-3">
				<div class="col-md-4 col-xxl-4">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h5 class="mb-0 mt-2">Total Users</h5>
						</div>
						<div class="card-body d-flex flex-column justify-content-end">
							<div class="row justify-content-between">
								<div class="col-auto align-self-end">
								<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">10</div> <span class="badge rounded-pill fs--2 text-primary"><span class=""></span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xxl-4">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h5 class="mb-0 mt-2">Total</h5>
						</div>
						<div class="card-body d-flex flex-column justify-content-end">
							<div class="row justify-content-between">
							<div class="col-auto align-self-end">
							<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">10</div><span class="badge rounded-pill fs--2 text-primary"><span class=""></span></span>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xxl-4">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<h5 class="mb-0 mt-2">Total</h5>
						</div>
						<div class="card-body d-flex flex-column justify-content-end">
							<div class="row justify-content-between">
								<div class="col-auto align-self-end">
								<div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">10</div><span class="badge rounded-pill fs--2 text-primary"><span class=""></span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> -->			
		</div>
	</div>
</main>
@endsection