 @php 
  $billFileRoute =  Session::get('billFileRoute') ?? null;
  $allClasses =  Session::get('allClasses') ?? null;
  $teacherRoute = $allClasses !== null ? route('schedule.teacher.registration',[base64_encode(implode('#', array_keys($allClasses)))]) : null;
  $type = $allClasses !== null ? 'week' : 'day';
@endphp

@extends('layouts.admin')

@section('content')
 <div class="container-fluid">
    <div class="row flex-center g-0">
      <div class="col-lg-11 col-xxl-8 position-relative">
        <div class="card overflow-hidden z-index-1">
          <div class="card-body py-5 px-7">
              <div class="text-center">
                <h5 class="mb-4 text-nowrap py-2 py-xl-0 fs-2 fw-bold">Your {{$type}} trips to SCICON are confirmed!</h5>
              </div>
              <div class="text-black">
                <p class="mb-0 fw-bold">Dear {{ \Session::get('principalName') }} Principal, </p>
                <p>you are getting this notification because your {{$type}} trip/s to SCICON were approved and the dates are assigned in our system.<br></p>
                <p class="mb-0 fw-bold">The next step:</p>
                <ol>
                  <li>Please review and process the bill.</li>
                  <li>Once the bill is paid, the teachers will receive a request to confirm the number of students,  provide their names, meal preferences and any additional notes on each student.
                    <br><br>
                    @if($allClasses !== null)
                      @foreach($allClasses as $classKey => $classValue)
                        <p>{{ $classValue}}: <a href="{{ $teacherRoute }}" target="_blank" class="link-black ">{{ $teacherRoute }}</a></p>
                      @endforeach
                    @endif
                  </li>
                </ol>

                <div class="d-flex justify-content-center mt-5">
                    <a href="{{ url('trips/'.$type) }}" class="btn btn-success btn-sm d-block fs--1 reviewBill" type="button">Back</a>

                    @if($billFileRoute !== null)
                      <button class="btn btn-info btn-sm d-block fs--1 reviewBill ms-3" type="button">Review the Bill</button>
                    @endif
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection

@push('scripts')
<script type="text/javascript">
  $('.reviewBill').click(function() {
    window.location = "{{ $billFileRoute }}"
  });
</script>
@endpush