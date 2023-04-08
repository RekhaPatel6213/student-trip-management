@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Administrator Management
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="administratorsTable" data-list='{"valueNames":["name","title","position","district", "school", "state", "city"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">Administrator Management</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-administrators-actions">
                      <div class="d-flex">
                        <select class="form-select form-select-sm bulk-actions" aria-label="Bulk actions">
                          <option selected="">Bulk Actions</option>
                          <option value="Delete">Delete</option>
                        </select>
                      </div>
                    </div>
                    <div id="table-administrators-replace-element">
                      <div class="d-flex">
                        <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
                        <a href="{{ route('administrators.create', ['schoolId'=>$schoolId]) }}">
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
                            <input class="form-check-input" id="checkbox-bulk-administrators-select" type="checkbox" data-bulk-select='{"body":"table-administrators-body","actions":"table-administrators-actions","replacedElement":"table-administrators-replace-element"}' />
                          </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="title">Title</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="position">Position</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="district">District</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="school">School</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="state">State</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="city">City</th>
                        <th class="text-end no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="list" id="table-administrators-body">
                      @if(count($administrators) > 0)
                        @foreach($administrators as $administrator)
                          <tr class="btn-reveal-trigger" data-id="Administrator#{{ $administrator->id }}">
                            <td class="align-middle py-2" style="width: 28px;">
                              <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input formCheckClass" type="checkbox" id="administrator-{{ $administrator->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $administrator->id }}"/>
                              </div>
                            </td>
                            <td class="name align-middle white-space-nowrap py-2">
                              <a href="{{ route('administrators.edit',  [$administrator->id, 'schoolId'=>$schoolId])}}">{{ $administrator->full_name }}</a>
                            </td>
                            <td class="title align-middle py-2">{{ $administrator->title }}</td>
                            <td class="position align-middle white-space-nowrap py-2">{{ $administrator->position }}</td>
                            <td class="district align-middle white-space-nowrap py-2">{{ $administrator->district->name }}</td>
                            <td class="school align-middle white-space-nowrap py-2">{{ $administrator->school->name }}</td>
                            <td class="state align-middle white-space-nowrap py-2">{{ $administrator->state->code }}</td>
                            <td class="city align-middle white-space-nowrap py-2">{{ $administrator->city->name }}</td>
                            <td class="align-middle white-space-nowrap py-2 text-end">
                              <div>
                                <form action="{{ route('administrators.destroy', [$administrator->id, 'schoolId'=>$schoolId]) }}" method="POST">
                                  @csrf
                                  @method('DELETE')

                                  <button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick='getAdministratorView("{{ $administrator->id }}")'><span class="text-500 fas fa-eye"></span></button>

                                  <a href="{{ route('administrators.edit',  [$administrator->id, 'schoolId'=>$schoolId]) }}"><button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></button></a>

                                  <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>
                                </form>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      @else
                      <tr><td colspan="9">No records found.</td></tr>
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
@include('administrators.show')
@endsection

@push('scripts')
  <script type="text/javascript">
    $(".bulk-actions").change(function () {
      if($(this).val() == "Delete"){
        var route = "{{ route('administrators.delete.bulk') }}"
        var name =  "{{__('message.administrator')}}"
        var ids = [];
        $("input.formCheckClass[type=checkbox]:checked").each(function () {
          ids.push($(this).val());
        });
        deleteRecords(route, ids, name);
      }
    });

    function getAdministratorView(id) {
      getDetails(id, "{{ route('administrators.show',':id') }}");
    }

    function showModal(data){
        $("#fullName").html(data.full_name);
        $("#firstName").html(data.first_name);
        $("#lastName").html(data.last_name);
        $("#email").html(data.email);
        $("#position").html(data.position);
        $("#title").html(data.title);
        $("#district").html(data.district.name);
        $("#school").html(data.school.name);
        $("#phone").html(data.phone);
        $("#fax").html(data.fax);
        $("#address").html(data.address);
        $("#state").html(data.state.code);
        $("#city").html(data.city.name);
        $("#zip").html(data.zip);
        $("#comments").html(data.comments);
        $('#administratorViewModal').modal('show');
    }
  </script>
@endpush