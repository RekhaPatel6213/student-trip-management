@php
  $type = ucfirst(strtolower($type));
  $weekDays = config('constants.weekDays');
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | {{ $type }} Trip Management
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="tripsTable" data-list='{"valueNames":["startdate","weekday","description","status"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ $type }} Trip Management</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-trips-actions">
                      <div class="d-flex">
                        <select class="form-select form-select-sm bulk-actions" aria-label="Bulk actions">
                          <option selected="">Bulk Actions</option>
                          <option value="Delete">Delete</option>
                        </select>
                      </div>
                    </div>
                    <div id="table-trips-replace-element">
                      <div class="d-flex">
                        <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
                        <a href="{{ route('trips.create') }}">
                          <button class="btn btn-falcon-default btn-sm ms-2" type="button" >
                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                            <span class="d-sm-inline-block ms-1">Create New</span>
                          </button>
                        </a>
                      </div>
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
                            <input class="form-check-input" id="checkbox-bulk-trips-select" type="checkbox" data-bulk-select='{"body":"table-trips-body","actions":"table-trips-actions","replacedElement":"table-trips-replace-element"}' />
                          </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="startdate">Start Date</th>
                        @if($type === 'Week')
                          <th class="sort pe-1 align-middle white-space-nowrap" data-sort="weekday">Week Days</th>
                        @endif
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="description">Description</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">Status</th>
                        <th class="text-end no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="list" id="table-trips-body">
                      @if(count($trips) > 0)
                        @foreach($trips as $trip)
                          <tr class="btn-reveal-trigger" data-id="Trip#{{ $trip->id }}">
                            <td class="align-middle py-2" style="width: 28px;">
                              <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input formCheckClass" type="checkbox" id="trip-{{ $trip->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $trip->id }}"/>
                              </div>
                            </td>
                            <td class="startdate align-middle white-space-nowrap py-2">
                              <a href="{{ route('trips.edit', $trip->id)}}">
                                {{ \App\Helpers\Helper::DateFormate($trip->start_date, config("constants.DATE_FORMATE")) }} / {{ $trip->end_date}}
                              </a>
                            </td>
                            @if($type === 'Week')
                              <td class="weekday align-middle white-space-nowrap py-2">{{ $weekDays[$trip->week_day] }}</td>
                            @endif
                            <td class="description align-middle white-space-nowrap py-2">{{ $trip->description }}</td>
                            <td class="status align-middle white-space-nowrap py-2">{{ ucfirst(strtolower($trip->status)) }}</td>
                            <td class="align-middle white-space-nowrap py-2 text-end">
                              <div>
                                <form action="{{ route('trips.destroy', $trip->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')

                                  <a href="{{ route('trips.edit', $trip->id) }}"><button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></button></a>

                                  <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>
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
        var route = "{{ route('trips.delete.bulk') }}"
        var name =  "{{__('message.trip')}}"
        var ids = [];
        $("input.formCheckClass[type=checkbox]:checked").each(function () {
          ids.push($(this).val());
        });
        deleteRecords(route, ids, name);
      }
    });
  </script>
@endpush