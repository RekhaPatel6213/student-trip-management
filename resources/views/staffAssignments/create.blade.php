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
              <div class="card overflow-hidden z-index-1">
                <div class="card-header pb-0">
                  <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                      <h5 class="mb-0 text-nowrap py-2 py-xl-0">Staff Assignments</h5>
                    </div>
                    <div class="col-8 col-sm-auto text-end ps-2"></div>
                  </div>
                  @component('components.breadcrumb', ['breadCrumb' => $breadCrumb]) @endcomponent
                </div>
                <div class="card-body bg-light">
                  <div class="row g-0 h-100">
                    <div class="col-md-12 d-flex flex-center">
                      <div class="flex-grow-1">
                        <form method="POST" action="{{ route('staffAssignments.store') }}" id="staffAssignmentForm">
                          @csrf
                          <input type="hidden" name="staff_assignment_id" value="" id="staffAssignmentId">

                          <div class="row gx-2">
                            <h5 class="mb-3">Select {{__('message.scheduleDate')}}</h5>
                            <div class="mb-3 col-sm-6 px-4">
                              <input name="trip_date" id="tripDate" type="text" class="form-control form-control-sm @error('trip_date') is-invalid @enderror" autocomplete="off" value="{{ old('trip_date') ?? ($date ?? '') }}"/>
                              @error('trip_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          
                          @foreach(config('constants.villageTypes') as $typeKey => $typeValue)
                            <div  class="row gx-2 mt-3">
                              <h5 class="mb-3">{{ str_replace('_', ' ', $typeKey) }} Village</h5>
                              @foreach($works->where('is_eagle_point',$typeKey === 'Eagle_Point' ? 'YES' : 'NO') as $key => $work)
                                <div class="mb-3 col-sm-6 px-4">
                                  <label class="form-label" for="userId_{{$key}}">{{$work->name}}</label>
                                  <select name="user_id[{{$work->id}}]" id="userId_{{$key}}" class="form-select form-select-sm usersId {{$typeKey}} @error('user_id') is-invalid @enderror">
                                    <option value="">Select Staff</option>
                                    @if($users)
                                      @foreach($users as $usersId => $usersName)
                                        <option value="{{ $usersId }}"> {{ $usersName }} </option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              @endforeach
                            </div>
                          @endforeach

                          <div  class="row gx-2 mt-3">
                            <h5 class="mb-3">Specials Notes</h5>
                            <div class="mb-3 col-sm-12 px-4" id="specialsNote">
                              <div  class="row gx-2">
                                <div class="col-sm-8">
                                  <input name="notes[1]" id="note_1" type="text" class="form-control form-control-sm" autocomplete="off" maxlength="250" value="" />
                                </div>
                                <div class="col-sm-4">
                                  <button type="button" name="add" id="addBtn" class="btn btn-primary btn-sm">Add More</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3 " type="submit" name="submit">Staff Assignments</button>
                          </div>
                        </form>
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
  $(document).ready(function () {
    $("#tripDate").flatpickr({
      dateFormat: datePickerFormate,
      disableMobile:true,
    });

    var tripDate = "{{ $date ?? '' }}";
    if(tripDate.length > 0){
      $("#tripDate").trigger("change");
    }

    $('#staffAssignmentForm').validate({
      rules: {
        trip_date: "required"
      },
      messages: {
        'trip_date': { 
          required: "{{__('validation.required',['attribute'=>__('message.scheduleDate')])}}",
        }
      },
      errorPlacement: function(error, element) {
        $(element).addClass('is-invalid');
        error.insertAfter(element).addClass('invalid-feedback');
      },
      unhighlight: function(element) { // revert the change done by hightlight
        $(element).removeClass('is-invalid').next('div.error').remove();
      },
    });
    $('.Bear_Creek  ').each(function () {
        $(this).rules('add', {
            require_from_group: [1, '.Bear_Creek']
        });
    });
    $('.Eagle_Point ').each(function () {
        $(this).rules('add', {
            require_from_group: [1, '.Eagle_Point']
        });
    });
  });

  var i = 1;
  $("#addBtn").click(function(){
    ++i;
    var html = '<div  class="row gx-2 mt-2"><div class="col-sm-8">'+
               '<input name="notes['+i+']" id="note_'+i+'" type="text" class="form-control form-control-sm" autocomplete="off" maxlength="250" value=""/>'+
               '</div><div class="col-sm-4">'+
               '<button class="btn btn-link p-0 ms-2 removeBtn" data-id="'+i+'" type="button" title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>'+
               '</div></div>';

    $("#specialsNote").append(html);
  });

  $(document).on('click', '.removeBtn', function(){  
    $(this).parent().parent().remove();
  }); 

  $(document).on('change', '#tripDate', function(){
    $(".loading").show();
    $.ajax({
      url: "{{ route('staffAssignments.schedule.check') }}",
      method: "post",
      'beforeSend': function (request) {
        var token = $('meta[name=csrf-token]').attr("content");
        request.setRequestHeader("X-CSRF-TOKEN", token);
      },
      data: {
        trip_date : $(this).val()
      },
      success: function (res) {
        if(res.status == true && res.data.scheduleCount == 0){
            $("#tripDate").val('');
            swal.fire(
              'Please try another date.',
              'No trip schedule availble for this date.',
              'warning'
            );
        }

        var assignments = res.data.assignments
        if(res.status == true && assignments.length > 0){
          $.map( assignments, function( val, i ) {
            $('[name="user_id[' + val.work_id + ']"]').val(val.user_id);
          });
        }
        $(".loading").hide();
      }
    });
  });

  $(document).on('change', '.usersId', function(){
    var currentUser = $(this).val();
    var currentId = $(this).attr('id');
    var selectUser = []; 
    $('.usersId').each(function(key, value){
        var getVal = $(value).val();
        var getId = $(value).attr('id');
        if($.trim(selectUser.indexOf(getVal)) == -1 && getId !== currentId){
          if(getVal.length > 0){
            if(currentUser === getVal){
              $("#"+currentId).val('');
              swal.fire(
                'Staff already assigned.',
                '',
                'warning'
              );
            } else {
              selectUser.push(getVal);
            }
          }
        }
    });
  }); 
</script>
@endpush