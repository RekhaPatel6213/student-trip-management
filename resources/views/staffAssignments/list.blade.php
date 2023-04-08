@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Staff Assignments
@endsection

@section('content')

<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="staffAssignmentsTable" data-list='{"valueNames":["tripDate", "asignments"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">Staff Assignments</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2">
                    <div id="table-staffAssignments-replace-element">
                      <div class="d-flex">
                        <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
                        <a href="{{ route('staffAssignments.create') }}">
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
                            <input class="form-check-input" id="checkbox-bulk-staffAssignments-select" type="checkbox" data-bulk-select='{"body":"table-staffAssignments-body","actions":"table-staffAssignments-actions","replacedElement":"table-staffAssignments-replace-element"}' />
                          </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="tripDate">Schedule Date</th>
                        <th class="pe-1 align-middle white-space-nowrap" data-sort="asignments">Staff Asignments</th>
                        <th class="text-end no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="list" id="table-staffAssignments-body">
                      @php $i=0; @endphp
                      @if(count($staffAssignments) > 0)
                        @foreach($staffAssignments as $tripDate => $assignments)
                        @php 
                          $i++; 
                          $details = '';
                          if($assignments) {
                            foreach($assignments as $assignment) {
                              $details .= '<b>'.$assignment['work'].': </b>'.$assignment['user'].'<br>';
                            }
                          }
                        @endphp
                          <tr class="btn-reveal-trigger" data-id="StaffAssignment#{{$i}}">
                            <td class="align-middle py-2" style="width: 28px;">
                              <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input formCheckClass" type="checkbox" id="staffAssignment-{{$i}}" data-bulk-select-row="data-bulk-select-row" value="{{ $tripDate }}"/>
                              </div>
                            </td>
                            <td class="tripDate align-middle white-space-nowrap py-2">
                              <a href="{{-- route('staffAssignments.edit', $tripDate)--}}">{{ $tripDate }}</a>
                            </td>
                            <td class="asignments align-middle white-space-nowrap py-2 text-truncate" style="max-width: 300px;" data-toggle="tooltip" data-bs-placement="top" title="{{$details}}" data-bs-html="true">
                                @if($assignments)
                                  @foreach($assignments as $assignment)
                                  <span><b>{{$assignment['work']}}:</b> {{$assignment['user']}}<span>,
                                  @endforeach
                                @endif
                            </td>
                            <td class="align-middle white-space-nowrap py-2 text-end">
                              <div class="dropdown font-sans-serif position-static">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-v fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-end border py-0">
                                  <div class="bg-white py-2">
                                    <a  class="dropdown-item" href="{{ route('staffAssignments.edit', base64_encode($tripDate)) }}">Update</a>
                                    <a class="dropdown-item" href="{{ route('staffAssignments.download.PDF', [base64_encode('both'), base64_encode($tripDate)]) }}">Staff Assignment Sheet</a>
                                    <a class="dropdown-item" href="{{ route('staffAssignments.download.PDF', [base64_encode('bear'), base64_encode($tripDate)]) }}">Staff Assignment Sheet (Bear Creek)</a>
                                    <a class="dropdown-item" href="javascript://{{-- route('bulletin.download.PDF', [base64_encode($tripDate)]) --}}" onclick="downloadBulletinPdf('{{base64_encode($tripDate)}}')">SCICON Bulletin</a>
                                  </div>
                                </div>
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

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });

    function downloadBulletinPdf(date){
      $.ajax({
        url:"{{ route('bulletin.download.PDF',':date') }}".replace(':date', date),
        method: "get",
        beforeSend:function(){
          $('.loading').show();
        },
        success: function(response){
          $('.loading').hide();
          if(response.data.schedules == 0){
            swal.fire(
              'Please try another date.',
              'No trip schedule availble for this date.',
              'warning'
            );
          } else {
            var url = response.data.filePath;
            var a = document.createElement('a');
            a.href = url;
            a.download = url;
            document.body.append(a);
            a.click();
            a.remove();
          }
        },
        error: function(blob){
          $('.loading').hide();
        }
      })
    }
  </script>
@endpush