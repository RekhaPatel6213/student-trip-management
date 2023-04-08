@php
  $schoolTypes = config('constants.schoolTypes');
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | School Management
@endsection

@section('content')

<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="schoolsTable" data-list='{"valueNames":["name","code","type","district"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">School Management</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-schools-actions">
                      <div class="d-flex">
                        <select class="form-select form-select-sm bulk-actions" aria-label="Bulk actions">
                          <option selected="">Bulk actions</option>
                          <option value="Delete">Delete</option>
                        </select>
                      </div>
                    </div>
                    <div id="table-schools-replace-element">
                      <div class="d-flex">
                        <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
                        <a href="{{ route('schools.create') }}">
                          <button class="btn btn-falcon-default btn-sm ms-2" type="button" >
                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                            <span class="d-sm-inline-block ms-1">Create New</span>
                          </button>
                        </a>
                      </div>
                      <!-- <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filter</span></button>
                      <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Export</span></button> -->
                    </div>
                  </div>
                </div>
                @component('components.breadcrumb', ['breadCrumb' => $breadCrumb]) @endcomponent
              </div>
              <div class="card-body p-0">
                <div class="table-responsive scrollbar">
                  <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                    <thead class="bg-200 text-900">
                      <tr>
                        <th>
                          <div class="form-check fs-0 mb-0 d-flex align-items-center">
                            <input class="form-check-input" id="checkbox-bulk-schools-select" type="checkbox" data-bulk-select='{"body":"table-schools-body","actions":"table-schools-actions","replacedElement":"table-schools-replace-element"}' />
                          </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="code">Code</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="type">Type</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="district">District</th>
                        <th class="text-end no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="list" id="table-schools-body">
                      @if(count($schools) > 0)
                        @foreach($schools as $school)
                          <tr class="btn-reveal-trigger" data-id="School#{{ $school->id }}">
                            <td class="align-middle py-2" style="width: 28px;">
                              <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input formCheckClass" type="checkbox" id="school-{{ $school->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $school->id }}"/>
                              </div>
                            </td>
                            <td class="name align-middle white-space-nowrap py-2">
                              <a href="{{ route('schools.edit', $school->id)}}">{{ $school->name }}</a>
                            </td>
                            <td class="code align-middle py-2">{{ $school->code }}</td>
                            <td class="type align-middle white-space-nowrap py-2">{{ $schoolTypes[$school->type] }}</td>
                            <td class="district align-middle py-2">
                              @if($school->district_id)
                                <a href="{{ route('districts.edit', $school->district_id) }}">{{ $school->district->name ?? '' }}</a>
                              @endif
                            </td>
                            <td class="align-middle white-space-nowrap py-2 text-end">
                              <div>
                                <form action="{{ route('schools.destroy', $school->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')

                                  @if($school->email !== null )
                                    @if($school->pre_schedule_send === 'NO')
                                      <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Pre-Schedule Request" onclick="sendNewRequest({{$school->id}})"><span class="text-500 fas fa-envelope"></span></button>
                                    @else
                                      <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Resend Pre-Schedule Request" onclick="sendNewRequest({{$school->id}})"><span class="text-500 fas fa-envelope-open"></span></button>
                                    @endif
                                  @endif

                                  <a href="{{ route('administrators.index', ['schoolId'=>$school->id]) }}" target="_blank"><button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="School Staff"><span class="text-500 fa fa-user-alt"></span></button></a>

                                  <a href="{{ route('schools.edit', $school->id) }}"><button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></button></a>

                                  <button class="btn btn-link p-0" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>
                                </form>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      @else
                      <tr><td colspan="5">No records found.</td></tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer d-flex align-items-center justify-content-center">
                <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="pagination mb-0"></ul>
                <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
              </div>
          </div>
				</div>
			</div>			
		</div>
	</div>
</main>
@endsection

@push('scripts')
  <script type="text/javascript">
    $(".bulk-actions").change(function () {
      if($(this).val() == "Delete"){
        var route = "{{ route('schools.delete.bulk') }}"
        var name =  "{{__('message.school')}}"
        var ids = [];
        $("input.formCheckClass[type=checkbox]:checked").each(function () {
          ids.push($(this).val());
        });
        deleteRecords(route, ids, name);
      }
    });

    function sendNewRequest(schoolId) {
      $.ajax({
        url: "{{ route('schools.send.preSchedule') }}",
        method: "post",
        'beforeSend': function (request) {
          $(".loading").show();
          var token = $('meta[name=csrf-token]').attr("content");
          request.setRequestHeader("X-CSRF-TOKEN", token);
        },
        data: {
          schoolId: schoolId
        },
        success: function (res) {
          swal.fire(
            'Success',
            res.message,
            res.result == true ? 'success' : 'error'
          );
          $(".loading").hide();
        }
      });
    }

  </script>
@endpush