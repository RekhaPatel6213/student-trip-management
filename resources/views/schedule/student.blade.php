@php 
  $boyCount = 0; $totalBoys = count($cabins['boys']);
  $girlCount = 0; $totalGirls = count($cabins['girls']);
@endphp

@extends('layouts.admin')

@section('title')
    {{ config('app.name') }} | Student Scheduling
@endsection

@section('content')
<main class="main" id="top">
	<div class="container" data-layout="container">
		<div class="content">
			<div class="row g-3 mb-3">
				<div class="col-md-12 col-xxl-12">
            <div class="card mb-3" id="studentScheduleTable" data-list='{"valueNames":["studentname","cabin","school"], "filter":true}'>
              <div class="card-header">
                <div class="row flex-between-center">
                  <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0"> Student Scheduling</h5>
                  </div>
                  <div class="col-8 col-sm-auto text-end ps-2"></div>
                </div>
                @component('components.breadcrumb', ['breadCrumb' => $breadCrumb]) @endcomponent
              </div>
              <div class="card-body pt-0">
                <div class="row g-3 mb-3">
                  <div class="col-lg-6" >
                    <div class="row flex-between-end pb-2">
                      <div class="col-auto align-self-center">
                        <div class="d-none" id="table-studentSchedule-actions">
                          <div class="d-flex flex-column">
                            <button class="btn btn-success btn-sm mb-2" type="button" onclick="moveStudent()">Move Student (<span id="SelectedStudentCount"></span>)</button>
                            <div class="d-none moveStudentCabin border p-3"> 
                              <h5 class="mb-3 text-nowrap fs--1">Cabin Assignment:</h5>
                              <select class="form-select form-select-sm mb-3" id="moveCabinId">
                                <option selected="">select Cabin</option>
                                @if($cabins['allCabin'])
                                  @foreach($cabins['allCabin'] as $cabinId => $cabinName)
                                    <option value="{{ $cabinId }}"> {{ $cabinName }} </option>
                                  @endforeach
                                @endif
                              </select>
                              <button class="btn btn-success btn-sm w-100" type="button" id="saveMoveCabin">Save</button>
                            </div>
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
                                  <input class="form-check-input" id="checkbox-bulk-studentSchedule-select" type="checkbox" data-bulk-select='{"body":"table-studentSchedule-body","actions":"table-studentSchedule-actions","replacedElement":"table-studentSchedule-replace-element"}' disabled />
                                </div>
                              </th>
                              <th class="sort pe-1 align-middle white-space-nowrap" data-sort="studentname">Student Name</th>
                              <th class="sort pe-1 align-middle white-space-nowrap" data-sort="cabin">Cabin</th>
                              <th class="text-end sort" data-sort="school">School</th>
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
                                  <td class="school align-middle white-space-nowrap py-2 text-end">{{ $student->school->name }}</td>
                                </tr>
                              @endforeach
                            @else
                            <tr><td colspan="4">No records found.</td></tr>
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row g-3 mb-3 ms-3">
                      <div class="col-lg-6">
                        <h5 class="mb-0 text-nowrap py-2 py-xl-0 mb-3">Boys Village</h5>
                        @if($cabins['boys'])
                          @foreach($cabins['boys'] as $boyCabin)
                            @php $boyCount++; @endphp
                            <div class="row">
                              <div class="col-sm-8 fs--1">{{ $boyCabin->name }}</div>
                              <div class="col-sm-3 text-center border {{ $boyCount === $totalBoys ? '' : 'border-bottom-0' }}">{{ $boyCabin->students_count }}</div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                      <div class="col-lg-6">
                        <h5 class="mb-0 text-nowrap py-2 py-xl-0 mb-3">Girls Villageg</h5>
                        @if($cabins['girls'])
                          @foreach($cabins['girls'] as $girlCabin)
                            @php $girlCount++; @endphp
                            <div class="row">
                              <div class="col-sm-8 fs--1">{{ $girlCabin->name }}</div>
                              <div class="col-sm-3 text-center border {{ $girlCount === $totalGirls ? '' : 'border-bottom-0' }}">{{ $girlCabin->students_count }}</div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                    <div class="row g-3 mb-3 ms-3">
                      <div class="col-lg-6">
                        <div class="row mt-3">
                          <label class="col-sm-8 fs--1 fw-semi-bold">Total Boys</label>
                          <div class="col-sm-3 fw-semi-bold text-center border">{{ $cabins['boysCount'] }}</div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="row mt-3">
                          <label class="col-sm-8 fs--1 fw-semi-bold">Total Girls</label>
                          <div class="col-sm-3 fw-semi-bold text-center border ">{{ $cabins['girlsCount'] }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-lg-6">
                    <h5 class="mb-0 text-nowrap py-2 py-xl-0 mb-3">Swap Cabins</h5>
                      <div class="row gx-2 mb-3">
                        <div class="col-sm-4">
                          <select name="swapCabinOne" id="swapCabinOne" class="form-select fs--1">
                            @if($cabins['allCabin'])
                              @foreach($cabins['allCabin'] as $cabinId => $cabinName)
                                <option value="{{ $cabinId }}"> {{ $cabinName }} </option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                        <div class="col-sm-2 align-self-center fs--1 ">Swap With</div>
                        <div class="col-sm-4">
                          <select name="swapCabinTwo" id="swapCabinTwo" class="form-select fs--1">
                            @if($cabins['allCabin'])
                              @foreach($cabins['allCabin'] as $cabinId => $cabinName)
                                <option value="{{ $cabinId }}"> {{ $cabinName }} </option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                        <div class="col-sm-2">
                          <button class="btn btn-success btn-sm ms-2" type="button" onclick="cabinSwap()">Swap</button>
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

    var $checkboxes = $('input.formCheckClass[type=checkbox]');  
    $checkboxes.change(function(){
      var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
      $('#SelectedStudentCount').text(countCheckedCheckboxes);

      if(countCheckedCheckboxes == 0){
        $(".moveStudentCabin").addClass('d-none');
      }
    });

    function moveStudent() {
      $(".moveStudentCabin").removeClass('d-none');
    }

    $("#saveMoveCabin").click(function(){
        var ids = [];
        $checkboxes.filter(':checked').each(function () {
          ids.push($(this).val());
        });
        //console.log(ids);

        swal.fire({
          title: "{{ __('actions.areYouSureWantMove') }}",
          text:"",
          icon:'warning',
          type:"warning",
          showCancelButton:!0,
          confirmButtonText:"{{ __('actions.moveButton') }}"
        }).then(function (e) {
          if (e.value) {
            $(".loading").show();
            $.ajax({
              url: "{{ route('schedule.move.student') }}",
              method: "post",
              'beforeSend': function (request) {
                var token = $('meta[name=csrf-token]').attr("content");
                request.setRequestHeader("X-CSRF-TOKEN", token);
              },
              data: {
                'studentIds': ids,
                'cabinId': $("#moveCabinId").val()
              },
              success: function (res) {
                var errorMessage = '';
                if(res.status == false && res.data.length > 0){
                  $.each(res.data, function(index, value){
                    errorMessage += value + '<br>';
                  });
                }

                swal.fire(
                  res.status == true ? "{{ __('actions.moved') }}" : "{{ __('actions.notMoved') }}",
                  res.status == true ? res.message : '<div class="fs--1">'+errorMessage+'</div>',
                  res.status == true ? 'success' : 'error'
                );
                $(".loading").hide();

                if(res.status == true){
                  location.reload();
                } else {
                  $('#moveCabinId').removeAttr("selected");
                }
              }
            });
          }
        });
    })

    function cabinSwap() {
      var cabin1 = $("#swapCabinOne").val();
      var cabin2 = $("#swapCabinTwo").val();

      if(cabin1 != cabin2){
        swal.fire({
          title: "{{ __('actions.areYouSureWantSwap') }}",
          text:"",
          icon:'warning',
          type:"warning",
          showCancelButton:!0,
          confirmButtonText:"{{ __('actions.swapButton') }}"
        }).then(function (e) {
          if (e.value) {
            $(".loading").show();
            $.ajax({
              url: "{{ route('schedule.swap.cabin') }}",
              method: "post",
              'beforeSend': function (request) {
                var token = $('meta[name=csrf-token]').attr("content");
                request.setRequestHeader("X-CSRF-TOKEN", token);
              },
              data: {
                'cabin1': cabin1,
                'cabin2': cabin2
              },
              success: function (res) {
                swal.fire(
                  res.status == true ? "{{ __('actions.swaped') }}" : "{{ __('actions.notSwaped') }}",
                  res.message,
                  res.status == true ? 'success' : 'error'
                );
                $(".loading").hide();

                if(res.status == true){
                  location.reload();
                }
              }
            });
          }
        });
      } else {
        swal.fire(
          'Oops...',
          'Please select different Cabin.',
          'error'
        );
      }
    }
  </script>
@endpush