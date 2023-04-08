@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Email Template Management
@endsection

@section('content')

<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="emailTemplatesTable" data-list='{"valueNames":["name","subject","status"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">Email Template Management</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                    <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
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
                            <input class="form-check-input" id="checkbox-bulk-emailTemplates-select" type="checkbox" data-bulk-select='{"body":"table-emailTemplates-body","actions":"table-emailTemplates-actions","replacedElement":"table-emailTemplates-replace-element"}' />
                          </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="subject">Subject</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">Status</th>
                        <th class="text-end no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="list" id="table-emailTemplates-body">
                      @if(count($emailTemplates) > 0)
                        @foreach($emailTemplates as $emailTemplate)
                          <tr class="btn-reveal-trigger" data-id="EmailTemplate#{{ $emailTemplate->id }}">
                            <td class="align-middle py-2" style="width: 28px;">
                              <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input formCheckClass" type="checkbox" id="emailTemplate-{{ $emailTemplate->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $emailTemplate->id }}"/>
                              </div>
                            </td>
                            <td class="name align-middle white-space-nowrap py-2">
                              <a href="{{ route('emailTemplates.edit', $emailTemplate->id)}}">{{ $emailTemplate->name }}</a>
                            </td>
                            <td class="code align-middle white-space-nowrap py-2">{{ $emailTemplate->subject }}</td>
                            <td class="gender align-middle py-2">{{ ucfirst(strtolower($emailTemplate->status)) }}</td>
                            
                            <td class="align-middle white-space-nowrap py-2 text-end">
                              <div>
                                <a href="{{ route('emailTemplates.edit', $emailTemplate->id) }}"><button class="btn btn-link p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></button></a>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr><td colspan="4">No records found.</td></tr>
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