@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Trailgroup Assignment
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="studentScheduleTable" data-list='{"valueNames":["studentname","cabin","school", "trailgroup", "eaglepoint"], "filter":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">Trailgroup Assignment</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2"></div>
                </div>
                @component('components.breadcrumb', ['breadCrumb' => $breadCrumb]) @endcomponent
              </div>
              <div class="card-body pt-0">
                <div class="row g-3 mb-3">
                  <div class="col-lg-12" >
                    @php
                      $villageTypes = config('constants.villageTypes');
                    @endphp

                    @foreach($villageTypes as $name => $type)
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0 mb-3">{{ ucwords(strtolower($type['name'])) }} Trailgroups</h5>
                      <div class="row">
                        @for($i = $type['trail']; $i<= $trailgroups[$name]; $i++)
                          <div class="col-lg-3 {{ $i === 15 ? 'mb-3' : '' }}" >
                            <button class="btn btn-success btn-sm mb-1 w-100" type="button" onclick='assinTrailGroup("{{ $name }}", "{{ $i }}")'>{{ $i }} Trails</button>
                          </div>
                        @endfor
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="row g-3 mb-3">
                  <h5 class="mb-0 text-nowrap py-2 py-xl-0 mt-3">Student List</h5>
                  <div class="col-lg-12" >
                    <div class="row flex-between-end pb-2">
                      <div class="col-auto align-self-center">
                        <div class="d-none" id="table-studentSchedule-actions">
                          <div class="d-flex flex-column">
                            <!-- <button class="btn btn-success btn-sm mb-2" type="button" onclick="updateTrailgroup()">Update Trailgroup</button> -->
                          </div>
                        </div>
                      </div>
                      <div class="col-auto ms-auto">
                        <div id="table-studentSchedule-replace-element ">
                          <div class="d-flex">
                            <input type="search" class="search form-control form-control-sm" placeholder="Search" style="width: auto;"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="scrollbar-overlay border p-1" style="max-height: 20rem">
                      <div class="table-responsive scrollbar ">
                        <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                          <thead class="bg-200 text-900">
                            <tr>
                              <th>
                                <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                  <input class="form-check-input" id="checkbox-bulk-studentSchedule-select" type="checkbox" data-bulk-select='{"body":"table-studentSchedule-body","actions":"table-studentSchedule-actions","replacedElement":"table-studentSchedule-replace-element"}' />
                                </div>
                              </th>
                              <th class="sort pe-1 align-middle white-space-nowrap" data-sort="studentname">Student Name</th>
                              <th class="sort pe-1 align-middle white-space-nowrap" data-sort="cabin">Cabin</th>
                              <th class="sort pe-1 align-middle white-space-nowrap" data-sort="school">School</th>
                              <th class="sort pe-1 align-middle white-space-nowrap" data-sort="trailgroup">TrailGroup</th>
                              <th class="sort text-center" data-sort="eaglepoint">EaglePoint</th>
                            </tr>
                          </thead>
                          <tbody class="list" id="table-studentSchedule-body">
                            @if(count($students) > 0)
                              @foreach($students as $student)
                                <tr class="btn-reveal-trigger" data-id="StudentSchedule#{{ $student->id }}">
                                  <td class="align-middle py-2" style="width: 28px;">
                                    <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                      <input class="form-check-input formCheckClass" type="checkbox" id="administrator-{{ $student->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $student->id }}" data-school="{{ $student->school->id ?? ''}}"/>
                                    </div>
                                  </td>
                                  <td class="studentname align-middle white-space-nowrap py-2">
                                    <a href="{{ route('students.edit', $student->id)}}">{{ $student->full_name }}</a>
                                  </td>
                                  <td class="cabin align-middle py-2">{{ $student->cabin->name ?? '' }}</td>
                                  <td class="school align-middle white-space-nowrap py-2">{{ $student->school->name }}</td>
                                  <td class="trailgroup align-middle white-space-nowrap py-2">{{ $student->trailGroup->name ?? '' }}</td>
                                  <td class="eaglepoint align-middle text-center white-space-nowrap py-2">
                                    @component('components.yesnosign', ['value' => $student->is_eagle_point]) @endcomponent
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

@push('scripts')
  <script type="text/javascript">

    function assinTrailGroup(type, number) {
      $.ajax({
        url: "{{ route('schedule.assign.trailgroup') }}",
        method: "post",
        'beforeSend': function (request) {
          var token = $('meta[name=csrf-token]').attr("content");
          request.setRequestHeader("X-CSRF-TOKEN", token);
        },
        data: {
          'type': type,
          'number': number
        },
        success: function (res) {
          swal.fire(
            res.status == true ? "{{ __('actions.trailgroupAssigned') }}" : "{{ __('actions.trailgroupNotAssigned') }}",
            res.message,
            res.status == true ? 'success' : 'error'
          );
          $(".loading").hide();

          if(res.status == true){
            //location.reload();
          }
        }
      });
    }

    //function updateTrailgroup(){}
  </script>
@endpush