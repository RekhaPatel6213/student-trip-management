@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | User Management
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="usersTable" data-list='{"valueNames":["name","email","role","birthdate"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">User Management</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-users-actions">
                      <div class="d-flex">
                        <select class="form-select form-select-sm bulk-actions" aria-label="Bulk actions">
                          <option selected="">Bulk Actions</option>
                          <option value="Delete">Delete</option>
                        </select>
                      </div>
                    </div>
                    <div id="table-users-replace-element">
                      <div class="d-flex">
                        <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
                        <a href="{{ route('users.create') }}">
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
                            <input class="form-check-input" id="checkbox-bulk-users-select" type="checkbox" data-bulk-select='{"body":"table-users-body","actions":"table-users-actions","replacedElement":"table-users-replace-element"}' />
                          </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">Email</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="role">Role</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="birthdate">Birth Date</th>
                        <th class="text-end no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="list" id="table-users-body">
                      @if(count($users) > 0)
                        @foreach($users as $user)
                          @php
                            $disabled = config('constants.USER_ROLE_ID') === ($user->role_id) ? 'disabled' : '';
                          @endphp

                          <tr class="btn-reveal-trigger" data-id="User#{{ $user->id }}">
                            <td class="align-middle py-2" style="width: 28px;">
                              <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input formCheckClass" type="checkbox" id="user-{{ $user->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $user->id }}" {{ $disabled }}/>
                              </div>
                            </td>
                            <td class="name align-middle white-space-nowrap py-2">
                              <a href="{{ route('users.edit', $user->id)}}">{{ $user->name }}</a>
                            </td>
                            <td class="email align-middle py-2">{{ $user->email }}</td>
                            <td class="working align-middle white-space-nowrap py-2">{{ $user->role->name ?? '' }}</td>
                            <td class="birthdate align-middle py-2">{{ $user->birth_date !== null ? \App\Helpers\Helper::DateFormate($user->birth_date, config("constants.DATE_FORMATE")) : '' }}</td> 
                            <td class="align-middle white-space-nowrap py-2 text-end">
                              <div>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')

                                  <a href="{{ ($disabled !== 'disabled') ?route('users.edit', $user->id) : 'javascript://'}}"><button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" {{ $disabled }}><span class="text-500 fas fa-edit"></span></button></a>

                                  <button class="btn btn-link p-0 ms-2" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" {{ $disabled }}><span class="text-500 fas fa-trash-alt"></span></button>
                                </form>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      @else
                      <tr><td colspan="8">No records found.</td></tr>
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
        var route = "{{ route('users.delete.bulk') }}"
        var name =  "{{__('message.user')}}"
        var ids = [];
        $("input.formCheckClass[type=checkbox]:checked").each(function () {
          if (!$(this).is(':disabled')) {
            ids.push($(this).val());
          }
        });
      }
    });
  </script>
@endpush