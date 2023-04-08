@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | District Management
@endsection

@section('content')

<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="districtsTable" data-list='{"valueNames":["name","code","investment","country"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">District Management</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-districts-actions">
                      <div class="d-flex">
                        <select class="form-select form-select-sm bulk-actions" aria-label="Bulk actions">
                          <option selected="">Bulk actions</option>
                          <option value="Delete">Delete</option>
                        </select>
                      </div>
                    </div>
                    <div id="table-districts-replace-element">
                      <div class="d-flex">
                        <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
                        <a href="{{ route('districts.create') }}">
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
                            <input class="form-check-input" id="checkbox-bulk-districts-select" type="checkbox" data-bulk-select='{"body":"table-districts-body","actions":"table-districts-actions","replacedElement":"table-districts-replace-element"}' />
                          </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="code">Code</th>

                        <th class="sort pe-1 align-middle text-center white-space-nowrap" data-sort="investment">Investment Dist?</th>
                        <th class="sort pe-1 align-middle text-center white-space-nowrap" data-sort="country">In Country?</th>

                        <th class="text-end no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="list" id="table-districts-body">
                      @if(count($districts) > 0)
                        @foreach($districts as $district)
                          <tr class="btn-reveal-trigger" data-id="District#{{ $district->id }}">
                            <td class="align-middle py-2" style="width: 28px;">
                              <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input formCheckClass" type="checkbox" id="district-{{ $district->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $district->id }}"/>
                              </div>
                            </td>
                            <td class="name align-middle white-space-nowrap py-2">
                              <a href="{{ route('districts.edit', $district->id)}}">{{ $district->name }}</a>
                            </td>
                            <td class="code align-middle py-2">{{ $district->code }}</td>
                            <td class="investment align-middle text-center py-2">
                              @if($district->investment === 'YES')
                                <span class="fas fa-check text-success me-1" data-fa-transform="shrink-2"></span>
                              @else
                                <span class="fas fa-times text-danger me-1" data-fa-transform="shrink-2"></span>
                              @endif
                            </td>
                            <td class="country align-middle text-center py-2">
                              @if($district->in_county_budget_category === 'YES')
                                <span class="fas fa-check text-success me-1" data-fa-transform="shrink-2"></span>
                              @else
                                <span class="fas fa-times text-danger me-1" data-fa-transform="shrink-2"></span>
                              @endif</td>
                            <td class="align-middle white-space-nowrap py-2 text-end">
                              <div>
                                <form action="{{ route('districts.destroy', $district->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  
                                  <a href="{{ route('districts.edit', $district->id) }}"><button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></button></a>

                                  <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>
                                </form>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      @else
                      <tr><td colspan="6">No records found.</td></tr>
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
        var route = "{{ route('districts.delete.bulk') }}"
        var name =  "{{__('message.district')}}"
        var ids = [];
        $("input.formCheckClass[type=checkbox]:checked").each(function () {
          ids.push($(this).val());
        });
        deleteRecords(route, ids, name);
      }
    });
  </script>
@endpush